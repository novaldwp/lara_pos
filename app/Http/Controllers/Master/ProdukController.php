<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use App\Produk;
use App\Kategori;

class ProdukController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // set session produk
        Session::put('nav_active', 'master');
        Session::put('sub_active', 'produk');

        // fetch query
        $produk     = Produk::orderBy('produk_id', 'DESC')
                            ->leftJoin('kategori', 'produk.kategori_id', '=', 'kategori.kategori_id')
                            ->select('produk_id', 'produk_kode', 'produk_nama', 'produk_beli', 'produk_jual', 'kategori.kategori_nama', 'produk_gambar')
                            ->get();
        $kategori   = Kategori::orderBy('kategori_nama', 'ASC')->get();

        // ajax request with datatables
        if(request()->ajax()) {
            return datatables()->of($produk)
            ->addColumn('image', function($data){
                $produk_image = $data->produk_gambar;
                if($produk_image == "no_image.png") {
                    $path = url('images/'.$data->produk_gambar);
                }
                else{
                    $path = url('images/produk/'.$data->produk_gambar);
                }

                $image = '
                    <a href="#" id="image-click" data="'.$data->produk_id.'" image='.$path.'>
                        <img alt="'.$data->produk_nama.'" width="36" src="'.$path.'"></img>
                    </a>
                ';

                return $image;
            })
            ->addColumn('action', function($data){
                $button = '
                    <a name="edit" data="'.$data->produk_id.'" id="edit" class="edit btn btn-primary btn-sm">Edit </a>
                ';
                $button .= '
                    &nbsp;&nbsp;
                ';
                $button .= '
                    <a name="delete" data="'.$data->produk_id.'" id="delete" class="delete btn btn-danger btn-sm">Delete </a>
                ';
                return $button;
            })
            ->rawColumns(['action', 'image'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.produk.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // customize rules validation
        $rules = array(
            'produk_nama'   => 'required|string',
            'produk_beli'   => 'required|integer',
            'produk_jual'   => 'required|integer',
            'produk_gambar' => 'mimes:jpeg,png,gif,svg',
            'kategori_id'   => 'required'
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
            'mimes'    => 'Supported format jpeg, png, gif and svg only.'
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        //image config
        $file = $request->file('produk_gambar');
        if($file) {
            // rename of image
            $image   = sha1(time()).".".$file->getClientOriginalExtension();
            // define the path to save image
            $path    = 'images/produk';
            // upload image to path with new name
            $file->move($path, $image);

        }
        else{
            $image = "no_image.png";
        }

        // insert data into database
        $produk = new Produk;
        $produk->produk_gambar  = $image;
        $produk->produk_kode    = $request->input('produk_kode');
        $produk->produk_nama    = $request->input('produk_nama');
        $produk->produk_beli    = $request->input('produk_beli');
        $produk->produk_jual    = $request->input('produk_jual');
        $produk->kategori_id    = $request->input('kategori_id');

        $produk->save();

        return $produk;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $produk = Produk::FindOrFail($id);

        return response()->json($produk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // make new variable input request
        $input = $request->all();
        // customize rules validation
        $rules = array(
            'produk_nama'   => 'required|string',
            'produk_beli'   => 'required|integer',
            'produk_jual'   => 'required|integer',
            'kategori_id'   => 'required|integer',
            'produk_gambar' => 'mimes:jpeg,png,gif,svg'
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
            'mimes'    => 'Supported format jpeg, png, gif and svg only.'
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        // get the data with id
        $produk = Produk::FindOrFail($id);

        // edit upload config
        if ($request->hasfile('produk_gambar'))
        {
            //define variable for produk_gambar input
            $file = $request->file('produk_gambar');
            //rename the image name
            $image  = sha1(time()).'.'.$file->getClientOriginalExtension();
            //path image
            $path   = 'images/produk/';
            // apply the proceed
            $upload = $file->move($path, $image);
            // remove the replacing image
            $old_image = $produk->produk_gambar;
            // if file exists
            if (file_exists($path.$old_image))
            {
                // then remove the old image file
                @unlink($path.$old_image);
            }
        }
        else{
            $image = $produk->produk_gambar;
        }
        //define value of produk_gambar
        $input['produk_gambar'] = $image;
        // update data into database depends on id if no errors
        $produk->update($input);

        //return with alert
        return $produk;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // search the data
        $produk = Produk::FindOrFail($id);

        // config delete the file image define the id

        //path image
        $path       = 'images/produk/';
        //define the file image
        $old_image  = $produk->produk_gambar;
        // if file exists
        if (file_exists($path.$old_image))
        {
            // then remove the old image file
            @unlink($path.$old_image);
        }
        // remove from db
        $produk->delete();


        return response()->json(true);
    }

    public function get_produk_kode()
    {
        $produk_kode = Produk::generate_produk_kode();

        return response()->json($produk_kode);
    }
}

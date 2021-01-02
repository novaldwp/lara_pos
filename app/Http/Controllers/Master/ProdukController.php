<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use App\Models\Master\Produk;
use App\Models\Master\Kategori;
use App\Models\Main\Stok;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProdukController extends Controller
{
    private $oriPath;
    private $thumbPath;
    private $stringCode;

    public function __construct()
    {
        $this->oriPath      = public_path('images/produk');
        $this->thumbPath    = public_path('images/produk/thumb');
        $this->stringCode   = "PRDK";
    }

    public function index()
    {
        // fetch query
        $produk     = Produk::with(['kategori'])
                        ->orderBy('produk_id', 'DESC')
                        ->get();
        $kategori   = Kategori::orderBy('kategori_nama', 'ASC')->get();

        // ajax request with datatables
        if(request()->ajax()) {
            return datatables()->of($produk)
            ->addColumn('image', function($data){
                $thumbPath  = url('images/'.(($data->produk_image == "") ? "no_image.png":"produk/thumb/".$data->produk_image));
                $oriPath    = url('images/'.(($data->produk_image == "") ? "no_image.png":"produk/".$data->produk_image));

                // image via lightbox2 js
                $image  = '
                    <a href="'.$oriPath.'" data-lightbox="image-1">
                        <img src="'.$thumbPath.'" width="80" height="60"></img>
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

        return view('master.produk.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        // customize rules validation
        $rules = array(
            'produk_nama'   => 'required|string',
            'produk_beli'   => 'required|integer',
            'produk_jual'   => 'required|integer',
            'produk_image' => 'mimes:jpg,jpeg,png,gif,svg',
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
        if ($request->hasFile('produk_image'))
        {
            $file   = $request->file('produk_image');

            $image  = $this->uploadImage($file);
        }
        else {
            $image  = "";
        }

        // insert data into database
        $produk = new Produk;
        $produk->produk_image   = $image;
        $produk->produk_kode    = $request->input('produk_kode');
        $produk->produk_nama    = $request->input('produk_nama');
        $produk->produk_beli    = $request->input('produk_beli');
        $produk->produk_jual    = $request->input('produk_jual');
        $produk->kategori_id    = $request->input('kategori_id');
        $produk->save();

        return $this->sendInsert();
    }

    public function edit($id)
    {
        $produk = Produk::FindOrFail($id);

        return response()->json($produk);
    }

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
            'produk_image' => 'mimes:jpg,jpeg,png,gif,svg'
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
        if ($request->hasFile('produk_image'))
        {
            $file   = $request->file('produk_image');
            $image  = $this->uploadImage($file);

            File::delete($this->oriPath.'/'.$produk->produk_image);
            File::delete($this->thumbPath.'/'.$produk->produk_image);
        }
        else{
            $image = $produk->produk_image;
        }

        $produk->update([
            'produk_nama'   => $request->produk_nama,
            'produk_beli'   => $request->produk_beli,
            'produk_jual'   => $request->produk_jual,
            'kategori_id'   => $request->kategori_id,
            'produk_image'  => $image
        ]);

        return $this->sendUpdate();
    }

    public function destroy($id)
    {
        // search the data
        $produk = Produk::FindOrFail($id);

        // check produk image
        if ($produk->produk_image != "") {
            // delete image if produk have it
            File::delete($this->oriPath.'/'.$produk->produk_image);
            File::delete($this->thumbPath.'/'.$produk->produk_image);
        }

        $produk->delete();

        return $this->sendDelete();
    }

    public function getProductCode()
    {
        $produk = Produk::orderBy('produk_kode', 'DESC')
                    ->first();

        if ($produk)
        {
            $string = substr($produk->produk_kode, 7, 1);
            $count  = $string + 1;
        }
        else {
            $count  = 1;
        }

        $digit  = sprintf("%04s", $count);
        $code   = $this->stringCode.$digit;

        return response()->json($code);
    }

    public function uploadImage($img)
    {
        // check directory
        if (!File::isDirectory($this->oriPath))
        {
            // create new if not exist
            File::makeDirectory($this->oriPath, 0777, true, true);
            File::makeDirectory($this->thumbPath, 0777, true, true);
        }

        $imageName  = time().'.'.uniqid().'.'.$img->getClientOriginalExtension();

        $image      = Image::make($img->getRealPath());
        $image->save($this->oriPath.'/'.$imageName);
        $image->resize(180, 180, function($cons)
            {
                $cons->aspectRatio();
            })->save($this->thumbPath.'/'.$imageName);

        return $imageName;
    }

    public function getProductByCode($code)
    {
        $produk = Produk::with(['stok'])->where('produk_kode', $code)->first();

        if($produk)
        {
            return response()->json(['message' => 'Produk berhasil ditemukan.', 'produk' => $produk], 200);
        }
        else {
            return response()->json(['message' => 'Produk tidak ditemukan.'], 404);
        }
    }

    public function getProductById($id)
    {
        $produk = Produk::with(['stok'])->where('produk_id', $id)->first();

        if ($produk)
        {
            return response()->json(['message' => 'Successfully get product.', 'produk' => $produk], 200);
        }
        else {
            return response()->json(['message' => 'Failed get product.'], 404);
        }
    }
}

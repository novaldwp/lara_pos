<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Alert;
use Session;
use App\Models\Master\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // set session kategori
        Session::put('nav_active', 'master');
        Session::put('sub_active', 'kategori');

        $kategori = Kategori::orderBy('kategori_id', 'DESC')->get();

        if(request()->ajax()) {
            return datatables()->of($kategori)
            ->addColumn('action', function($data){
                $button = '
                    <a name="edit" data="'.$data->kategori_id.'" id="edit" class="edit btn btn-primary btn-sm">Edit </a>
                ';
                $button .= '
                    &nbsp;&nbsp;
                ';
                $button .= '
                    <a name="delete" data="'.$data->kategori_id.'" id="delete" class="delete btn btn-danger btn-sm">Delete </a>
                ';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.kategori.index');
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
        $rules = array(
            'kategori_nama' => 'required|string'
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        // insert data into database
        $kategori = new Kategori;
        $kategori->kategori_nama = $request->input('kategori_nama');
        $kategori->save();

        //return with alert
        return response()->json([ 'success' => "Data Berhasil Ditambahkan." ]);
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

        $kategori = Kategori::FindOrFail($id);

        return response()->json($kategori);
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
        // customize rules
        $rules = array(
            'kategori_nama' => 'required|string'
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        // update data into database depends on id
        $kategori = Kategori::FindOrFail($id);
        $kategori->update($input);

        //return with alert
        return response()->json([ 'success' => "Data Berhasil Ditambahkan." ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::FindOrFail($id);
        $kategori->delete();

        return response()->json(true);
    }
}

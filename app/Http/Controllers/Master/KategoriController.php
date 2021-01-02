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
    public function index()
    {
        $kategori = Kategori::orderBy('kategori_id', 'DESC')
                        ->get();

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

        return view('master.kategori.index');
    }

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
        return $this->sendInsert();
    }

    public function edit($id)
    {

        $kategori = Kategori::FindOrFail($id);

        return response()->json($kategori);
    }

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
        return $this->sendUpdate();
    }

    public function destroy($id)
    {
        $kategori = Kategori::FindOrFail($id);
        $kategori->delete();

        return $this->sendDelete();
    }
}

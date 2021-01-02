<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Master\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        // fetch query
        $supplier = Supplier::orderBy('supplier_id', 'DESC')
                        ->get();

        // ajax request with datatables
        if(request()->ajax()) {
            return datatables()->of($supplier)
            ->addColumn('action', function($data){
                $button = '
                    <a name="edit" data="'.$data->supplier_id.'" id="edit" class="edit btn btn-primary btn-sm">Edit </a>
                ';
                $button .= '
                    &nbsp;&nbsp;
                ';
                $button .= '
                    <a name="delete" data="'.$data->supplier_id.'" id="delete" class="delete btn btn-danger btn-sm">Delete </a>
                ';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('master.supplier.index');
    }

    public function store(Request $request)
    {
        // customize rules validation
        $rules = array(
            'supplier_nama'     => 'required|string',
            'supplier_alamat'   => 'required|string',
            'supplier_kontak'   => 'required|string',
            'supplier_phone'    => 'required|string'
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        // insert data into database
        $supplier = new Supplier;
        $supplier->supplier_nama    = $request->input('supplier_nama');
        $supplier->supplier_alamat  = $request->input('supplier_alamat');
        $supplier->supplier_kontak  = $request->input('supplier_kontak');
        $supplier->supplier_phone   = $request->input('supplier_phone');
        $supplier->save();

        return $this->sendInsert();
    }

    public function edit($id)
    {

        $supplier = supplier::FindOrFail($id);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        // make new variable input request
        $input = $request->all();
        // customize rules validation
        $rules = array(
            'supplier_nama'     => 'required|string',
            'supplier_alamat'   => 'required|string',
            'supplier_kontak'   => 'required|string',
            'supplier_phone'    => 'required|string'
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        // update data into database depends on id if no errors
        $supplier = Supplier::FindOrFail($id);
        $supplier->update($input);

        //return with alert
        return $this->sendUpdate();
    }

    public function destroy($id)
    {
        $supplier = Supplier::FindOrFail($id);
        $supplier->delete();

        return $this->sendDelete();
    }
}

<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // set session supplier
        Session::put('nav_active', 'master');
        Session::put('sub_active', 'supplier');

        // fetch query
        $supplier = Supplier::orderBy('supplier_id', 'DESC')->get();

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

        return view('admin.supplier.index');
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
            'supplier_nama' => 'required|string',
            'supplier_alamat' => 'required|string',
            'supplier_kontak' => 'required|string',
            'supplier_telpon' => 'required|string'
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
        $supplier->supplier_telpon  = $request->input('supplier_telpon');
        $supplier->save();

        return $supplier;
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

        $supplier = supplier::FindOrFail($id);

        return response()->json($supplier);
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
            'supplier_nama' => 'required|string',
            'supplier_alamat' => 'required|string',
            'supplier_kontak' => 'required|string',
            'supplier_telpon' => 'required|string'
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
        return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::FindOrFail($id);
        $supplier->delete();

        return response()->json(true);
    }
}

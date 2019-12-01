<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Alert;
use Session;
use App\Member;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // set session member
        Session::put('nav_active', 'member');
        Session::forget('sub_active');
        $tt = Member::get_id_member();
        $member = Member::orderBy('member_id', 'DESC')->get();

        if(request()->ajax()) {
            return datatables()->of($member)
            ->addColumn('member_kelamin', function($data){
                $gender = get_gender($data->member_kelamin);

                return $gender;
            })
            ->addColumn('action', function($data){
                $button = '
                    <a name="edit" data="'.$data->member_id.'" id="edit" class="edit btn btn-primary btn-sm">Edit </a>
                ';
                $button .= '
                    &nbsp;&nbsp;
                ';
                $button .= '
                    <a name="delete" data="'.$data->member_id.'" id="delete" class="delete btn btn-danger btn-sm">Delete </a>
                ';
                return $button;
            })
            ->rawColumns(['action', 'member_kelamin'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.member.index', compact('tt'));
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
            'member_nama' => 'required|string',
            'member_alamat' => 'required|string',
            'member_kelamin' => 'required',
            'member_hp' => 'required'
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        // insert data into database
        $member = new Member;
        $member->member_kode    = $request->input('member_kode');
        $member->member_nama    = $request->input('member_nama');
        $member->member_alamat  = $request->input('member_alamat');
        $member->member_kelamin = $request->input('member_kelamin');
        $member->member_hp      = $request->input('member_hp');

        $member->save();

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

        $member = Member::FindOrFail($id);

        return response()->json($member);
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
            'member_nama' => 'required|string',
            'member_alamat' => 'required|string',
            'member_kelamin' => 'required',
            'member_hp' => 'required|string'

        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        // update data into database depends on id
        $member = Member::FindOrFail($id);
        $member->update($input);

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
        $member = Member::FindOrFail($id);
        $member->delete();

        return response()->json(true);
    }

    public function get_id_member() {

        $member_id = Member::get_id_member();

        return response()->json($member_id);
    }
}

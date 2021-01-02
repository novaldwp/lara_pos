<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Alert;
use Session;
use App\Models\Main\Member;

class MemberController extends Controller
{
    private $stringCode;

    public function __construct()
    {
        $this->stringCode = "MBR";
    }

    public function index()
    {
        $member = Member::orderBy('member_id', 'DESC')
                    ->get();

        if(request()->ajax()) {
            return datatables()->of($member)
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
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('main.member.index');
    }

    public function store(Request $request)
    {
        $rules = array(
            'member_nama'       => 'required|string',
            'member_phone'      => 'required',
            'member_alamat'     => 'required|string'
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
        $member->member_phone   = $request->input('member_phone');
        $member->save();

        //return with alert
        return $this->sendInsert();
    }

    public function edit($id)
    {
        $member = Member::FindOrFail($id);

        return response()->json($member);
    }

    public function update(Request $request, $id)
    {
        // make new variable input request
        $input = $request->all();
        // customize rules
        $rules = array(
            'member_nama' => 'required|string',
            'member_alamat' => 'required|string',
            'member_phone' => 'required'

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
        return $this->sendUpdate();
    }

    public function destroy($id)
    {
        $member = Member::FindOrFail($id);
        $member->delete();

        return $this->sendDelete();
    }

    public function createMemberCode()
    {
        $member = Member::orderBy('member_kode', 'DESC')
                    ->first();

        if ($member)
        {
            $string = substr($member->member_kode, 6, 1);
            $count  = $string + 1;
        }
        else {
            $count  = 1;
        }

        $digit  = sprintf("%04s", $count);
        $code   = $this->stringCode.$digit;

        return response()->json($code);
    }

    public function getMemberByCode($member_kode) {

        $member = Member::where('member_kode', $member_kode)->first();

        if($member)
        {
            $member = $member['member_nama'];

            return response()->json(['message' => 'Data pelanggan berhasil ditemukan.', 'data' => $member], 200);
        }
        else{
            return response()->json(['message' => 'Data pelanggan tidak ditemukan.'], 404);
        }
    }
}

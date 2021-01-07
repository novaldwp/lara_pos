<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Auth;
use Hash;

class UserController extends Controller
{
    private $oriPath;
    private $thumbPath;

    public function __construct()
    {
        $this->oriPath      = public_path('images/user');
        $this->thumbPath    = public_path('images/user/thumb');
    }

    public function index()
    {
        // fetch query
        $user = User::orderBy('id', 'DESC')
                    ->where('id', '!=', Auth::user()->id)
                    ->get();

        // ajax request with datatables
        if(request()->ajax()) {
            return datatables()->of($user)
            ->addColumn('action', function($data){
                if(!Auth::user()->id != $data->id) {
                    $button = '
                        <a name="edit" data="'.$data->id.'" id="edit" class="edit btn btn-primary btn-sm">Edit </a>
                    ';
                    $button .= '
                        &nbsp;&nbsp;
                    ';
                    $button .= '
                        <a name="delete" data="'.$data->id.'" id="delete" class="delete btn btn-danger btn-sm">Delete </a>
                    ';
                }
                else {
                    $button = '';
                }
                return $button;
            })
            ->addColumn('level', function($data){
                $level = get_authority($data->level);

                return $level;
            })
            ->addColumn('image', function($data){
                $thumbPath  = url('images/'.(($data->photo == "") ? "no_avatar.png":"user/thumb/".$data->photo));
                $oriPath    = url('images/'.(($data->photo == "") ? "no_avatar.png":"user/".$data->photo));

                // image via lightbox2 js
                $image  = '
                    <a href="'.$oriPath.'" data-lightbox="image-1">
                        <img src="'.$thumbPath.'" width="80" height="60"></img>
                    </a>
                ';

                return $image;
            })
            ->rawColumns(['action', 'image'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('main.user.index');
    }

    public function store(Request $request)
    {
        // customize rules validation
        $rules = array(
            'username'  => 'required|string|unique:users',
            'name'      => 'required|string',
            'phone'     => 'required|string|unique:users',
            'birthdate' => 'required',
            'level'     => 'required|string',
            'photo'     => 'mimes:jpg,jpeg,png,gif,svg',
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
            'mimes'    => 'Supported format jpeg, png, gif and svg only.'
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        //image config
        if($request->hasFile('photo')) {
            $file   = $request->file('photo');

            $image  = $this->uploadImage($file);
        }
        else{
            $image  = "";
        }

        // set password
        $password   = str_replace("-", "", $request->birthdate);

        // insert data into database
        $user = new User;
        $user->photo        = $image;
        $user->username     = $request->username;
        $user->password     = bcrypt($password);
        $user->name         = $request->name;
        $user->phone        = $request->phone;
        $user->birthdate    = date('Y-m-d', strtotime($request->birthdate));
        $user->level        = $request->level;
        $user->save();

        return $this->sendInsert();
    }

    public function edit($id)
    {
        $user = User::FindOrFail($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // make new variable input request
        $input = $request->except(['username', 'password']);

        // customize rules validation
        $rules = array(
            'name'      => 'required|string',
            'phone'     => 'required|string|unique:users,phone,'.$id,
            'birthdate' => 'required',
            'level'     => 'required|string',
            'photo'     => 'mimes:jpg,jpeg,png,gif,svg',
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
            'mimes'    => 'Supported format jpeg, png, gif and svg only.'
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        // update data into database depends on id if no errors
        $user = User::FindOrFail($id);

        // edit upload config
        if ($request->hasfile('photo'))
        {
            $file   = $request->file('photo');

            $image  = $this->uploadImage($file);

            File::delete($this->oriPath.'/'.$user->photo);
            File::delete($this->thumbPath.'/'.$user->photo);
        }
        else{
            $image = $user->photo;
        }

        //define value of photo
        $input['photo'] = $image;

        // update data into database depends on id if no errors
        $user->update($input);

        return $this->sendUpdate();
    }

    public function destroy($id)
    {
        $user = User::FindOrFail($id);

        if ($user->photo != "") {
            File::delete($this->oriPath.'/'.$user->photo);
            File::delete($this->thumbPath.'/'.$user->photo);
        }

        $user->delete();

        return $this->sendDelete();
    }

    public function editProfile($id)
    {
        $user = User::findOrFail($id);

        return view('main.user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|unique:users,phone,'.$request->id
        ]);

        $user = User::findOrFail($request->id);

        if ($request->hasFile('photo'))
        {
            $file   = $request->file('photo');
            $image  = $this->uploadImage($file);

            if ($user->photo != "")
            {
                File::delete($this->oriPath.'/'.$user->photo);
                File::delete($this->thumbPath.'/'.$user->photo);
            }
        }
        else {
            $image  = $user->photo;
        }

        $user->name     = $request->name;
        $user->phone    = $request->phone;
        $user->photo    = $image;
        $user->save();

        return response()->json(['message' => 'Update Profil Berhasil.', 'user' => $user]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'          => 'required',
            'password'              => 'required|min:3|confirmed',
            'password_confirmation' => 'required|same:password|min:3'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->old_password, $user->password))
        {
            return response()->json([
                'message' => 'The old password you entered is incorrect.',
                'errors' => ['old_password' => 'The old password does not match our records.']
            ], 400);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Successfully update password.']);
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
}

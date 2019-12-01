<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // set session supplier
        Session::put('nav_active', 'user');
        Session::forget('sub_active');

        // fetch query
        $user = User::orderBy('level', 'ASC')->get();

        // ajax request with datatables
        if(request()->ajax()) {
            return datatables()->of($user)
            ->addColumn('action', function($data){
                $button = '
                    <a name="edit" data="'.$data->id.'" id="edit" class="edit btn btn-primary btn-sm">Edit </a>
                ';
                $button .= '
                    &nbsp;&nbsp;
                ';
                $button .= '
                    <a name="delete" data="'.$data->id.'" id="delete" class="delete btn btn-danger btn-sm">Delete </a>
                ';
                return $button;
            })
            ->addColumn('level', function($data){
                $level = get_authority($data->level);

                return $level;
            })
            ->addColumn('image', function($data){
                $produk_image = $data->photo;
                if($produk_image == "no_image.png") {
                    $path = url('images/'.$data->photo);
                }
                else{
                    $path = url('images/user/'.$data->photo);
                }

                $image = '
                    <a href="#" id="image-click" data="'.$data->id.'" image='.$path.'>
                        <img alt="'.$data->username.'" width="36" src="'.$path.'"></img>
                    </a>
                ';

                return $image;
            })
            ->rawColumns(['action', 'image'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.user.index');
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
            'username'  => 'required|string',
            'name'      => 'required|string',
            'password'  => 'required|string',
            'level'     => 'required|string',
            'photo'     => 'mimes:jpeg,png,gif,svg',
        );

        // customize error messages
        $messages = array(
            'required' => 'This field can not be blank.',
            'mimes'    => 'Supported format jpeg, png, gif and svg only.'
        );

        // apply the validation with rules
        $this->validate($request, $rules, $messages);

        //image config
        $file = $request->file('photo');
        if($file) {
            // rename of image
            $image   = sha1(time()).".".$file->getClientOriginalExtension();
            // define the path to save image
            $path    = 'images/user';
            // upload image to path with new name
            $file->move($path, $image);

        }
        else{
            $image = "no_image.png";
        }

        // insert data into database
        $user = new User;
        $user->photo        = $image;
        $user->username     = bcrypt($request->input('username'));
        $user->password     = $request->input('password');
        $user->name         = $request->input('name');
        $user->level        = $request->input('level');
        $user->save();

        return $user;
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

        $user = User::FindOrFail($id);

        return response()->json($user);
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
            'name'      => 'required|string',
            'level'     => 'required|string',
            'photo'     => 'mimes:jpeg,png,gif,svg',
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
            //define variable for photo input
            $file = $request->file('photo');
            //rename the image name
            $image  = sha1(time()).'.'.$file->getClientOriginalExtension();
            //path image
            $path   = 'images/user/';
            // apply the proceed
            $upload = $file->move($path, $image);
            // remove the replacing image
            $old_image = $user->photo;
            // if file exists
            if (file_exists($path.$old_image))
            {
                // then remove the old image file
                @unlink($path.$old_image);
            }
        }
        else{
            $image = $user->photo;
        }
        //edit password config
        $old_password = $user->password;
        //if edit password is null
        if ($request->input('password') == "")
        {
            // then still use old password from db
            $password = $old_password;
        }
        else{
            // if password is not null then use new password
            $password = $request->input('password');
        }

        //define value of photo
        $input['photo'] = $image;

        //define value of password
        $input['password'] = bcrypt($password);

        // update data into database depends on id if no errors
        $user->update($input);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::FindOrFail($id);
        $user->delete();

        return response()->json(true);
    }
}

<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Main\Setting;
use Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    private $oriPath;
    private $thumbPath;

    public function __construct()
    {
        $this->oriPath      = public_path('images/pengaturan');
        $this->thumbPath    = public_path('images/pengaturan/thumb');
    }

    public function index()
    {
        $setting = Setting::first();

        return view('main.setting.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'setting_nama'      => 'required',
            'setting_phone'     => 'required',
            'setting_alamat'    => 'required',
            'setting_image'     => 'mimes:jpg,jpeg,png,gif,svg'
        ]);

        if ($request->setting_id != "") {
            return $this->update($request);
            // return response()->json("asdasdad");
        }

        if ($request->hasFile('setting_image'))
        {
            $file   = $request->setting_image;
            $image  = $this->uploadImage($file);
        }
        else {
            $image  = "";
        }

        $setting = new Setting;
        $setting->setting_nama      = $request->setting_nama;
        $setting->setting_phone     = $request->setting_phone;
        $setting->setting_alamat    = $request->setting_alamat;
        $setting->setting_image     = $image;
        $setting->save();

        return response()->json(['message' => 'Pengaturan sudah ditambahkan.', 'setting' => $setting]);
    }

    public function update($request)
    {
        $setting = Setting::first();

        if ($request->hasFile('setting_image')) {
            $file   = $request->setting_image;

            $image  = $this->uploadImage($file);

            File::delete($this->oriPath.'/'.$setting->setting_image);
            File::delete($this->thumbPath.'/'.$setting->setting_image);
        }
        else {
            $image  = $setting->setting_image;
        }

        $setting->setting_nama      = $request->setting_nama;
        $setting->setting_phone     = $request->setting_phone;
        $setting->setting_alamat    = $request->setting_alamat;
        $setting->setting_image     = $image;
        $setting->save();

        return response()->json(['message' => 'Pengaturan sudah diperbaharui.', 'setting' => $setting]);
    }

    public function destory($id)
    {

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

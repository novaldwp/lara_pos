@extends('layouts.app')

@section('title')
  Edit Profile
@endsection

@section('breadcrumb')
   @parent
   <li>Profile</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12"><!-- PAGE CONTENT BEGINS -->
        <div class="box">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Ubah Data Diri</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Ubah Password</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <!-- tab 1 -->
                    <div class="tab-pane active" id="tab_1">
                        <form id="profile_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            @csrf
                            <br>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">
                                    Username :</i>
                                </label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="id" name="id" value="{{ $user->id ?? '' }}" class="form-control"/>
                                    <input type="text" id="username" name="username" value="{{ $user->username ?? '' }}" placeholder="Username" class="form-control" autocomplete="off" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">
                                    Nama :</i>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" id="name" name="name" value="{{ $user->name ?? '' }}" placeholder="Nama User" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">
                                    No. Handphone :</i>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" id="phone" name="phone" value="{{ $user->phone ?? '' }}" placeholder="No. Handphone User" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">
                                    Gambar :</i>
                                </label>
                                <div class="col-sm-9">
                                    <div id="profile_showImage">
                                        <a href="{{ URL::to((auth::user()->photo == '') ? 'images/no_avatar.png':'images/user/'.auth::user()->photo) }}" data-lightbox="image-1">
                                            <img src="{{ URL::to((auth::user()->photo == '') ? 'images/no_avatar.png':'images/user/thumb/'.auth::user()->photo) }}" width="100" height="80"></img>
                                        </a>
                                        <br><br>
                                    </div>
                                    <input type="file" id="photo" name="photo" class="form-control" autocomplete="off"/>
                                </div>
                            </div>

                            <div class="form-group form-actions">
                                <div class="col-md-offset-2 col-md-9">
                                    <input type="submit" class="btn btn-success btn-sm" value="Simpan">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /tab1 -->
                    <!-- tab2 -->
                    <div class="tab-pane" id="tab_2">
                        <form id="password_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                            @csrf
                            <br>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">
                                    Password Lama :</i>
                                </label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="id" name="id" value="{{ $user->id ?? '' }}" class="form-control"/>
                                    <input type="password" id="old_password" name="old_password" placeholder="Password Lama" class="form-control" autocomplete="off"/>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">
                                    Password Baru :</i>
                                </label>
                                <div class="col-sm-9">
                                    <input type="password" id="password" name="password" placeholder="Password Baru" class="form-control" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">
                                    Konfirmasi Password :</i>
                                </label>
                                <div class="col-sm-9">
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password Baru" class="form-control" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group form-actions">
                                <div class="col-md-offset-2 col-md-9">
                                    <input type="submit" class="btn btn-success btn-sm" value="Simpan">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /tab2 -->
                </div>

            </div><!-- /.span -->
        </div><!-- /.row -->
    </div>
</div>
@endsection

@include('main.user.script')

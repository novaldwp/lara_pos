@extends('layouts.app')

@section('header')
    Pengaturan
@endsection

@section('title')
  Pengaturan Toko
@endsection

@section('breadcrumb')
   @parent
   <li>Pengaturan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12"><!-- PAGE CONTENT BEGINS -->
        <div class="box">
            <div class="box-body">
                <form id="setting_form" class="form-horizontal" method="POST" action="{{ route('setting.store') }}">
                    @csrf
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">
                            Nama Toko :</i>
                        </label>

                        <div class="col-sm-9">
                            <input type="hidden" id="setting_id" name="setting_id" value="{{ $setting->setting_id ?? '' }}" class="form-control"/>
                            <input type="text" id="setting_nama" name="setting_nama" value="{{ $setting->setting_nama ?? '' }}" placeholder="Nama Toko" class="form-control" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">
                            No. Telepon :</i>
                        </label>

                        <div class="col-sm-9">
                            <input type="text" id="setting_phone" name="setting_phone" value="{{ $setting->setting_phone ?? '' }}" placeholder="Nomor Telepon Toko" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">
                            Alamat :</i>
                        </label>

                        <div class="col-sm-9">
                            <textarea name="setting_alamat" id="setting_alamat" class="form-control" placeholder="Alamat Toko" cols="58" rows="3" autocomplete="off">{{ $setting->setting_alamat ?? ''}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">
                            Gambar :</i>
                        </label>

                        <div class="col-sm-9">
                            <div id="setting_showImage">
                                @if (!empty($setting->setting_image))
                                    <a href="images/pengaturan/{{ $setting->setting_image ?? '' }}" data-lightbox="image-1">
                                        <img src="images/pengaturan/thumb/{{ $setting->setting_image ?? '' }}" width="100" height="80"></img>
                                    </a>
                                <br><br>
                                @endif
                            </div>
                            <input type="file" id="setting_image" name="setting_image" class="form-control" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="form-group form-actions">
                        <div class="col-md-offset-2 col-md-9">
                            <input type="submit" class="btn btn-success btn-sm" value="Simpan">
                        </div>
                    </div>

                </form>
            </div><!-- /.span -->
        </div><!-- /.row -->
    </div>
</div>
@endsection

@include('main.setting.script')

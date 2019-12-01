@extends('layouts.app')
@section('title')
tieett

@endsection

@section('content')

    {{ auth::user()->username }}

@endsection
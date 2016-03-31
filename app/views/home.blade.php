@extends('layouts.master')

@section('content')
    <h1>HOME</h1>
    <p>TESTING LOCALIZATION: <span style="color:red;">{{ Lang::get('validation.accepted') }}</span></p>
@stop
@extends('layouts.master')

@section('content')
    <br />
    @foreach ($errors->all() as $message)
    <br />
    {{$message}}
    <br />
    @endforeach
    <br />
    {{ Form::open(array('url' => 'admin', 'method' => 'post')) }}
    {{Form::label('email','Email')}}
    {{Form::text('email', null,array('class' => 'form-control'))}}
    {{Form::label('password','Password')}}
    {{Form::password('password',array('class' => 'form-control'))}}
    {{Form::submit('Login', array('class' => 'btn btn-primary'))}}
    {{ Form::close() }}
    <br /><br />
@stop
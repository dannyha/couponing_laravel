@extends('layouts.master')

@section('content')
    
    <h1>Create new User</h1>

    {{ Form::open(['url' => 'saveuser']) }}
        <div>
            {{ Form::label('user_id','User Id: ', array('class' => 'label-input', 'id' => 'user_id')) }}
            
            {{ Form::text('user_id'); }}

            {{ $errors->first('user_id','<span class=error>:message</span>') }}
        </div>
        <div>
            {{ Form::label('first_name','First Name: ', array('class' => 'label-input', 'id' => 'first_name')) }}
          
            {{ Form::text('first_name'); }}

            {{ $errors->first('first_name','<span class=error>:message</span>') }}
        </div>
        <div>
            {{ Form::label('last_name','Last Name: ', array('class' => 'label-input', 'id' => 'last_name')) }}
          
            {{ Form::text('last_name'); }}

            {{ $errors->first('last_name','<span class=error>:message</span>') }}
        </div>
        <div>
            {{ Form::label('email','Email: ', array('class' => 'label-input', 'id' => 'email')) }}
           
            {{ Form::email('email'); }}

            {{ $errors->first('email','<span class=error>:message</span>') }}
        </div>
        <div>
            {{ Form::label('role','Role: ', array('class' => 'label-input', 'id' => 'role')) }}
            
            {{ Form::select('role', array('administrator' => 'Administrator', 'user' => 'User')); }}

            {{ $errors->first('role','<span class=error>:message</span>') }}
        </div>
        <div>
            {{ Form::label('password','Password: ', array('class' => 'label-input', 'id' => 'password')) }}
        
            {{ Form::password('password'); }}

            {{ $errors->first('password','<span class=error>:message</span>') }}
        </div>
        <div>
            {{ Form::submit() }}
        </div>
    {{ Form::close() }}

@stop
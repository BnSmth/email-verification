@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <h1>Register</h1>

            @include('layouts.partials.errors')

            {{ Form::open(['route' => 'register_path']) }}
                <!--- Username Field --->
                <div class="form-group">
                    {{ Form::label('username', 'Username:') }}
                    {{ Form::text('username', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>

                <!--- Email Field --->
                <div class="form-group">
                    {{ Form::label('email', 'Email:') }}
                    {{ Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>

                <!--- Password Field --->
                <div class="form-group">
                    {{ Form::label('password', 'Password:') }}
                    {{ Form::password('password', ['class' => 'form-control', 'required' => 'required']) }}
                </div>

                <!--- Confirm Password Field --->
                <div class="form-group">
                    {{ Form::label('password_confirmation', 'Confirm Password:') }}
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required']) }}
                </div>

                <!--- Sign Up Field --->
                <div class="form-group">
                    {{ Form::submit('Sign Up', ['class' => 'btn btn-primary']) }}
                </div>

            {{ Form::close() }}
        </div>
    </div>
@stop
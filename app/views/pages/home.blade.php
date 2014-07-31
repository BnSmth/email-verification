@extends('layouts.default')

@section('content')

<div class="jumbotron">
    <h1>Email Verfication Tutorial</h1>
    <p>
        Welcome to the premiere email verification demo application.
    </p>
    @if( ! $currentUser)
    <p>
        {{ link_to_route('register_path', 'Sign Up', null, ['class' => 'btn btn-lg btn-primary']) }}
    </p>
    @endif
</div>

@stop
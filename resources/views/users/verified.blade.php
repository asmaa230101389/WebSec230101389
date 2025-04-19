@extends('layouts.master')

@section('title', 'Email Verification')

@section('content')
<div class="row">
    <div class="m-4 col-sm-6">
        <div class="alert alert-success">
            <strong>Congratulations!</strong> Dear {{ $user->name }}, your email {{ $user->email }} has been verified.
        </div>
    </div>
</div>
@endsection
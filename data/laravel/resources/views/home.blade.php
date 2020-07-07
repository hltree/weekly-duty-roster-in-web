@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header">
                    View Duty Roster
                </div>
                <div class="card-body">
                    <p class="card-text">You can see the duty roster.</p>
                    <a href="{{ route('duty-roster/view') }}" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header">
                    Setting Duty User
                </div>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">You can change the setting of duty user.</p>
                    <a href="{{ route('duty-roster/setting') }}" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

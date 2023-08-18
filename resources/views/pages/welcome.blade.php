@extends('layouts.app')

@section('content')
    @guest
        <div class="container align-items-center">
            <div class="col">
                <a class="link-info" href="{{ route('login') }}">{{ __('Login to get your tasks') }}</a>
            </div>
        </div>
    @endguest
    @auth()
        <div class="container">
            <div class="col">
                <div class="align-content-center w-100">
                    <a class="navbar-brand px-2" class="link-info" href="{{ route('pages.tasks.index') }}">
                        {{ __('Task List') }}
                    </a>
                    <a class="navbar-brand px-2" href="{{ route('pages.tasks.create') }}">
                        {{ __('Create Task') }}
                    </a>
                </div>
            </div>
        </div>
    @endauth
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h2>Create New Task</h2>

        <form action="{{ route('pages.tasks.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
            </div>
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description">{{ old('description') }}</textarea>
            </div>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>
                            {{ __("tasks.$status->value") }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" class="form-control" name="due_date" value="{{ old('due_date') }}">
            </div>
            @error('due_date')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>
    </div>
@endsection

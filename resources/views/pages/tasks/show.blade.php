@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h2>Task Details</h2>

        <div class="card">
            <div class="card-header">{{ $task->title }}</div>
            <div class="card-body">
                <p>{{ $task->description }}</p>
                <p>Status: {{ $task->status }}</p>
                <p>Due Date: {{ $task->due_date }}</p>
            </div>
        </div>

        <a href="{{ route('pages.tasks.edit', $task->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('pages.tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection

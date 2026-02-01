@extends('layouts.app')

@section('title', 'Create Short URL')

@section('content')
<div class="card">
    <h2>Create Short URL</h2>
    <form method="POST" action="{{ route('short-urls.store') }}">
        @csrf
        <div class="form-group">
            <label for="original_url">Original URL</label>
            <input type="url" id="original_url" name="original_url" value="{{ old('original_url') }}" placeholder="https://example.com/long-url" required>
        </div>
        <button type="submit" class="btn">Create</button>
    </form>
</div>
@endsection

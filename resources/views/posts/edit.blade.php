@php
    $title = __('Edit') . ': ' . $post->title;
@endphp
@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{ $title }}</h1>
    <form action="{{ url('posts/'.$post->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input id="title" type="text" class="form-control @if ($errors->has('title')) is-invalid @endif" name="title" value="{{ old('title', $post->title) }}" required autofocus>
            @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="body">{{ __('Body') }}</label>
            <textarea id="body" class="form-control @if ($errors->has('body')) is-invalid @endif" name="body" rows="8" required>{{ old('body', $post->body) }}</textarea>
            @if ($errors->has('body'))
                <span class="invalid-feedback">{{ $errors->first('body') }}</span>
            @endif
        </div>
        <div class="form-group">
         <img src="{{ asset('storage/images/' . $post->image_filename) }}" class="img-responsive">
        </div>
        <div class="form-group">
          <input class="field" name="image_file" type="file">
        </div>
        <button type="submit" name="submit" class="btn btn-success">{{ __('Submit') }}</button>
    </form>
</div>
@endsection
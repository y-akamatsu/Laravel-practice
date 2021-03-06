@php
    $title = $post->title;
@endphp
@extends('layouts.app')
@section('content')

<div class="container">
    <h1 id="post-title">{{ $title }}</h1>
    <div class="edit">
        <a href="{{ url('posts/'.$post->id.'/edit') }}" class="btn btn-primary">
            {{ __('Edit') }}
        </a>
        @component('components.btn-del')
            @slot('table', 'posts')
            @slot('id', $post->id)
        @endcomponent

    <!-- 記事内容 -->
    <dl class="row">
        <dt class="col-md-2">{{ __('Image') }}:</dt>
        <dd class="col-md-10">
            @if($post->image_filename)
                <img src="{{ asset('storage/images/' . $post->image_filename) }}" class="img-responsive">
            @endif
        </dd>
        <dt class="col-md-2">{{ __('Created') }}:</dt>
        <dd class="col-md-10">
            <time itemprop="dateCreated" datetime="{{ $post->created_at }}">
                {{ $post->created_at }}
            </time>
        </dd>
        <dt class="col-md-2">{{ __('Updated') }}:</dt>
        <dd class="col-md-10">
            <time itemprop="dateModified" datetime="{{ $post->updated_at }}">
                {{ $post->updated_at }}
            </time>
        </dd>
    </dl>
    <hr>
    <div id="post-body">
        {{ $post->body }}
    </div>
</div>
@endsection
  
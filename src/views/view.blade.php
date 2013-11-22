@extends('layouts.master')

@section('title')
	{{ $post->title }}
@endsection

@section('meta_description')
	{{ $post->meta_description }}
@endsection

@section('meta_keywords')
	{{ $post->meta_keywords }}
@endsection

@section('content')
	@include('laravel-blog::details')
	@include('laravel-blog::archives')
@stop
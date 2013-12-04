@extends('layouts.master')

@section('title')
	{{ Config::get('laravel-blog::index_page_title') }}
@endsection

@section('meta_description')
	{{ Config::get('laravel-blog::index_page_meta_description') }}
@endsection

@section('meta_keywords')
	{{ Config::get('laravel-blog::index_page_meta_keywords') }}
@endsection

@section('content')
	@include('laravel-blog::partials.list')
	@include('laravel-blog::partials.archives')
@stop
@extends('layouts.master')

@section('title')
	{{ Config::get('laravel-blog::meta.index_page.page_title') }}
@endsection

@section('meta_description')
	{{ Config::get('laravel-blog::meta.index_page.meta_description') }}
@endsection

@section('meta_keywords')
	{{ Config::get('laravel-blog::meta.index_page.meta_keywords') }}
@endsection

@section('content')
	@include('laravel-blog::partials.list')
	@include('laravel-blog::partials.archives')
@stop
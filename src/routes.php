<?php

// e.g. http://domain.com/blog or http://domain.com/blog/yyyy/mm
Route::get(Config::get('laravel-blog::uri').'/{year?}/{month?}', 'Fbf\LaravelBlog\PostsController@index')->where(array('year' => '\d{4}', 'month' => '\d{2}'));

// e.g. http://domain.com/blog/my-post
Route::get(Config::get('laravel-blog::uri').'/{slug}', 'Fbf\LaravelBlog\PostsController@view');

// e.g. http://domain.com/blog.rss
Route::get(Config::get('laravel-blog::uri').'.rss', 'Fbf\LaravelBlog\PostsController@rss');
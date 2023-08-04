@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('img', asset('images/error/404.png'))
@section('message', __('Oh! Something went wrong'))

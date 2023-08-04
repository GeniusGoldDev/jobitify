@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('img', asset('images/error/401.png'))
@section('message', __('Unauthorized'))

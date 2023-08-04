@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('img', asset('images/error/503.png'))
@section('message', __('Service Unavailable'))

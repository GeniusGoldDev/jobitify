@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('img', asset('images/error/403.png'))
@section('message', __($exception->getMessage() ?: 'Forbidden'))

@extends('layouts.app',['title' => $title, 'page_description' => $pg_description, 'site_view' => true])
    @section('content')
        @if( !empty($page_settings) )
            @foreach($page_settings as $key=> $single)
                @livewire( 'page-builder.'.$single['block_id'], [ 
                'page_id'       => $page_id,
                'block_key'     => ($single['block_id'].'__'.$key),
                'settings'      => $single['settings'],
                'style_css'     => $single['css'],
                'site_view'     => true],
                key(time().'__'.$key) )
            @endforeach
        @endif       
    @endsection('content')





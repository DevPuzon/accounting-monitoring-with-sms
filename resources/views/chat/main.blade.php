@extends('layouts.app')

@section('title', __('Chat'))
@section('content') 
 
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-8" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">@lang('Chat')</div>
                <div class="panel-body">

<div class="row">

    <div class="col-md-4">
        @component('chat.components.list')
        @endcomponent
    </div>

    <div class="col-md-8" style="border: 1px solid #DBDBDB;border-radius: 8px;padding:0px">
        @component('chat.components.container')
        @endcomponent
    </div>
</div>




                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', __('Payment history'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default"> 
            @if(count($payments) > 0)  
                <div class="page-panel-title">@lang('Payment history')</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif 
                        
                    <div class="table-responsive">
                        <table class="table table-bordered table-data-div table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th> 
                                <th scope="col">Name</th> 
                                <th scope="col">Email</th> 
                                <th scope="col">Contact number</th> 
                                <th scope="col">Charged for</th> 
                                <th scope="col">Payment date</th> 
                                <th scope="col">Amount</th> 
                                <th scope="col">Payment status</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $key=>$payments)
                            <tr>
                                <th scope="row">{{ ($current_page-1) * $per_page + $key + 1 }}</th> 
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
              @else
                <div class="panel-body">
                    @lang('No Related Data Found.')
                </div>
              @endif
            </div>
        </div>
    </div>
</div>
@endsection

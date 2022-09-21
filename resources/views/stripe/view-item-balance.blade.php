@extends('layouts.app')

@section('title', __('View Balance'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">@lang('View Balance')
              </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal"  >  
                        <div class="form-group{{ $errors->has('reference_id') ? ' has-error' : '' }}">
                            <label for="reference_id" class="col-md-4 control-label">@lang('Reference ID :')</label> 
                            <div class="col-md-6">
                                <input id="reference_id" type="text" class="form-control" name="reference_id"  
                                readonly  
                                @if ($fee->payment) 
                                value="{{$fee->payment->reference_id}}"
                                @else 
                                value="None"
                                @endif
                                required placeholder="@lang('Reference ID')">

                                @if ($errors->has('reference_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('reference_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 

                        <div class="form-group{{ $errors->has('payment_method') ? ' has-error' : '' }}">
                            <label for="payment_method" class="col-md-4 control-label">@lang('Payment method :')</label> 
                            <div class="col-md-6">
                                <input id="payment_method" type="text" class="form-control" name="payment_method" 
                                readonly 
                                @if ($fee->payment) 
                                value="{{$fee->payment->payment_method}}"
                                @else 
                                value="None"
                                @endif
                                required placeholder="@lang('Payment method')">

                                @if ($errors->has('payment_method'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('payment_method') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 

                        <div class="form-group{{ $errors->has('payment_status') ? ' has-error' : '' }}">
                            <label for="payment_status" class="col-md-4 control-label">@lang('Payment status :')</label> 
                            <div class="col-md-6">
                                <input id="payment_status" type="text" class="form-control"  
                                readonly
                                @if (!$fee->payment) 
                                value="Not paid"  
                                @else
                                value="{{($fee->payment->payment_status == 0 ) ? "Not paid":"Paid"}}"
                                @endif  placeholder="@lang('Payment status')">

                                @if ($errors->has('payment_status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('payment_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 

                        <div class="form-group{{ $errors->has('fee_name') ? ' has-error' : '' }}">
                            <label for="fee_name" class="col-md-4 control-label">@lang('Fee name :')</label> 
                            <div class="col-md-6">
                                <input id="fee_name" type="text" class="form-control"  
                                readonly
                                value="{{ $fee->fee_name }}" placeholder="@lang('Fee name')">

                                @if ($errors->has('fee_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fee_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">@lang('Description :')</label> 
                            <div class="col-md-6"> 
                                <div style="margin: 0px;padding: 10px 15px;">
                                    {!!$fee->description!!}
                                </div>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 

                        <div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">
                            <label for="balance" class="col-md-4 control-label">@lang('Amount :')</label> 
                            <div class="col-md-6">
                                <input id="balance" type="text" class="form-control" readonly
                                value="{{ $fee->balance }}" placeholder="@lang('0')">

                                @if ($errors->has('balance'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('balance') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form-control{
        background: #fff !important;
        border:inherit !important;
    }
</style>
@endsection

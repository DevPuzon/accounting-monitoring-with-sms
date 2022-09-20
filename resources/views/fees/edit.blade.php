@extends('layouts.app')

@section('title', __('Edit Fee Form'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">@lang('Edit Fee Form')
              </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" action="{{url('fees/update')}}" method="post">
                      {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $fee->id }}"> 
                        <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                            <label for="student_id" class="col-md-4 control-label">* @lang('Student')</label> 
                            <div class="col-md-6">
                                <select id="student_id" class="form-control" name="student_id" required
                                value="{{ $fee->user_id }}">
                                <option value="0" {{ ($fee->user_id == 0 ) ? "selected":"" }}>All</option>
                                @foreach ($students as $student)
                                <option value="{{$student->id}}"  {{ ($fee->user_id == $student->id ) ? "selected":"" }}>{{$student->email}}</option>
                                @endforeach
                                </select>  
                            </div>
                        </div> 

                      <div class="form-group{{ $errors->has('fee_name') ? ' has-error' : '' }}">
                          <label for="fee_name" class="col-md-4 control-label">* @lang('Form Field Name')</label> 
                          <div class="col-md-6">
                              <input id="fee_name" type="text" class="form-control" name="fee_name" value="{{ $fee->fee_name }}" placeholder="@lang('Form Field Name')" required>

                              @if ($errors->has('fee_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('fee_name') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">
                          <label for="balance" class="col-md-4 control-label">* @lang('Balance')</label> 
                          <div class="col-md-6">
                              <input id="balance" type="text" class="form-control" name="balance"value="{{ $fee->balance }}" placeholder="@lang('0')" required>

                              @if ($errors->has('balance'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('balance') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                          <button type="submit" class="btn btn-success">@lang('Update')</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', __('Add Form Field'))

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> 
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">@lang('Add Fee Form')
              </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" action="{{url('fees/create')}}" method="post">
                      {{ csrf_field() }}
 
                        <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                            <label for="student_id" class="col-md-4 control-label">* @lang('Student')</label> 
                            <div class="col-md-6">
                                <select id="student_id" class="form-control" name="student_id" required>
                                <option value="0" selected>All</option>
                                @foreach ($students as $student)
                                <option value="{{$student->id}}">{{$student->email}}</option>
                                @endforeach
                                </select>  
                            </div>
                        </div> 

                      <div class="form-group{{ $errors->has('fee_name') ? ' has-error' : '' }}">
                          <label for="fee_name" class="col-md-4 control-label">* @lang('Form Field Name')</label> 
                          <div class="col-md-6">
                              <input id="fee_name" type="text" class="form-control" name="fee_name" value="{{ old('fee_name') }}" placeholder="@lang('Form Field Name')" required>

                              @if ($errors->has('fee_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('fee_name') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>

                      
                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-4 control-label">* @lang('Message')</label> 
                            <div class="col-md-6"> 
                                <textarea id="message" name="message" value="{{ old('message') }}"> 
                                </textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                      <div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">
                          <label for="balance" class="col-md-4 control-label">* @lang('Balance')</label> 
                          <div class="col-md-6">
                              <input id="balance" type="text" class="form-control" name="balance" value="{{ old('balance') }}" placeholder="@lang('0')" required>

                              @if ($errors->has('balance'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('balance') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                          {{-- <button type="submit" class="btn btn-success" disabled>@lang('Save')</button> --}}
                          <button type="submit" class="btn btn-success">@lang('Save')</button> 
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script> 
    tinymce.init({
    selector: 'textarea#message',
        setup: function (editor) {
            editor.on('init', function (e) {
                editor.setContent(`<br><br>
                Good day!
                <br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;       Please be informed that our PRELIM EXAM will be on _____. To be able to take the exam, kindly settle your due(s) on or before ____.
                                    <br><br>
                                    Initial balance: <br>
                                    Prelim Due: <br>
                                    Midterm Due:<br>
                                    Prefinal Due:<br>
                                    Final Due:<br>
                                    TOTAL DUES: <br>
                                    <br><br>
                                    After payment, pls. send your proof of payment to 
                                    accounting@sltcfi.com for validation of your payment. 
                                    Thank you
                                    <br><br>
                                    From: Accounting Dept.`);
            });
        } 
     });  
    setInterval(() => {
        var content = tinymce.get("message").getContent();
        var desc = document.getElementById("message");
        desc.value = content ;
    }, 100);
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


<style>
    .tox-notifications-container, .tox-statusbar__branding, .tox-menubar, .tox-editor-header {
        display:none !important;
    }
</style>
@endsection

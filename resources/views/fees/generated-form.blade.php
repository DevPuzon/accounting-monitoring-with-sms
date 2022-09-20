 

<script src="https://js.stripe.com/v3/"></script>
@extends('layouts.app')

@section('title', __('Balance list'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">@lang('Balance list')
              </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif 
                    <div class="table-responsive"> 
                        @component('components.excel-fee-generated-upload-form')
                        @endcomponent
                        <table class="table table-bordered table-data-div table-hover"
                        id="c_table"> 
                            <thead>
                                <tr>
                                    <th>@lang('Fee Name')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Student Name')</th>
                                    <th>@lang('Student Code')</th>
                                    <th>@lang('Balance')</th> 
                                    <th>@lang('Created At')</th> 
                                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant'  )
                                    <th scope="col">@lang('Actions')</th>
                                    @endif
                              
                                </tr>
                            </thead> 
                            <tbody> 
                                @foreach ($fees as $fee)
                                    <tr> 
                                        <td>{{ $fee->fee_name }}</td>  
                                        <td>{{ !empty($fee->user->studentInfo) ? "Individual" : "All" }}</td>   
                                        <td>{{ !empty($fee->user->studentInfo) ? $fee->user->name : "" }}</td>   
                                        <td>{{ !empty($fee->user->studentInfo) ? $fee->user->studentInfo->student_id : "" }}</td>   
                                        <td>{{ $fee->balance }}</td>   
                                        <td>{{ date_format($fee->created_at," M d, Y g:i A") }}</td> 
                                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant'  )
                                        <td style="display:flex; column-gap:7px;">
                                          <a class="btn btn-xs btn-sm btn-success" href="{{url('fees/update/'.$fee->id)}}" ><i class="material-icons">edit</i> </a>   
                                          <form class="form-horizontal" id="delete-form-{{$fee->id}}" style=" margin: 0px; "
                                              + action="{{url('fees/delete/'.$fee->id)}}"
                                              method="post">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-xs btn-sm btn-danger" 
                                            type="submit" ><i class="material-icons">delete</i> </button>
                                        </form>
                                        </td>
                                        @endif 
                                    </tr>   
                                @endforeach 
                            </tbody>
                        </table>
                        
                        {{-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal{{$fee->id}}" style="margin-top: 5%;">@lang('Manage')   {{ $fee->fee_name }}</button> --}}

                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>

<script> 
    $(document).ready(function () {
        setTimeout(() => {
                $('#c_table').dataTable().fnDestroy();
                $('#c_table').DataTable({
                    paging: false,
                    order: [5, 'desc'],
                });
        }, 5000);
    });
</script>
@endsection 

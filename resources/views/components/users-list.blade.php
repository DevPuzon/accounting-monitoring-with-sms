{{$users->links()}}
 

<div class="table-responsive">
<table class="table table-bordered table-data-div table-condensed table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      {{-- @if(Auth::user()->role == 'admin')
        @if (!Session::has('section-attendance'))
        <th scope="col">@lang('Action')</th>
        @endif
      @endif --}}
      <th scope="col">@lang('Code')</th>
      <th scope="col">@lang('Full Name')</th>
      @foreach ($users as $user)
        @if($user->role == 'student')
          @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
            {{-- <th scope="col">@lang('Attendance')</th> --}}
            {{--@if (!Session::has('section-attendance'))
            <th scope="col">@lang('Marks')</th>
            @endif --}}
          @endif
            @if (!Session::has('section-attendance'))
            {{-- <th scope="col">@lang('Session')</th> --}}
            <th scope="col">@lang('Language')</th>
            {{-- <th scope="col">@lang('Class')</th>
            <th scope="col">@lang('Section')</th> --}}
            <th scope="col">@lang('Father')</th>
            <th scope="col">@lang('Mother')</th>
            @endif
        @elseif($user->role == 'teacher')
          @if (!Session::has('section-attendance'))
          <th scope="col">@lang('Email')</th>
          @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
            <th scope="col">@lang('Courses')</th>
          @endif
          @endif
        @elseif($user->role == 'accountant' || $user->role == 'librarian')
          @if (!Session::has('section-attendance'))
          <th scope="col">@lang('Email')</th>
          @endif
        @endif
        @break($loop->first)
      @endforeach
      @if (!Session::has('section-attendance'))
      <th scope="col">@lang('Gender')</th>
      {{-- <th scope="col">@lang('Blood')</th> --}}
      <th scope="col">@lang('Phone')</th>
      <th scope="col">@lang('Address')</th>
      
      @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant' )
      <th scope="col">@lang('Actions')</th>
      @endif

      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $key=>$user)
    <tr>
      <th scope="row">{{ ($current_page-1) * $per_page + $key + 1 }}</th>
      @if(Auth::user()->role == 'admin')
        {{-- @if (!Session::has('section-attendance'))
        <td>
          <a class="btn btn-xs btn-danger" href="{{url('edit/user/'.$user->id)}}">@lang('Edit')</a>
        </td>
        @endif --}}
      @endif
      <td><small>{{$user->student_code}}</small></td>
      <td>
        <small>
          @if(!empty($user->pic_path))
            <img src="{{asset('01-progress.gif')}}" data-src="{{url($user->pic_path)}}" style="border-radius: 50%;" width="25px" height="25px">
          @else
            @if(strtolower($user->gender) == trans('male'))
              <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/guest-male--v1.png" style="border-radius: 50%;" width="25px" height="25px">&nbsp;
            @else
              <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/businesswoman.png" style="border-radius: 50%;" width="25px" height="25px">&nbsp;
            @endif
          @endif
          <a href="{{url('user/'.$user->id)}}">
            {{$user->name}}</a>
          </small></td>
      @if($user->role == 'student')
        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
          {{-- <td><small><a class="btn btn-xs btn-info" role="button" href="{{url('attendances/0/'.$user->id.'/0')}}">@lang('View Attendance')</a></small></td> --}}
          {{--@if (!Session::has('section-attendance'))
          <td><small><a class="btn btn-xs btn-success" role="button" href="{{url('grades/'.$user->id)}}">@lang('View Marks')</a></small></td>
          @endif --}}
        @endif
        @if (!Session::has('section-attendance'))
        {{-- <td>
          <small>
          @isset($user->studentInfo['session'])
            {{$user->studentInfo['session']}}
            @if($user->studentInfo['session'] == now()->year || $user->studentInfo['session'] > now()->year)
              <span class="label label-success">@lang('Promoted/New')</span>
            @else
              <span class="label label-danger">@lang('Not Promoted')</span>
            @endif
          @endisset
          </small>
        </td> --}}
        <td><small>
        @isset($user->studentInfo['version'])
          {{ucfirst($user->studentInfo['version'])}}
        @endisset</small></td>
        {{-- <td><small>{{$user->section->class->class_number}} {{!empty($user->group)? '- '.$user->group:''}}</small></td>
        <td style="white-space: nowrap;"><small>{{$user->section->section_number}}
            @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
            - <a class="btn btn-xs btn-primary" role="button" href="{{url('courses/0/'.$user->section->id)}}">@lang('All Courses')</a>
          @endif  
          </small>
        </td> --}}
        <td><small>
        @isset($user->studentInfo['father_name'])
          {{$user->studentInfo['father_name']}}
        @endisset</small></td>
        <td><small>
        @isset($user->studentInfo['mother_name'])
          {{$user->studentInfo['mother_name']}}
        @endisset</small></td>
        @endif
      @elseif($user->role == 'teacher')
        @if (!Session::has('section-attendance'))
        <td>
          <small>{{$user->email}}</small>
        </td>
        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
        <td style="white-space: nowrap;">
          <small>
            <a href="{{url('courses/'.$user->id.'/0')}}">@lang('All Courses')</a>
          </small>
        </td>
        @endif
        @endif
      @elseif($user->role == 'accountant' || $user->role == 'librarian')
        @if (!Session::has('section-attendance'))
        <td>
          <small>{{$user->email}}</small>
        </td>
        @endif
      @endif
      @if (!Session::has('section-attendance'))
      <td><small>{{ucfirst($user->gender)}}</small></td>
      {{-- <td><small>{{$user->blood_group}}</small></td> --}}
      <td><small>{{$user->phone_number}}</small></td>
      <td><small>{{$user->address}}</small></td>
          
      @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant'  )
      <td style="display:flex; column-gap:7px;"> 
        @if($user->role == 'student')
          <a class="btn btn-xs btn-sm btn-success" href="{{url('stripe/balance-list/'.$user->id)}}" ><i class="material-icons">payment</i> </a>   
        @endif
        
        @if( Auth::user()->role == 'admin')
        <a class="btn btn-xs btn-sm btn-success" href="{{url('edit/user/'.$user->id)}}" ><i class="material-icons">edit</i> </a>   
        <form class="form-horizontal" id="delete-form-{{$user->id}}" 
            + action="{{url('user/delete/'.$user->id)}}"
            method="post">
          @csrf @method('DELETE')
          <button class="btn btn-xs btn-sm btn-danger" 
          type="submit" ><i class="material-icons">delete</i> </button>
        </form>
        @endif
      </td>
      @endif

      @endif
    </tr>
    @endforeach
  </tbody>
</table>
</div>
{{$users->links()}}

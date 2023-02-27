{{$users->links()}}
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

{{-- <tr id="userstable_filter'">
  <th>#</th>
  <th>ID no.</th>
  <th>Full Name</th>
  <th>School Year</th>
  <th>Course</th>
  <th>Year Level</th>
  <th>Semester</th>  
  <th> </th>  
</tr> --}}

<div id="userstable_filter" style=" display: flex; margin-bottom: 20px; column-gap:6px;">
  {{-- <div>#</div>
  <div>ID no.</div>
  <div>Full Name</div>
  <div>School Year</div>
  <div>Course</div>
  <div>Year Level</div>
  <div>Semester</div>  
  <div> </div>   --}}
</div>

<div class="table-responsive">
<table id="table-1" class="table table-bordered table-condensed table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      {{-- @if(Auth::user()->role == 'admin')
        @if (!Session::has('section-attendance'))
        <th scope="col">@lang('Action')</th>
        @endif
      @endif --}}
      <th scope="col">@lang('ID no.')</th>
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
            {{-- <th scope="col">@lang('Language')</th> --}}
            {{-- <th scope="col">@lang('Class')</th>
            <th scope="col">@lang('Section')</th> --}}
            {{-- <th scope="col">@lang('Father')</th>
            <th scope="col">@lang('Mother')</th> --}}
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
      
      @if($user->studentInfo)
      <th scope="col">@lang('School Year')</th>
      <th scope="col">@lang('Course')</th>
      {{-- <th scope="col">@lang('Blood')</th> --}}
      <th scope="col">@lang('Year Level')</th>
      <th scope="col">@lang('Semester')</th>
      @endif
      
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
      <td>{{$user->student_code}}</td>
      <td>
        
          {{-- @if(!empty($user->pic_path))
            <img src="{{asset('01-progress.gif')}}" data-src="{{url($user->pic_path)}}" style="border-radius: 50%;" width="25px" height="25px">
          @else
            @if(strtolower($user->gender) == trans('male'))
              <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/guest-male--v1.png" style="border-radius: 50%;" width="25px" height="25px">&nbsp;
            @else
              <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/businesswoman.png" style="border-radius: 50%;" width="25px" height="25px">&nbsp;
            @endif
          @endif --}}
          <a href="{{url('user/'.$user->id)}}" style="text-decoration: none;">
            {{$user->name}}</a>
          </td>
      @if($user->role == 'student')
        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
          {{-- <td><a class="btn btn-xs btn-info" role="button" href="{{url('attendances/0/'.$user->id.'/0')}}">@lang('View Attendance')</a></td> --}}
          {{--@if (!Session::has('section-attendance'))
          <td><a class="btn btn-xs btn-success" role="button" href="{{url('grades/'.$user->id)}}">@lang('View Marks')</a></td>
          @endif --}}
        @endif
        @if (!Session::has('section-attendance'))
        {{-- <td>
          
          @isset($user->studentInfo['session'])
            {{$user->studentInfo['session']}}
            @if($user->studentInfo['session'] == now()->year || $user->studentInfo['session'] > now()->year)
              <span class="label label-success">@lang('Promoted/New')</span>
            @else
              <span class="label label-danger">@lang('Not Promoted')</span>
            @endif
          @endisset
          
        </td> --}}
        {{-- <td>
        @isset($user->studentInfo['version'])
          {{ucfirst($user->studentInfo['version'])}}
        @endisset</td> --}}
        {{-- <td>{{$user->section->class->class_number}} {{!empty($user->group)? '- '.$user->group:''}}</td>
        <td style="white-space: nowrap;">{{$user->section->section_number}}
            @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
            - <a class="btn btn-xs btn-primary" role="button" href="{{url('courses/0/'.$user->section->id)}}">@lang('All Courses')</a>
          @endif  
          
        </td> --}}
        {{-- <td>
        @isset($user->studentInfo['father_name'])
          {{$user->studentInfo['father_name']}}
        @endisset</td>
        <td>
        @isset($user->studentInfo['mother_name'])
          {{$user->studentInfo['mother_name']}}
        @endisset</td> --}}
        @endif
      @elseif($user->role == 'teacher')
        @if (!Session::has('section-attendance'))
        <td>
          {{$user->email}}
        </td>
        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
        <td style="white-space: nowrap;">
          
            <a href="{{url('courses/'.$user->id.'/0')}}">@lang('All Courses')</a>
          
        </td>
        @endif
        @endif
      @elseif($user->role == 'accountant' || $user->role == 'librarian')
        @if (!Session::has('section-attendance'))
        <td>
          {{$user->email}}
        </td>
        @endif
      @endif
      @if (!Session::has('section-attendance'))
        @if($user->studentInfo)
          <td>{{$user->studentInfo['school_year']}}</td>
          <td>{{ucfirst($user->studentInfo['course'])}}</td>
          {{-- <td>{{$user->blood_group}}</td> --}}
          <td>{{$user->studentInfo['year']}}</td>
          <td>{{$user->studentInfo['semester']}}</td>
        @endif
          
      @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant'  )
      <td style="display:flex; column-gap:7px;"> 
        <a class="btn btn-xs btn-sm btn-success"
        href="{{url('user/'.$user->id)}}" ><i class="material-icons">person</i> </a>   
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


<script>
  $(document).ready(function () {
      $('#table-1').DataTable({
          initComplete: function (el) {
              console.log("initComplete",el)
              console.log("initComplete 2",this.api())
              this.api()
                  .columns([4,5,6])
                  .every(function (el) {
                      var column = this;
                      console.log("initComplete 3",column.cell(),el)

                      // var select = $('<select><option value=""></option></select>')
                      //     .appendTo( '#userstable_filter')
                      //     .on('change', function () {
                      //         var val = $.fn.dataTable.util.escapeRegex($(this).val());
                      //         console.log(val);
                      //         column.search(val ? '^' + val + '$' : '', true, false).draw();
                      //   });
                      
                      let  theads = [];
                      for(let a of $("thead:first tr th")){
                          theads.push($(a).text());
                      }
                      var divSelect = `
                      <div class="c-select-label">
                        <span>${theads[el]}</span>
                        <select id="select-${el}"><option value=""></option></select>
                      </div>
                      `;
                      $("#userstable_filter").append(divSelect);

                      let select = $(`#select-${el}`);
                      select.on('change', function () {
                          console.log(val);
                          var val = $.fn.dataTable.util.escapeRegex($(this).val());
                          column.search(val ? '^' + val + '$' : '', true, false).draw();
                      });

                      setTimeout(() => { 
                          column
                          .data()
                          .unique()
                          .sort()
                          .each(function (d, j) { 
                              if(d){    
                                  select.append('<option value="' + d + '">' + d + '</option>');
                              }
                          });
                      }, 1000);
                  });
          },
      });
  });
</script>

<style>
  .c-select-label{
    display: grid;
    width: fit-content;
    min-width: 110px;
    row-gap: 5px;
  }
  .c-select-label span{ 
    font-weight: bold;
  }
</style>
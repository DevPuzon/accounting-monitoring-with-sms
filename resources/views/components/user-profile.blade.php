<div class="row">
  <div class="col-md-2">
    @if(!empty($user->pic_path))
    <img src="{{asset('01-progress.gif')}}" data-src="{{url($user->pic_path)}}" class="img-thumbnail" id="my-profile" alt="Profile Picture" width="100%">
    @else
      @if(strtolower($user->gender) == trans('male'))
        <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/guest-male--v1.png" class="img-thumbnail" width="100%">
      @else
        <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/businesswoman.png" class="img-thumbnail" width="100%">
      @endif
    @endif
    <div class="rows" style="font-size:10px;margin-top:5%;">
      <input type="hidden" id="picPath" name="pic_path">
      <input type="hidden" id="userIdPic" name="user_id" value="{{$user->id}}">
      @component('components.file-uploader',['upload_type'=>'profile'])
      @endcomponent
    </div>
  </div>
  <div class="col-md-10" id="main-container">
    <h3>{{$user->name}} <span class="label label-danger">{{ucfirst($user->role)}}</span> <span class="label label-primary">{{ucfirst($user->gender)}}</span>
      @if ($user->role == 'teacher' && $user->section_id > 0)
        <small>@lang('Class Teacher of Section'): <span class="label label-info">{{ucfirst($user->section->section_number)}}</span></small>
      @endif
      <a href="{{url('edit/user/'.$user->id)}}" class="btn btn-xs btn-success pull-right" 
        style="margin-left:7px"  role="button"><i class="material-icons">edit</i> @lang('Edit')</a>

      @if($user->role == "student")
       <button class="btn btn-xs btn-success pull-right" role="button" id="btnPrint"><i class="material-icons">print</i> @lang('Print Profile')</button>
       <div class="visible-print-block" id="profile-content">
       <div class="row">
          <div class="col-md-12">
            {{-- <div class="col-xs-8">
              <h2>{{$user->section->class->school->name}}</h2>
              <div style="font-size: 10px;">{{$user->section->class->school->about}}</div>
            </div> --}}
            <div class="col-xs-4">
              <h3>@lang('Student Profile')</h3>
              <div style="font-size: 10px;">@lang('Printing Date'): {{Carbon\Carbon::now()->format('d/m/Y')}}</div>
            </div>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-md-12">
            <p class="bg-primary" style="text-align:center;">
              @lang('Academic Information')
            </p>
            <div class="col-xs-9">
              <table class="table">
                <tr>
                  <td>@lang('Student ID'):</td>
                  <td>{{$user->student_code}}</td>
                  <td>@lang('Student\'s Name'):</td>
                  <td>{{$user->name}}</td>
                </tr>
                {{-- <tr>
                  <td>@lang('Class'):</td>
                  <td>{{$user->section->class->class_number}}</td>
                  <td>@lang('Section'):</td>
                  <td>{{$user->section->section_number}}</td>
                </tr> --}}
                <tr>
                  {{-- <td>@lang('Session'):</td>
                  <td>@isset($user->studentInfo['session']){{$user->studentInfo['session']}}@endisset</td> --}}
                  <td>@lang('Language'):</td>
                  <td>@isset($user->studentInfo['version']){{$user->studentInfo['version']}}@endisset</td>
                </tr>
                {{-- <tr>
                  <td>@lang('Group'):</td>
                  <td>@isset($user->studentInfo['group']){{$user->studentInfo['group']}}@endisset</td>
                  <td colspan="2"></td>
                </tr> --}}
              </table>
            </div>
            <div class="col-xs-3">
              @if(!empty($user->pic_path))
              <img src="{{asset('01-progress.gif')}}" data-src="{{url($user->pic_path)}}" class="img-thumbnail" id="my-profile" alt="@lang('Profile Picture')" width="120px" height="120px">
              @else
              @if(strtolower($user->gender) == trans('male'))
                <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/architect.png" class="img-thumbnail" id="my-profile" alt="@lang('Profile Picture')" width="120px" height="120px">
              @else
                <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/architect-female.png" class="img-thumbnail" id="my-profile" alt="@lang('Profile Picture')" width="120px" height="120px">
              @endif
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p class="bg-primary" style="text-align:center;">
              @lang('Personal details')
            </p>
            <div class="col-xs-12">
              <table class="table">
                <tr>
                  <td>@lang('Email'):</td>
                  <td>{{$user->email}}</td>
                  <td>@lang('Contact Number')</td>
                  <td>{{$user->phone_number}}</td>
                </tr>
                <tr>
                  <td>@lang('Gender'):</td>
                  <td>{{$user->gender}}</td> 
                  <td>@lang('Nationality'):</td>
                  <td>{{$user->nationality}}</td>
                </tr>
                <tr>
                  <td>@lang('Course'):</td>
                  <td>{{$user->studentInfo['course']}}</td> 
                  <td>@lang('Major'):</td>
                  <td>{{$user->studentInfo['major']}}</td>
                </tr>
                <tr>
                  <td>@lang('Year'):</td>
                  <td>{{$user->studentInfo['year']}}</td>
                </tr> 
                <tr>
                  <td>@lang('Birthday'):</td>
                  <td>{{Carbon\Carbon::parse($user->birthday)->format('d/m/Y')}}</td>
                  <td>@lang('Religion'):</td>
                  <td>@isset($user->studentInfo['religion']){{$user->studentInfo['religion']}}@endisset</td>
                </tr> 
                <tr>
                  <td>@lang('Phone Number'):</td>
                  <td>{{$user->phone_number}}</td>
                  <td>@lang('Address'):</td>
                  <td>{{$user->address}}</td>
                </tr>
                <tr> 
                  <td>@lang('Father Name'):</td>
                  <td>@isset($user->studentInfo['father_name']){{$user->studentInfo['father_name']}}@endisset</td>
                  <td>@lang('Mother Name'):</td>
                  <td>@isset($user->studentInfo['mother_name']){{$user->studentInfo['mother_name']}}@endisset</td>
                </tr>
                <tr> 
                  <td>@lang('Father\'s Phone Number'):</td>
                  <td>@isset($user->studentInfo['father_phone_number']){{$user->studentInfo['father_phone_number']}}@endisset</td> 
                  <td>@lang('Mother\'s Phone Number'):</td>
                  <td>@isset($user->studentInfo['mother_phone_number']){{$user->studentInfo['mother_phone_number']}}@endisset</td>
                </tr> 
                <tr> 
                  <td>@lang('Father\'s Occupation'):</td>
                  <td>@isset($user->studentInfo['father_occupation']){{$user->studentInfo['father_occupation']}}@endisset</td> 
                  <td>@lang('Mother\'s Occupation'):</td>
                  <td>@isset($user->studentInfo['mother_occupation']){{$user->studentInfo['mother_occupation']}}@endisset</td> 
                </tr> 
              </table>
            </div>
          </div>
        </div>
       </div>
       <script>
        $("#btnPrint").on("click", function () {
            var tableContent = $('#profile-content').html();
            var printWindow = window.open('', '', 'height=720,width=1280');
            printWindow.document.write('<html><head>');
            printWindow.document.write('<link href="{{url('css/app.css')}}" rel="stylesheet">');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<div class="container"><div class="col-md-12" id="academic-part">');
            printWindow.document.write(tableContent);
            printWindow.document.write('</div></div></body></html>');
            printWindow.document.close();
            // var academicPart = printWindow.document.getElementById("academic-part");
            // academicPart.appendChild(resultTable);
            setTimeout(() => { 
              printWindow.print();
            }, 1000);
          });
        </script>
      @endif
     </h3>
    <div class="table-responsive" style="margin-top: 3%;">
    <table class="table table-bordered table-striped">
      <tbody>
        @if($user->role == "student")
        <tr>
          <td><b>@lang('Code'):</b></td>
          <td>{{$user->student_code}}</td>
          <td><b>@lang('Email'):<b></td>
          <td>{{$user->email}}</td>   
        </tr> 
        <tr>
          <td><b>@lang('Language'):</b></td>
          <td>@isset($user->studentInfo['version']){{$user->studentInfo['version']}}@endisset</td>
          <td><b>@lang('Birthday'):</b></td>
          <td>{{Carbon\Carbon::parse($user->birthday)->format('d/m/Y')}}</td> 
        </tr>  
        <tr>
          <td><b>@lang('Nationality'):</b></td>
          <td>{{$user->nationality}}</td>
          <td><b>@lang('Religion'):</b></td>
          <td>@isset($user->studentInfo['religion']){{$user->studentInfo['religion']}}@endisset</td>
        </tr> 
        <tr>
          <td><b>@lang('Address'):</b></td>
          <td>{{$user->address}}</td>
          <td><b>@lang('Phone Number'):</b></td>
          <td>{{$user->phone_number}}</td>
        </tr>
        <tr>
          <td><b>@lang('Gender'):</b></td>
          <td>{{$user->gender}}</td> 
          <td><b>@lang('Course'):</b></td>
          <td>{{$user->studentInfo['course']}}</td> 
        </tr>
        <tr>
          <td><b>@lang('Major'):</b></td>
          <td>{{$user->studentInfo['major']}}</td>
          <td><b>@lang('Year'):</b></td>
          <td>{{$user->studentInfo['year']}}</td>
        </tr> 
        <tr>
          <td><b>@lang('Father\'s Name'):</b></td>
          <td>@isset($user->studentInfo['father_name']){{$user->studentInfo['father_name']}}@endisset</td>
          <td><b>@lang('Mother\'s Name'):</b></td>
          <td>@isset($user->studentInfo['mother_name']){{$user->studentInfo['mother_name']}}@endisset</td>
        </tr> 
        <tr>
          <td><b>@lang('Father\'s Phone Number'):</b></td>
          <td>@isset($user->studentInfo['father_phone_number']){{$user->studentInfo['father_phone_number']}}@endisset</td>
          <td><b>@lang('Mother\'s Phone Number'):</b></td>
          <td>@isset($user->studentInfo['mother_phone_number']){{$user->studentInfo['mother_phone_number']}}@endisset</td> 
        </tr> 
        <tr> 
          <td><b>@lang('Father\'s Occupation'):</b></td>
          <td>@isset($user->studentInfo['father_occupation']){{$user->studentInfo['father_occupation']}}@endisset</td>
          <td><b>@lang('Mother\'s Occupation'):</b></td>
          <td>@isset($user->studentInfo['mother_occupation']){{$user->studentInfo['mother_occupation']}}@endisset</td>
        </tr> 
        @else
        
        <tr>
          <td><b>@lang('Code'):</b></td>
          <td>{{$user->student_code}}</td>
          <td><b>@lang('Email'):<b></td>
          <td>{{$user->email}}</td>   
        </tr> 
        <tr>
          <td><b>@lang('Phone Number'):</b></td>
          <td>{{$user->phone_number}}</td>
          <td><b>@lang('Gender'):<b></td>
          <td>{{$user->gender}}</td>    
        </tr> 
        <tr>
          <td><b>@lang('Nationality'):</b></td>
          <td>{{$user->nationality}}</td>
        </tr> 

        @endif
      </tbody>
    </table>
    </div>
  </div>
</div>

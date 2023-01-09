@if(!is_null(\Auth::user()) ) 
<input id="user_id" type="hidden" value="{{ \Auth::user()->id }}">
@endif
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse"
                aria-expanded="false">
                <span class="sr-only">@lang('Toggle Navigation')</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/home') }}" style="color: #000;">
                {{ (Auth::check() && (Auth::user()->role == 'student' || Auth::user()->role == 'teacher' ||
                Auth::user()->role == 'admin' || Auth::user()->role == 'accountant' || Auth::user()->role ==
                'librarian'))?Auth::user()->school->name:config('app.name') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                <li><a href="{{ route('login') }}" style="color: #000;">@lang('Login')</a></li>
                @else
                @if(\Auth::user()->role == 'student')
                                
                {{-- <li class="nav-item">
                    <a href="{{url('user/'.\Auth::user()->id.'/notifications')}}" class="nav-link nav-link-align-btn"
                        role="button">
                        <i class="material-icons text-muted">email</i>
                        <?php
                            $mc = \App\Notification::where('student_id',\Auth::user()->id)->where('active',1)->count();
                        ?>
                        @if($mc > 0)
                        <span class="label label-danger" style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">{{$mc}}</span>
                        @endif
                    </a>
                </li> --}}
                @endif
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle nav-link-align-btn" data-toggle="dropdown" role="button"
                        aria-expanded="false" aria-haspopup="true">
                        <span class="label label-danger">
                            {{ ucfirst(\Auth::user()->role) }}
                        </span>&nbsp;&nbsp;
                        @if(!empty(Auth::user()->pic_path))
                        <img src="{{asset('01-progress.gif')}}" data-src="{{url(Auth::user()->pic_path)}}" alt="Profile Picture"
                            style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">
                        @else
                        @if(strtolower(Auth::user()->gender) == 'male')
                        <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/architect.png"
                            alt="Profile Picture" style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">
                        @else
                        <img src="{{asset('01-progress.gif')}}" data-src="https://img.icons8.com/color/48/000000/architect-female.png"
                            alt="Profile Picture" style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">
                        @endif
                        @endif
                        &nbsp;&nbsp;{{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        @if(Auth::user()->role != 'master')
                        <li>
                            <a href="{{url('user/'.Auth::user()->id)}}">@lang('Profile')</a>
                        </li>
                        @endif
                        <li>
                            <a href="{{url('user/config/change_password')}}">@lang('Change Password')</a>
                        </li>
                        @if(env('APP_ENV') != 'production')
                        {{-- <li>
                            <a href="{{url('user/config/impersonate')}}">
                                {{ app('impersonate')->isImpersonating() ? __('Leave Impersonation') : __('Impersonate') }}
                            </a>                                
                        </li> --}}
                        @endif
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                @lang('Logout')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

 
<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js"></script>  
<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-messaging.js"></script> 
<script> 
    if(window.innerWidth <= 768 && !window.location.pathname.includes('mobile') && (window.location.pathname.includes('users') || window.location.pathname.includes('balance-list'))){
        window.location.href = '{{ url('/mobile/save_fcm_token')}}'
    }
    else if(window.innerWidth <= 768 && !window.location.pathname.includes('mobile')){
        window.location.href = '{{ url('/mobile/login')}}'
    } 
    @if(!is_null(Auth::user()))
    if(window.innerWidth <= 768 && !window.location.pathname.includes('mobile') && {{ Auth::user()->role == 'admin' ? 1 : 0}}){
        window.location.href = "{{ url('mobile/login') }}"
        $.ajax({
            url: '{{ url('logout') }}',
            type: 'POST',
            data: { 
            },
            success: function(response) { 
                window.location.href = "{{ url('mobile/login') }}"
            },
            error: function(err) { 
            },
        }); 
    }
    @endif
    var firebaseConfig = { 
            apiKey: "AIzaSyBKYmu0Na0CwNE8trfSMjCOlvAMKDj65Ko",
            authDomain: "prototypeproject-eeb91.firebaseapp.com",
            databaseURL: "https://prototypeproject-eeb91.firebaseio.com",
            projectId: "prototypeproject-eeb91",
            storageBucket: "prototypeproject-eeb91.appspot.com",
            messagingSenderId: "208414469125",
            appId: "1:208414469125:web:8357b52d90f71a5d9a006c",
            measurementId: "G-R62XTDLQWV"
    };   
    firebase.initializeApp(firebaseConfig); 
    const messaging=firebase.messaging(); 
    getStartToken(); 

    messaging.onMessage(function(payload){
        console.log("on Message",payload);
    });

    function getStartToken() {
        messaging.getToken().then((currentToken) => {
            if (currentToken) {
                sendTokenToServer(currentToken);
            } else {
                // Show permission request.
                RequestPermission();
                setTokenSentToServer(false);
            }
        }).catch((err) => {
            console.log(err);
            setTokenSentToServer(false);
        });
    }

    function RequestPermission() {
        messaging.requestPermission()
        .then(function(permission) {
            if (permission === 'granted') {
                console.log("have Permission");
                //calls method again and to sent token to server
                getStartToken();
            } else {
                console.log("Permission Denied");
            }
        })
        .catch(function(err) {
            console.log(err);
        }) 
    }

    function sendTokenToServer(token) { 
        var user_id = document.getElementById("user_id").value;
        if (!isTokensendTokenToServer()) {
            $.ajax({
                url: '{{ url('/api/update-user-fcm-token') }}?user_id='+user_id+'&token='+token,
                type: 'POST',
                data: { 
                },
                success: function(response) {
                    setTokenSentToServer(true);
                },
                error: function(err) {
                    setTokenSentToServer(false);
                },
            });
        }
    }

    function isTokensendTokenToServer() {
        return window.localStorage.getItem('sendTokenToServer') === '1';
    }

    function setTokenSentToServer(sent) {
        window.localStorage.setItem('sendTokenToServer', sent ? '1' : '0');
    }

</script>
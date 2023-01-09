@extends('layouts.app')

@section('title', __('Home'))
<link href="{{ asset('css/mobile.css') }}" rel="stylesheet">
@section('content')

@if(!is_null(\Auth::user()) ) 
<input id="user_id" type="hidden" value="{{ \Auth::user()->id }}"> 
@endif
<script> 
    var token= Android.getFcmToken();
    var user_id = document.getElementById("user_id").value;  
    var xhr = new XMLHttpRequest();
    xhr.withCredentials = true; 
    xhr.addEventListener("readystatechange", function() {
      if(this.readyState === 4) {
        console.log(this.responseText);
      }
    });
    
    xhr.open("POST",'{{ url('/api/update-user-fcm-token') }}?user_id='+user_id+'&token='+token); 
    xhr.send(); 
    window.location.href = '{{ url('/mobile/home')}}'
</script>
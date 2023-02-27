@extends('layouts.app')

@section('title', __('Home'))
<link href="{{ asset('css/mobile.css') }}" rel="stylesheet">
@section('content')
<script>
    function onLogout(){ 
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
</script>
<div class="c-navigation">
    <img onclick="window.location.href = '{{ url('mobile/home') }}'" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAACfklEQVR4nO3cMW/TQBiH8dcqonRAghUhJjrAxgJ8AzZYQerCwhY6sjLRVP0EnRhAYoYJPgFlQZlYmBiajki0opVAfZAjDxF2em58Pvt8/99YNU7y5GT37VkxExEREZE5wCVgG5gCB8A4/9n870hDwDVgj7KvwI2mxxebRb4D/GCxfeCeYjVbyRvAMW7572zUPObF4rSTf0DzpsWpaTWZDw1YAXY4v/wxK45jbzmOsW0pAC4D71neR+DKGcfPV+5ZDmzogJvAN5r7Dtxa8BynNR6f2VABD4Cf+PMLeFjxPOmGBp4Bf/DvL/DCUg8NrAKvad87YC3J0CweQtoyG26SCg3crfg7NoS6zxl/aOAx8Jt+y2IfQsbEIUt1CAktS3kICSlLfQgJJZ7QLQ4hIWSx7IS8IW5r1mcdDCFt6e/OTY2dkNjk/069b30CPIlgCFnGCfC0676xDSFN7AIXuhxCPpCOT8DV0JHXIxxC8LRzcztU5FiHEJ87N4/ajrxZ7Fqk7hR46X2wKe6FiH0IacPbvI3P0K9aeZnDsOUzdBe7IbGYKnQY/m64SWQoWdbYZ+hFNwambL9o0v5NkaQnaz2qQs8odCAKHYhCB6LQgSh0IAodiEIHMpzQ5u+11bkP+rwU+n8K7WCeKLSDQlevGu9MK1qh0cWwTOdoB/NEoR0UunrVeGda0QqNLoZlOkc7mCcK7aDQ1avGO9OKVmh0MSzTOdrBPFFoB4WuXjXemVa0QqOLYZnO0Q7miUI7KHT1qjkkHYfWFeAL6djrMvRz0jHq+rtFJwzfpPNvSgeuDzz2JH+P1gfFyh4Bn4Ej4ndUvJdRUt/5LyIiIiIiIiJi9fwD0gnJmHDECOwAAAAASUVORK5CYII=">
    <img onclick="window.location.href = '{{ url('mobile/dashboard') }}'" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAACp0lEQVR4nO3dW24TQRCF4WYpkIRVEB5wWCNxwlLIbRHY2QM4Uuw850ctDRLCd2Wm69h1vufIqp5jq8dT5U4pZmZmZmZmZmZmewC+AtfAI/DC270AU+AKuHhjXVfda8nU1RvgI/DA8O6Bsz3qOlOsq1fAZ+CJdmbA+Q51nXd/28rTLnUN8c5vefH/qhf2dMs7X66uIQK4Jc69aF0PrS5+3diijVbUdRFdVJONGfgevUpgvKKuehcW7apFAPVWM9p0RV319jDaY4sAFtGrBBaHUtcQAUgoy3W9ouGdA4jlAII5gGAOIJgDOPYAFG73njPfBSl8EZtkDqA2I6J9yxyAwkOvL2kD6BZ7E7jAuzU1pQrgPfBLqfFBpgCCWn+/gU8b6skVQLfo00ZdqBvgZEst+QL4Z/Gj2iSpt4c9fU9YAD+By1Ub7poa8gagAAfgADr+BARzABk34fDZUDLuAUqzoWQLQG02lEwBAB/8KCI2ALnZULJ8Avw4Oj4A1dnQVzSkbUk+ZxlNnEevEpiLDudOWwQgoSzXVZ/GRrvMHMBI8YcjaQKogB9qvereIaIcSK86VQBV7Rs37lXPNvWqe4eIotGrvm3689RucRLKbrWOBjiqYNK95vAb7ppFSShZIaJkhYiSFSJKVogo+23Ck56eYdWBMW/C1ZYLf9b1kYd21/y8IEQUrS9i7c4LQkTRexTR5pOAiKL3w5H71AHgx9HhAVyT5LwgCWW5LrckgwNYEM/nBQnwWRHBHEAwBxDMAQRzAMHSnhc0z3IbqjqcO80yG3qtOIOJxjlG4xYBqJ4XNIouqtmoiuJ5QWkeRyvPYCJa17GcFzTbZQYzqK62/8Lkv+Z3bUy3mME82aOu450N3bAxDzGDOX7LxnaUs6FmZmZmZmZmZlYO1R8xrgH8kzJYWgAAAABJRU5ErkJggg==">
    <img onclick="window.location.href = '{{ url('mobile/notification') }}'" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAADhElEQVR4nO3dT0gVQRzA8V+agZfKIKIgSs0gsC5Zl0KojA5SHaNjQd2CqC5aF+tiERHUQfPgNSvvdYgKAjWIqEPpubJC0kqNnqXfGN4ePLjvjz7fzG9mPvAQ9f12d34sM7M7O7MiURRFURRFwQB2AdeAQWAUyACfgQGgA2jMEduYfGcgickk2zC/XzXbltABdcBDYI7czP/vA1vmxW4F+gqMfQDUSoiAw8A4xTHfPwDsA8aKjP0JtEqASf7L4mSSz2KYfbZIQNXFOPaMB1GNAI+wr08C6F3MpRR+EmgzZxtQlfxsB6YKSFyxseYYdoqvyHa30hK1OyWmKU+yFxvbIb4i209eSFueuCs5Ep0v9nJK3ID4iuyFxEJyNk5AfY5E1xbQ+C5kVHwFzKQUelWeuMocia7ME7sqJW5GfEV6ty5vdystywXEpZ3R4+IrYCil0O3LmOi0OnpQfAVcTym06Rk0lTrRwJ4cvY5OCbQfPZX0LuoWqncLTXRSn9cn25oOsh9tAP3Y1y++A9YDXywm+RuwQUIAtAC/LSTZ7POQhATYm5xd5fId2C+hIdvovS1jot+ZfUpIgOPABOVn9nlMQgCcBmaxx+z7lPgMOGs5yfOTfUZ8BBwB/uGOWe8Ga4HtlurkQkbGd4gPgJXAG9z1Ot+tVhWAi7jvvGgGbErG9Fz3C9goWgE30eOGaATUJGeKFuZY14o2pt5Dn3OiDfASfV6IJuZ+ryNXgMWaVdUoAifR64RoYVpw9OoULYAn6PVYtABG0OuDaFHmIapS+ypaAH/QKyNaoN8KUXJbVLsqcR2wDv1qxHVm0iX6bRbXmYcH0a9RXAccRb9WcR1wCf0uiOuAHvTrFtcBr9BvSFwGrHHsIRmWMDl/tbjKk4bQ/QYRuI0/bomLgArgI/745OQTTGbKAv45KK4BevFPr+28RlEURVEULTOgGrjr6JyU5TaRlL26HInuWvbiuK+rHJfZNibLu8bkoCImWnuik7M6Vh2UYQRmXmP4gzAbwztlaQyVjDn22C6H84DhEiR6xHY5nEf6yl7FmLZdDudRmpm2k7bLEUrVMWy7HKE0ht22y6HlRQtLFcYLE5YKeLqEJD+3ffzalmobW0SSzbLJDbaPXxWgucjXiJgFBJttH7dKQIOpCgpI8jNgm+3j9WUt03tmsmWy/LH5vE/+FtZao1EURVEURZLLfxOxGiol31OTAAAAAElFTkSuQmCC">
    <img onclick="window.location.href = '{{ url('mobile/chat') }}'" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAACGElEQVR4nO2XOywEQRyH16MhnolIJChEQUKIQqlTiorrlFolhYRSJ0qtUoiCTlQUKy4RnUqQkCMEBRKvT4bZZLJm9nWv3dgvudxm978z3+9u/jt3lpWSkpKSkqJAzLH8IOZY/yHAPPBK/HgVbr4BZIhuYI/4cAD0BpJXQlQAU8B9GcWfgBmgMpS8K0gbsFEG+R2gI4rwkOH8JJArgXhOzBXGzV30CawC9ZprTfLaV5Hk14EWzby1wBLwESSAwxUwYagZAU4LKH4GjBrmGgPOncIwARy2gU5NXQ2wCLzlIf4OrAB1ht5bc98QJYDgGZgFqjT1A8BRBPkTYFgzXiUwLZ9AFCqAQ1bXSEA1MAe8BBB/kbXVmnGG5Bwm7HwDoDR5g+beLmDX4959oMerSTEjgjUXIoBnkysb4J1S+2jakPht0gufuYLJhwzgsAW0G5pwU77aNNfb5b1+2EBjIPmIATybPGyTRv7k8wzgcKx7sihjDwKHAcfKhpYvQABkIy6rO7k4lue8mtR32cif+qKfMsUM4HAJjMuXOCZP+UXXBpgpdoAo2Ab5VuDGVasPQQzlrd/3Pk2Ih7gEsD2WjZDuM4T4+xezDPJZ3dPGteZvgX55vge4Bhbi0AN2gIZ1UL+Jn2VV7gBh5NUQZvkSBgiybHTol02JAxRPXpBoeUGi5QWJlhckWr6UJFpekGh5QaLlBYmWT0mx4sM37GtNWLL/Gh0AAAAASUVORK5CYII=">
    <img onclick="onLogout()" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAE1UlEQVR4nO2dz29VRRTHR2kt/kyIiVFRNG5FEtiASmWhCcqmxqhYo2ANBoOVQOK/YKmpoEQWrQtdGVcWf1HUGJYGo2hlD4YfQpACipUKlXzMeM9LXsidebfcH3Nn7nySl7zVnTPfN2/mzJkz5yoViUQikUgkEolEIpFsAF3AEmAAeBf4DPgZOAmcBS4DF+X7IeAgsBt4C3gZWAbMy9hcswBuA14BxoHz5Ef/CJ8Cg8AdqsmQjNyngS+BWcrjX2ACeB7oUU0BuB54HThM9fwGbAVuVKECXAusB47int+BzcHN5cBi4Hvqh15kH1QhALwhXsJc+Av4BtgGPAc8BNwJLJB/xnXy/T5gufxT3gT2AtNzbEt7MduBbuUrIkBWTgPvAY9qIXO02Q08DLwNnMjcOuwH7lE+AuzL0MEfgGfziGtpfx7wBPDtHNzCR1RgQk8Cqyu0ZQXwdQaxZ4A+5RPAiykd+RPYqOdaRzZp3/1YBt97vfIJ2Z0dAqaAD4G7a2DTzcBHGcR+0rWtQQBskKnCNo34N2fXEaAXONdhgbzXtZ1BADzQwRXc77WfXUOxbSN7u2sbQ5tGZiw7yDC263VA4uIm9CFDl2sbgwG767fZtX3BQOJnH7OEWMONZ1cN8IxlVG91aVgPMCI7QB2qHNOnKcpjSEK1ppOaHlci63O5KxlTHkMSiDLRXxeRNeeV52AOse6ti8iaP5TnkMSz05itJJUhg8iaHcpzSA4PTNvzwTqIPBFKHgXJmWIau8sWeU9TRNYAKy2RveJTFpooskZO3U2n68tUkTRV5BbAV4Y+D6iCf9HPO4isDZmvAgUYMvR7uKgGGi9yhxyV/Ati06eLjLvESZUHPQ1kELkOnAN2lR1X0eeGhvZ/zfvg9/GL0cJUTdfjVkO7U3keqhMJL+AXf5eZlCNrVRoX8zw0Cl2F0PJgHU/2idFcHXYxdbQthp3iGXXgrKT7+rkYNjF4ZEOnGpTi3rU1EDcs6n8dXjIIPV6I0FHsBLnmkcY2VSQZ5+w9oU4jmJPYB8porJFiU2WYtMlik+TkpXGm1JsLTRMb2FH6QphT7J0qjDvrJw3921SVEZ3EnnZ1KagogDWWdIPbqzRkvtxYTWMmAKH3Gfo24cIYk9gfKI8huRpdj5SwK7brO2W6+Eeuut2kwkwHO+58oQeu0R/lOcBay2je4tq+IABukVGbxingBtc2BgHwsWU0l5tv1xRI7qmbOBBc1RoXAKs6XH9b7sSwkCCptWe70Dni2sZQRD5hEfm7eEW5mOnCNpJ1hG5R3nYaDcnCZysjoXNbViofaCsmOCW7xbtq4ifbXLhWYZQ+30v9vOqw1M9ay2bEz1I/HYpX/QI8XnGAKEu1sAvejOQ5lmP7UYoI9pR0o2pNRjtaC58fc3I7wLqMHWx1UqffPpZHdDlI7ZXjJ9PJiMmFW9S0kpnT8jfXxbf7pTLjwraSmd1tJTNXSHLLkKQEXE3JzJEgSvkA90tdorpxILhtNclIfAE44lpdCXUOBh0gIjn2ek2KDlaNduu2NCqeTOIRPAV8AVwqUdxZOanvDyXPpIiXKXwiG5q8nJEXM2yqNCXAw5G+WDyJd+TtEz9JdK31epBLba8HmRRRh+WVIkt9T3GIRCKRSCQSiUQiEVUl/wE1kZsnc4G4kgAAAABJRU5ErkJggg==">
</div>
<div class="container" style="position: relative; ">
    <div class="c-title">Change Password <img onclick="window.location.reload()" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABOUlEQVR4nN3VzypEYRjH8THyp7CwcgGyMXZugIWVEiWugaYMOxfgz3X4s7CTsrCyZok0oZByAUYi5aOjd+o0jZlzjFPyW53O+zzv9z2/8zzPm8v9O+EBs+G5C/PYwy1e8IwydjGHzrSASO9Yw53musFMWkDtBiWMoh89KGAJZ7G4TeTTAj4iGxrE5rGA1yokCeCxBnKfIGcsBpnOZSEsBsA1OrIAtOM8QL6qMAtIKQB2sgIUAqCcFaAvACr1Fg9wGnn5C4CneotH4Se1tQAYydqilQDYatSZQy2U6UXDMsVqCJj8AaAYcq++bbTQ8scYTLn5ON7C7JpKmjSAiQS2FMPmkdbTnGo/JA3H3nWjN1TLcszz6OTricZ1zWdvVG8snNS5K6qeJ7OlCfAwjOQKLrEdVUsmk/NP6RMF7x7W2Ivt4AAAAABJRU5ErkJggg=="></div>
    <div class="bg"></div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2" id="main-container">
            <div class=" " style=" margin-top: 200px;width:100%; ">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error-status'))
                <div class="alert alert-danger">
                    {{ session('error-status') }}
                </div>
            @endif

            <form class="form-horizontal" action="{{url('user/config/change_password')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                    <label for="old_password" class="col-md-4 control-label">@lang('Old Password')</label>

                    <div class="col-md-6">
                        <input id="old_password" type="password" class="form-control" name="old_password" value="{{ old('old_password') }}" required>

                        @if ($errors->has('old_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                    <label for="new_password" class="col-md-4 control-label">@lang('New Password')</label>

                    <div class="col-md-6">
                        <input id="new_password" type="password" class="form-control" name="new_password" value="{{ old('new_password') }}" required>

                        @if ($errors->has('new_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('new_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-danger">@lang('Submit')</button>
                    </div>
                </div>
            </form>

            </div>
        </div>
    </div>
</div>
<style>
    
</style>
@endsection



<style> 
.StripeElement {
box-sizing: border-box; 
height: 40px; 
padding: 10px 12px; 
border: 1px solid transparent;
border-radius: 4px;
background-color: white; 
box-shadow: 0 1px 3px 0 #e6ebf1;
-webkit-transition: box-shadow 150ms ease;
transition: box-shadow 150ms ease;
} 
.StripeElement--focus {
box-shadow: 0 1px 3px 0 #cfd7df;
} 
.StripeElement--invalid {
border-color: #fa755a;
} 
.StripeElement--webkit-autofill {
background-color: #fefde5 !important;
}
</style>

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
                        <table class="table table-bordered table-data-div table-hover"> 
                            <thead>
                                <tr>
                                    <th>@lang('Fee name')</th>
                                    <th>@lang('Payment status')</th>
                                    <th>@lang('Amount')</th> 
                                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant'  )
                                    <th scope="col">@lang('Actions')</th>
                                    @endif
                                </tr>
                            </thead> 
                            <tbody>   
                                @foreach ($fees as $fee)

                                    <tr
                                    {{-- @if(!($fee->payment))
                                    style="cursor: pointer"
                                    data-toggle="modal" data-target="#myModal{{$fee->id}}"
                                    @endif --}}
                                    > 
                                        <td><a href="{{url('stripe/balance/view-status/'.$user_id.'/'.$fee->id.'')}}">{{ $fee->fee_name }}</a></td>
                                        <td>
                                            @if($fee->payment)
                                            <span class="label label-success"> Paid </span>
                                            @else
                                            <span class="label label-warning"> Not paid </span>
                                            @endif
                                        </td>                                                                           
                                        <td>{{ $fee->balance }}</td>
                                        
                                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant'  )
                                        <td style="display:flex; column-gap:7px;">
                                          <a class="btn btn-xs btn-sm btn-success" href="{{url('stripe/balance/status/'.$user_id.'/'.$fee->id)}}" ><i class="material-icons">edit</i> </a>    
                                        </td>
                                        @endif
                                    </tr> 
                                    
{{-- <div class="modal fade" id="myModal{{$fee->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">@lang('Payment') {{$fee->name}}</h4>
            </div>
            <div class="modal-body">   
                
                <form   action="{{url('stripe/charge/'.  $fee->id .'/'. auth()->user()->id .'')}}" method="post" id="payment-form{{$fee->id}}">
                    {{ csrf_field() }}
                    <input type="hidden" id="stripe_key{{ $fee->id }}" name="stripe_key" value="{{env('STRIPE_KEY')}}">  
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">@lang('Enter your credit card information')</h3>
                        </div>
                        <div class="panel-body"> 
                            <div class="form-group">
                                <label for="amount">@lang('Pay Fee For')</label> 
                                    
                                <input type="hidden" step="any" class="form-control"
                                readonly value="{{ $fee->fee_name }}"
                                id="charge_field" placeholder="Pay Fee For" required>

                                </div>

                            
                            <div class="form-group">
                                <label for="amount">@lang('Amount')</label>
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input type=number step="any" class="form-control"
                                    readonly value="{{ $fee->balance }}"
                                    id="amount" name="amount" placeholder="@lang('Amount')" required>
                                </div>
                            </div>
                            

                            <br>


                            <label for="card-element{{ $fee->id }}">@lang('Card Number')</label>
                            <div id="card-element{{ $fee->id }}">
                            <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <div id="card-errors{{ $fee->id }}">

                            </div>
                        <div class="panel-footer">
                            <button class="btn btn-sm btn-success" type="submit">@lang('Pay')</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

<script>
// Create a Stripe client.
var stripe{{ $fee->id }} = Stripe(document.getElementById("stripe_key{{ $fee->id }}").value);

// Create an instance of Elements.
var elements{{ $fee->id }} = stripe{{ $fee->id }}.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
        color: '#aab7c4'
    }
    },
    invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card{{ $fee->id }} = elements{{ $fee->id }}.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card{{ $fee->id }}.mount('#card-element{{ $fee->id }}');

// Handle real-time validation errors from the card Element.
card{{ $fee->id }}.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors{{ $fee->id }}');
    if (event.error) {
    displayError.textContent = event.error.message;
    } else {
    displayError.textContent = '';
    }
});

// Handle form submission.
var form{{ $fee->id }} = document.getElementById('payment-form{{ $fee->id }}');
form{{ $fee->id }}.addEventListener('submit', function(event) {
    event.preventDefault(); 
    stripe{{ $fee->id }}.createToken(card{{ $fee->id }}).then(function(result) {
    if (result.error) {
        // Inform the user if there was an error.
        var errorElement = document.getElementById('card-errors{{ $fee->id }}');
        errorElement.textContent = result.error.message;
    } else {
        // Send the token to your server.
        stripeTokenHandler{{ $fee->id }}(result.token);
    }
    });
});

// Submit the form with the token ID.
function stripeTokenHandler{{ $fee->id }}(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form{{ $fee->id }}');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
</script>  --}}



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
@endsection 
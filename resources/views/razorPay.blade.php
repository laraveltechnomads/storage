<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel - Razorpay Payment Gateway Integration</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-3 col-md-offset-6">
                        <div class="card card-default">
                            <div class="card-header text-center">
                                 Client Razorpay Payment Gateway Integration
                            </div>
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Name :- </th>
                                        <td>{{$client->fname.' '.$client->lname}}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile No :- </th>
                                        <td>{{$client->contact_no}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email :- </th>
                                        <td>{{$client->email_address}}</td>
                                    </tr>
                                    <tr>
                                        <th>Paid Amount :- </th>
                                        <td>RS. {{$get_plan->amount/100}}</td>
                                    </tr>
                                    <tr>
                                        <th>Invoice No :- </th>
                                        <td>{{$client->invoice_no}}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status :- </th>
                                        <td>
                                            @if($get_plan->status == 0)
                                                <span class="badge badge-danger">Cancelled</span>
                                            @elseif($get_plan->status == 1)
                                                <span class="badge badge-success">Complete</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @php
                                $plan = DB::table('plans')->where('id',$get_plan->plan_id)->first();                                
                            @endphp
                            <div class="card-body text-center">
                                <form action="{{ route('razorpay.payment.store') }}" method="POST" class="post-form">
                                    @csrf
                                    <input type="hidden" name="email" value="{{$client->email_address}}">
                                    <input type="hidden" name="fname" value="{{$client->fname}}">
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ env('RAZORPAY_KEY') }}"
                                            data-amount="{{$plan->amount * 100 / 100}}"
                                            data-buttontext="Pay {{$plan->amount / 100}} INR"
                                            data-name="Multiply.com"
                                            data-description="Razorpay"
                                            data-image="https://www.itsolutionstuff.com/frontTheme/images/logo.png"
                                            data-prefill.name="name"
                                            data-prefill.name="{{$client->fname}}"
                                            data-prefill.contact="{{$client->contact_no}}"
                                            data-prefill.email="{{$client->email_address}}"
                                            data-theme.color="#ff7529">
                                    </script>
                                </form>
                                <div>
                                    <button class="btn btn-primary go-to-home" id="rzp-button1">Go To Home</button>
                                </div>
                            </div>
                        </div>
  
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src = "https://checkout.razorpay.com/v1/checkout.js"> </script>
    <script>
    $( document ).ready(function() {
        var status = "{{$client->pay_status}}";
        $('.go-to-home').hide();
        if(status == 1){
            $(".post-form").hide();
            $('.go-to-home').show();
        }
        $(".go-to-home").click(function(){
            location.href = "{{route('login')}}";
        });
    })
//     var options = {
//     "key": "rzp_test_bK6XhPAm732VtU",
//     "subscription_id": "sub_JHvhMmuFBpdpcl",
//     "name": "Acme Corp.",
//     "description": "Monthly Test Plan",
//     "image": "/your_logo.png",
//     "callback_url": "https://eneqd3r9zrjok.x.pipedream.net/",
//     "prefill": {
//       "name": "Gaurav Kumar",
//       "email": "gaurav.kumar@example.com",
//       "contact": "+919876543210"
//     },
//     "notes": {
//       "note_key_1": "Tea. Earl Grey. Hot",
//       "note_key_2": "Make it so."
//     },
//     "theme": {
//       "color": "#F37254"
//     }
//   };
//     var rzp1 = new Razorpay(options);
//     document.getElementById('rzp-button1').onclick = function (e) {
//       rzp1.open();
//       e.preventDefault();
//     }
    </script>
</body>
</html>
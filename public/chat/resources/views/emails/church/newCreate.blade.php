<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, {{$church->church_name}}</title>
  </head>
  <body>
    <h1>Hello, {{$church->church_name}}</h1>
    <div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
        <div style="margin:50px auto;width:70%;padding:20px 0">
          <div style="border-bottom:1px solid #eee">
            <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">{{config('app.name')}}</a>
          </div>
          	<div class="modal-header">
			    <h5 class="modal-title" id="demoModalLabel">{{ __('Church List')}}</h5>
			</div>
			<div class="col-md-6">
			    <div class="card-block">
			        <div class="table">
			            <table class="table table-hover mb-0">
			                <tbody>
			                    <tr>
			                        <td style="background-color: none;">Church Name</td>
			                        <td>: {{ Str::title($church->church_name)}}</td>
			                    </tr>
			                    <tr>
			                        <td>Email</td>
			                        <td>: {{ $church->email}}</td>
			                    </tr>
			                    <tr>
			                        <td>Password</td>
			                        <td>: {{  Crypt::decryptString($church->password)}}</td>
			                    </tr>
			                    <tr>
			                        <td>Mobile Number</td>
			                        <td class="col-md-6">: {{ $church->mobile_number}}</td>
			                    </tr>
			                    <tr>
			                        <td>Website </td>
			                        <td>: {{ $church->website_url}}</td>
			                    </tr>
			                    <tr>
			                        <td>Location :</td>
			                        <td>: {!! $church->location !!}</td>
			                    </tr>
			                    <tr>
			                        <td>Church Image :</td>
			                        <td>: <img width="200" height="200" src="{{ asset('storage/church') }}/{{$church->church_image}}" alt="Church image"> </td>
			                    </tr>			                    
			                </tbody>
			            </table>
			        </div>
			    </div>
			</div>
          <h2></h2>
          <p style="font-size:0.9em;">Regards,<br />{{project('app_name')}}</p>
          <hr style="border:none;border-top:1px solid #eee" />
        </div>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  </body>
</html>
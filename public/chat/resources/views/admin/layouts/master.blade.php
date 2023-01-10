<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" href="{{ asset('/')}}assets/admin/images/logo/favicon.ico" />
        <title> {{ config('app.name') }} | @yield('title','')</title>
        <!-- Google Font: Source Sans Pro -->
        @include('admin.partials.css') 
        @stack('style')
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            @include('admin.partials.header')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @if(auth()->user()->isAdmin())
                @include('admin.partials.sidebar')
            @else
                @include('church.partials.sidebar')
            @endif
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @stack('breadcrumb')
                {{-- @include('admin.partials.flash_message') --}}
                <!-- Main content -->
                <section class="content">
                    @yield('content')
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            @include('admin.partials.footer')
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <!-- jQuery -->
        @include('admin.partials.js')

        @stack('script')

        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.5/push.js"></script>

        <script type="text/javascript">
            var PUSHER_APP_KEY = '{{ env("PUSHER_APP_KEY") }}';
            var PUSHER_APP_CLUSTER = '{{ env("PUSHER_APP_CLUSTER") }}';
            var PUSHER_APP_CHANNELNAME = '{{ env("PUSHER_APP_CHANNELNAME") }}';
            var PUSHER_APP_EVENTNAME = '{{ env("PUSHER_APP_EVENTNAME") }}';
            // Enable pusher logging - don't include this in production
            //Pusher.logToConsole = true;
            var pusher = new Pusher( PUSHER_APP_KEY , {
                cluster: PUSHER_APP_CLUSTER
            });

            var channel = pusher.subscribe(PUSHER_APP_CHANNELNAME);
                channel.bind(PUSHER_APP_EVENTNAME, function(data) {
                    console.log('data-check:', data)
                    Push.create(data.data.title, {
                        body: data.data.message,
                        icon: data.data.icon,
                        image: data.data.image.
                        link = data.data.linkurl,
                        timeout: 5000,
                        onClick: function() {
                            console.log(this);
                        }
                    });
                    // alert(JSON.stringify(data));
                    var dataAll = JSON.stringify(data);
                    console.log('dataAll:', dataAll);
                    console.log('data:', data.data);
                    if(data.data){
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info('User Created.');
                    }
                    document.getElementById("newUserCount").textContent=data.count;
                    var element = document.getElementById("newUSerBell");
                    element.classList.add("faa-ring");
                    document.getElementsByClassName("bell-notification-show").style.display = "none";
                    
                        
                sendPushernotification(data);  //alert(JSON.stringify(data)); 
            });
            
            $('a.ringing-bell').click(function(){
                console.log('bell click')
                $('div#notification-load').load("{{ route('admin.get.bell-notifications') }}");
            });

            
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#sendPushNotification').on('click', function(){
                    Push.create("Hello world!", {
                        body: "This is my first notification :)",
                        icon: '/notification.png',
                        timeout: 40000,
                        onClick: function () {
                            window.focus();
                            this.close();
                        }
                    });
                });
            });
        </script>        
        
    </body>

</html>

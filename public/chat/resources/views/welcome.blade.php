<!DOCTYPE html>
<html>
<head>
    <title>Web push notification using push.js - LaravelCode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/serviceWorker.min.js"></script>
</head>
<body>
    <div class="container text-center">
        <h1>Web push notification using push.js - LaravelCode</h1>
        <div>
            <button class="btn btn-info" id="sendPushNotification">Send Push Notification.</button>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#sendPushNotification').on('click', function(){
                Push.Permission.has();
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
        Push.create("Hello world!", {
                    body: "This is my first notification :)",
                    icon: '/notification.png',
                    timeout: 40000,
                    onClick: function () {
                        window.focus();
                        this.close();
                    }
                });
    </script>
</body>
</html>
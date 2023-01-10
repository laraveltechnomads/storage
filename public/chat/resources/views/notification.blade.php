<html>
    <head>
        <title></title>
        <h1>Pusher Notification</h1>
        {{-- <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
        <script>
       
         var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
            cluster: '{{env("PUSHER_APP_CLUSTER")}}',
            encrypted: true
          });
            
       
          var channel = pusher.subscribe('biblelaravel');
          channel.bind('App\\Events\\NewUser', function(data) {
            alert('data.message:', data.message);
          });
        </script> --}}
        <button class="request-button">Request permissions</button>
        <button class="show-button">Show notification</button>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.5/push.js"></script>
        <script>
          const requestButton = document.querySelector(".request-button");
          const showButton = document.querySelector(".show-button");

          function onGranted() {
              requestButton.style.background = "green";
          }

          function onDenied() {
              requestButton.style.background = "red";
          }

          requestButton.onclick = function() {
              Push.Permission.request(onGranted, onDenied);
          }

          showButton.onclick = function() {
              Push.create("Hello from Sabe.io!", {
                  body: "This is a web notification!",
                  icon: "/icon.png",
                  timeout: 5000,
                  onClick: function() {
                      console.log(this);
                  }
              });
          };
        </script>
          

        {{-- <a href="javascript:void(0)" onclick="start()">Start</a>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.12/push.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/serviceWorker.min.js"></script>

        <script>
          function start(){
              Push.create('Hello World!');
          }
      </script> --}}
      </head>
      <body>

      </body>
</html>

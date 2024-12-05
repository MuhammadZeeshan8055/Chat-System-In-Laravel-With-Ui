<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
    <title>ChatApp - Login</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body {
            background: #eee;
        }

        .chat-list {
            padding: 0;
            font-size: .8rem;
        }

        .chat-list li {
            margin-bottom: 10px;
            overflow: auto;
            color: #ffffff;
        }

        .chat-list .chat-img {
            float: left;
            width: 48px;
        }

        .chat-list .chat-img img {
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
            width: 100%;
        }

        .chat-list .chat-message {
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
            background: #5a99ee;
            display: inline-block;
            padding: 10px 20px;
            position: relative;
        }

        .chat-list .chat-message:before {
            content: "";
            position: absolute;
            top: 15px;
            width: 0;
            height: 0;
        }

        .chat-list .chat-message h5 {
            margin: 0 0 5px 0;
            font-weight: 600;
            line-height: 100%;
            font-size: .9rem;
        }

        .chat-list .chat-message p {
            line-height: 18px;
            margin: 0;
            padding: 0;
        }

        .chat-list .chat-body {
            margin-left: 20px;
            float: left;
            width: 70%;
        }

        .chat-list .in .chat-message:before {
            left: -12px;
            border-bottom: 20px solid transparent;
            border-right: 20px solid #5a99ee;
        }

        .chat-list .out .chat-img {
            float: right;
        }

        .chat-list .out .chat-body {
            float: right;
            margin-right: 20px;
            text-align: right;
        }

        .chat-list .out .chat-message {
            background: #fc6d4c;
        }

        .chat-list .out .chat-message:before {
            right: -12px;
            border-bottom: 20px solid transparent;
            border-left: 20px solid #fc6d4c;
        }

        .card .card-header:first-child {
            -webkit-border-radius: 0.3rem 0.3rem 0 0;
            -moz-border-radius: 0.3rem 0.3rem 0 0;
            border-radius: 0.3rem 0.3rem 0 0;
        }

        .card .card-header {
            background: #17202b;
            border: 0;
            font-size: 1rem;
            padding: .65rem 1rem;
            position: relative;
            font-weight: 600;
            color: #ffffff;
        }

        .content {
            margin-top: 40px;
        }

        .height3 {
            height: 380px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container content">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">Chat</div>
                    <div class="card-body height3">
                        <ul class="chat-list" id="chat-section">

                        </ul>
                    </div>
                </div>
                <div class="row mt-3 justify-content-between">
                    <div class="col-lg-10">
                        <input type="text" name="username" value="{{ $username }}" id="username" hidden>
                        <input type="text" class="form-control" placeholder="Wrtie message here..."
                            id="chat_message">
                    </div>
                    <div class="col-lg-2 justify-content-center">
                        <button class="btn btn-primary rounded" onclick="broadcastMessage()">Send</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
<script>
    function broadcastMessage() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{ route('broadcast') }}',
            type: 'POST',
            data: {
                username: $('#username').val(),
                msg: $('#chat_message').val()
            },
            success: function(result) {
                console.log(result);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>

@vite('resources/js/app.js')
<script type="module">
    // This code will run after Echo is initialized in app.js
    Echo.channel('chat_message').listen('chat', (data) => {
        let newMessage;
        if (data.username == $('#username').val()) {
            newMessage = `<li class="out">
                                <div class="chat-img">
                                    <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                </div>
                                <div class="chat-body">
                                    <div class="chat-message">
                                        <h5>${data.username}</h5>
                                        <p>${data.message}</p>
                                    </div>
                                </div>
                            </li>`;
        } else {
            newMessage = `<li class="in">
                                <div class="chat-img">
                                    <img alt="Avtar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                </div>
                                <div class="chat-body">
                                    <div class="chat-message">
                                        <h5>${data.username}</h5>
                                        <p>${data.message}</p>
                                    </div>
                                </div>
                            </li>`;
        }


        console.log(data.message);
        $('#chat-section').append(newMessage);
        $('#chat_message').val('');
    });
</script>

@extends('layouts.front')

@section('content')
<!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message" style="min-height:650px;">
                        <h1>REDIS RESULT</h1>
                        <hr class="intro-divider">
                        <p id="power">0</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->
@endsection


@section('additional_scripts')
    {!! Html::script('js/socket.io.js') !!}
    <script>
    var socket = io('http://localhost:3000');
    socket.on("test-channel:App\\Events\\MyEventNameHere", function(message){
         // increase the power everytime we load test route
         $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
     });
    </script>
@endsection

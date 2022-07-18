@extends('layouts.backend')
<style>
    #results {
        /*padding: 10px;*/
        border:1px solid goldenrod;
        background:#ccc;
        width: 320px !important;
        height: 240px !important;
    }
</style>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-0">
                <div class="flex-grow-0">
                    <h5 class="h5 fw-bold mb-0">
                        Admissions
                    </h5>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Admissions</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Student ID
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="d-flex justify-content-around py-3">
        <form method="POST" action="{{ route('courses.storeStudentId', $app->id) }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div id="my_camera"></div>
                    <input class="btn btn-alt-info btn-sm mt-3 mb-2" type=button value="Take Snapshot" onClick="take_snapshot()">
                    <input type="hidden" name="image" class="image-tag">
                </div>
                <div class="col-md-6">
                    <div id="results">Your captured image will appear here...</div>
                    <button class="btn btn-alt-success btn-sm mt-3 mb-2">Upload image</button>
                </div>
            </div>
        </form>
    </div>
        </div>
    </div>

    <script language="JavaScript">
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach( '#my_camera' );

        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            } );
        }
    </script>

{{--    <style>--}}
{{--        #my_camera{--}}
{{--            width: 320px !important;--}}
{{--            height: 240px !important;--}}
{{--            /*border: 1px solid black;*/--}}
{{--        }--}}
{{--    </style>--}}

{{--    <div class="content">--}}
{{--        <div class="block block-rounded">--}}
{{--            <div class="d-flex justify-content-around py-3">--}}
{{--               <form method="post" action="{{ route('courses.storeStudentId', $app->id) }}">--}}
{{--                   @csrf--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div id="my_camera"></div>--}}
{{--                        <input type=button value="Take photo" onClick="take_snapshot()">--}}
{{--                        <input type="hidden" name="image" class="image-tag" >--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div id="results" > </div>--}}
{{--                        <button class="btn btn-sm btn-alt-success mt-4 mb-2" data-toggle="click-ripple">Submit</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script language="JavaScript">--}}
{{--        Webcam.set({--}}
{{--            width: 320,--}}
{{--            height: 240,--}}
{{--            image_format: 'jpeg',--}}
{{--            jpeg_quality: 100--}}
{{--        });--}}
{{--        Webcam.attach( '#my_camera' );--}}
{{--    </script>--}}

{{--    <script language="JavaScript">--}}

{{--        function take_snapshot() {--}}

{{--            // take snapshot and get image data--}}
{{--            Webcam.snap( function(data_uri) {--}}
{{--                // display results in page--}}
{{--                document.getElementById('results').innerHTML =--}}
{{--                    '<img src="'+data_uri+'"/>';--}}
{{--            } );--}}
{{--        }--}}
{{--    </script>--}}
@endsection


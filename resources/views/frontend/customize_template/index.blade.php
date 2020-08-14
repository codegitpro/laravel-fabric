@extends('frontend.layout.default')

@section('css')
    <style>
        body {
            font-family: roboto !important;
        }

        @foreach($fonts as $font)
@font-face {
            font-family: "{{$font->slug}}";
            <?php $fontPath = str_replace('\\', '/', $font->path); ?>
    src: url("{{url("/public/". $fontPath)}}");
        }
        @endforeach
    </style>
@endsection
@section('content')

    <script type="text/javascript">
        var mapJsonString = "{{ $fontSlugPathMap }}".split("&quot;").join('"');
        var fontSlugPathMap = JSON.parse(mapJsonString);
        var mapingBackgroundInfo = JSON.parse("{{json_encode($mapingBackgroundInfo)}}".split("&quot;").join('"'));
    </script>
    <nav class="navbar">
        <a class="navbar-brand" href="javascript:void(0)">
            <img style="width: 80px;height: 80px;border-radius: 50%;" src="{{$logo->brand_logo}}"/>
        </a>
        <span style="font-size: 1.3rem;">{{$logo->brand_name}}</span>
    </nav>

    <!--Editor Page-->

    <div class="editor-page">

        <!-- Modal - Submit-->

        <div class="modal submit-modal fade" id="SubmitModal" tabindex="-1" role="dialog"
             aria-labelledby="SubmitModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="SubmitModalTitle">
                            Caution
                        </h3>
                        <a class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="modal-text">
                            <div class="row">
                                <div class="info">
                                    <p>
                                        You are about to submit this design for printing, are you sure?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="footer-button">
                            <div class="row">
                                <div class="button">
                                    <a class="btn btn-block btn-customize" data-dismiss="modal">
                                        Customizing
                                    </a>
                                </div>
                                <div class="button">
                                    <a class="btn btn-block btn-process" onclick="submitDesignForPrint()">
                                        Submit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <!--Content Section-->

                <div class="wrapper-content">
                    <div class="row">
                        <div class="wrapper-col print">
                            <div class="row">
                                <div class="print-image">
                                    <div class="row">
                                        <div id="drawingArea"
                                             style=";z-index: 10;width: {{$mapingBackgroundInfo["width"]}}px;height: {{$mapingBackgroundInfo["height"]}}px; background-image:url('{{$productBackgroundUrl}}'); background-size: cover;">
                                            <canvas id="canvasEle"
                                                    width={{$mapingBackgroundInfo["width"]}} height={{$mapingBackgroundInfo["height"]}} class="hover"
                                                    style="-webkit-user-select: none;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="print-text">
                                    <div class="row">
                                        <div class="caption">
                                            <p class="font-caption font-semi-bold text-uppercase">
                                                Max Print Area
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Sidebar Section-->

                <div class="wrapper-sidebar">
                    <div class="tabs primary">
                        <ul class="nav nav-pills" id="pills-sidebar-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-design-tab" data-toggle="pill" href="#pills-design"
                                   role="tab" aria-controls="pills-design" aria-selected="true">
                                    Design
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-upload-photo-tab" data-toggle="pill"
                                   href="#pills-upload-photo" role="tab" aria-controls="pills-upload-photo"
                                   aria-selected="false">
                                    Upload Photo
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-sidebar-tab-content">
                            <div class="tab-pane fade show active" id="pills-design" role="tabpanel"
                                 aria-labelledby="pills-design-tab">
                                <div class="wrapper-col design">
                                    <div class="row">
                                        <div class="col-inner font">
                                            <div class="row">
                                                <div class="font-box">
                                                    <div class="row">
                                                        <div class="caption">
                                                            <p class="font-caption font-light">
                                                                Font Style
                                                            </p>
                                                        </div>
                                                        <div class="box">
                                                            <div class="select-box primary">
                                                                <select name="sources" id="sources"
                                                                        class="custom-select-box sources"
                                                                        placeholder="Choose Font">
                                                                    @foreach($fonts as $font)
                                                                        <option value="{{$font->slug}}"
                                                                                @if($font->id == $template->font_id) selected="selected" @endif>{{$font->edited_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-inner text">
                                            <div class="row">
                                                <div class="text-box">
                                                    <div class="row">
                                                        <div class="caption">
                                                            <p class="font-caption font-light">
                                                                Text
                                                            </p>
                                                        </div>
                                                        <div class="box">
                                                            <div class="input-box primary">
                                                                <input id="text-string" type="text"
                                                                       placeholder="Type Your Text Here"/>
                                                            </div>
                                                        </div>
                                                        <div class="button" id="add_text">
                                                            <a class="btn btn-block btn-add" href="#">
                                                                <i class="fas fa-plus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-inner action">
                                            <div class="row">
                                                <div class="action-icon">
                                                    <a class="icon zoom-in" onclick="zoomInActiveObj()">
                                                        <img
                                                            src="{{url('/public/frontend/images/Editor/icon-zoom-in.svg')}}"/>
                                                    <!-- <img src="{{url('/frontend/images/Editor/icon-zoom-in.svg')}}" /> -->
                                                    </a>
                                                    <a class="icon zoom-out" onclick="zoomOutActiveObj()">
                                                        <img
                                                            src="{{url('/public/frontend/images/Editor/icon-zoom-out.svg')}}"/>
                                                    <!-- <img src="{{url('/frontend/images/Editor/icon-zoom-out.svg')}}" /> -->
                                                    </a>
                                                    <a class="icon rotate-right" onclick="rotateRightActiveObject()">
                                                        <img
                                                            src="{{url('/public/frontend/images/Editor/icon-rotate-right.svg')}}"/>
                                                    <!-- <img src="{{url('/frontend/images/Editor/icon-rotate-right.svg')}}" />  -->
                                                    </a>
                                                    <a class="icon rotate-left" onclick="rotateLeftActiveObject()">
                                                        <img
                                                            src="{{url('/public/frontend/images/Editor/icon-rotate-left.svg')}}"/>
                                                    <!-- <img src="{{url('/frontend/images/Editor/icon-rotate-left.svg')}}" /> -->
                                                    </a>
                                                    <a class="icon " onclick="deleteActiveObj()" data-toggle="tooltip"
                                                       data-placement="top" title="Select text/image to delete">
                                                        <img src="{{url('/public/frontend/images/Editor/delete.png')}}"
                                                             style="width: 25px;height: 25px;"/>
                                                    <!-- <img src="{{url('/frontend/images/Editor/delete.png')}}" style="width: 25px;height: 25px;" /> -->
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-inner appearance">
                                            <div class="row">
                                                <div class="appearance-color">
                                                    <div class="row">
                                                        <div class="caption">
                                                            <p class="font-caption font-light">
                                                                Text Color Options
                                                            </p>
                                                        </div>
                                                        <div class="color-variant">
                                                            <a class="color black">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color red">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color blue-light">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color blue">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color pink">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color orange">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color white">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color purple">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color yellow">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color cream">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color green-pastel">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color blue-pastel">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color red-pastel">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                            <a class="color purple-pastel">
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-upload-photo" role="tabpanel"
                                 aria-labelledby="pills-upload-photo-tab">
                                <div class="wrapper-col upload-photo">
                                    <div class="row">
                                        <div class="col-inner upload">
                                            <div class="row">
                                                <form method="post" action="" enctype="multipart/form-data" id="myform">
                                                    <input type="file" id="fileLoader" name="file" title="Load File"
                                                           style="visibility: hidden;"/>
                                                </form>
                                                <div class="upload-button">
                                                    <div class="row">
                                                        <div class="button" onclick="openFileSelector()">
                                                            <a class="btn btn-block btn-upload">
                                                                Upload Photo <i class="fas fa-upload"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="upload-image">
                                                    <div class="row" id="uploadedImageContainer">
                                                    <!--<div class="image">
                                                            <a class="upload-picture" href="#">
                                                                <img  class="img-polaroid" src="{{url('/public/frontend/images/Editor/p1.jpg')}}" />
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                        </div>
                                                        <div class="image">
                                                            <a class="upload-picture" href="#">
                                                                <img  class="img-polaroid"src="{{url('/public/frontend/images/Editor/p2.jpg')}}" />
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                        </div>
                                                        <div class="image">
                                                            <a class="upload-picture" href="#">
                                                                <img class="img-polaroid" src="{{url('/public/frontend/images/Editor/p3.jpg')}}" />
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                        </div>
                                                        <div class="image">
                                                            <a class="upload-picture" href="#">
                                                                <img class="img-polaroid" src="{{url('/public/frontend/images/Editor/p4.jpg')}}" />
                                                                <i class="fas fa-check-circle"></i>
                                                            </a>
                                                        </div>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-footer">
                            <a class="btn btn-block btn-submit" data-toggle="modal" data-target="#SubmitModal">
                                Submit Design For Printing
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            //  $('[data-toggle="tooltip"]').tooltip();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on("click", ".deleteTemplate", function () {
                var id = $(this).attr('id');
                var request = $.ajax({
                    url: "{{route('dashboardDeleteTemplate')}}",
                    method: "POST",
                    data: {id: id},
                    datatype: "json"
                });
                request.done(function (response) {
                    window.location.reload();
                });

                request.fail(function (jqXHR, textStatus) {
                });
            });
            $(document).on("click", ".img-polaroid", function (e) {
                // $(".img-polaroid").click(function(e){
                var el = e.target;
                /*temp code*/
                console.log(el);

                addImageTocanvasByURL(el.src);
            });
            $("#fileLoader").change(function (e) {
                // var fd = new FormData($("#myform"));
                var formData = new FormData();
                var files = $(this)[0].files[0];
                formData.append('file', files);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var request = $.ajax({
                    url: "{{route('frontendUploadPhooto')}}",
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                    // }
                });
                request.done(function (response) {
                    var imageSrc = response.uploadedPhoto;
                    var ImgDiv = '\
               <div class="" style="margin:15px;">\
                    <a class="" href="#">\
                        <img  class="" src="' + imageSrc + '" />\
                        <i class="fas fa-check-circle"></i>\
                    </a>\
                </div>';
                    $('#uploadedImageContainer').append(ImgDiv);
                });
                request.fail(function (jqXHR, textStatus) {
                });
            });
            var ctx = canvas.getContext('2d');
            var img = new Image;
            img.onload = function () {
                ctx.drawImage(img, 0, 0);
                //addImageTocanvasByURL(this.src);
            };
            img.src = "{{$productBackgroundUrl}}";
        });

        function submitDesignForPrint() {

            var urlSegments = window.location.pathname.split('/');
            var urlSegmentsFiltered = urlSegments.filter(function (el) {
                return el != '';
            });
            var canvasObjs = canvas.getObjects();
            var usedFontMap = {};
            var isImagePresent = false;
            for (var key in canvasObjs) {
                if (canvasObjs[key].type == 'image')
                    isImagePresent = true;
                if (canvasObjs[key] && canvasObjs[key].type == 'text' && fabric.fontPaths[canvasObjs[key].fontFamily]) {
                    usedFontMap[canvasObjs[key].fontFamily] = fabric.fontPaths[canvasObjs[key].fontFamily];
                }

            }
            /*if(!isImagePresent){
               canvas.backgroundColor='RDG_WHITE';
            }*/
            var svg = canvas.toSVG();
            var abc = {};
            var webpImage = canvas.toDataURL('png');
            abc.fontMap = usedFontMap;
            // console.log(usedFontMap);
            // console.log("222222222222")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var request = $.ajax({
                url: "{{route('frontendSaveOrder')}}",
                method: 'POST',
                data: {svg, urlSegmentsFiltered, usedFontMap: JSON.stringify(usedFontMap), 'webpImage': webpImage},
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                // }
            });
            request.done(function (response) {
                alert(response.message);
            });
            request.fail(function (jqXHR, textStatus) {
            });
        }
    </script>
@endsection

@extends('backend.layout.default')
@section('content')

	<div class="modal new-font-modal fade" id="NewFontModal" tabindex="-1" role="dialog" aria-labelledby="NewFontModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <!--Modal Header Section-->

                <div class="modal-header">
                    <h3 id="NewFontModalTitle">
                        New Font
                    </h3>
                    <a class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </a>
                </div>

                <!--Modal Body Section-->

                <form id="create_font" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="body-inner">
                            <div class="row">
                                <div class="font-box">
                                    <div class="row">
                                        <div class="caption">
                                            <p>
                                                Font
                                            </p>
                                        </div>
                                        <div class="box">
                                            <div class="submit-box primary">
                                                <input type="file" name="font_file" id="font_file" class="inputfile" required />
                                                <label for="font_file"><span></span> <strong><i class="fas fa-upload"></i>Choose a file</strong></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="font-edit-name-box">
                                    <div class="row">
                                        <div class="caption">
                                            <p>
                                                Font Edit Name
                                            </p>
                                        </div>
                                        <div class="box">
                                            <div class="input-box primary">
                                                <input type="text" placeholder="Type Your Text Here" name="edited_name" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!--Modal Footer Section-->

                    <div class="modal-footer">
                        <div class="footer-button">
                            <div class="row">
                                <div class="button" >
                                    <input type="submit" href="javascript:void(0)" class="btn btn-block btn-add-modal"></input>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="page dashboard-font-page toggled">

        <!--Table Section-->

        <div class="section table">
            <div class="container-fluid">
                <div class="row">

                    <!--Table Header Section-->

                    <div class="wrapper-col table-header">
                        <div class="row">
                            <div class="col-inner">
                                <div class="row">
                                    <div class="header-text">
                                        <div class="row">
                                            <div class="title">

                                                @if(session()->has('error'))
                                                <div class="alert alert-error badge-danger text-center text-danger text-light">
                                                    {!! session('error') !!}
                                                </div>
                                                @endif

                                                @if(session()->has('success'))
                                                <div class="alert alert-error badge-info text-center text-info text-light">
                                                    {!! session('success') !!}
                                                </div>
                                                @endif
                                                <h3>
                                                    Fonts
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Table Action Section-->

                    <div class="wrapepr-col table-action">
                        <div class="row">
                            <div class="col-inner">
                                <div class="row">
                                    <div class="action-search">
                                        <div class="row">
                                            <div class="search">
                                                <div class="input-box primary">
                                                    <form action="{{ route('backendFontsSearch') }}" >
                                                        <input type="text" name="search_font" placeholder="Search Font" />
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action-button">
                                        <div class="row">
                                            <div class="button">
                                                <a class="btn btn-block btn-add" data-toggle="modal" data-target="#NewFontModal">
                                                    <i class="fas fa-plus"></i>New Font
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action-pagination">
                                        <div class="row">
                                            <div class="pagin-text">
                                                <div class="row">
                                                    <div class="caption">
                                                        <p>
                                                            Show Entries
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pagin-number">
                                                <nav aria-label="...">
                                                    <ul class="pagination">
                                                        <li class="page-item disabled">
                                                            <a class="page-link" href="#" tabindex="-1">
                                                                10
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#">
                                                                25
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#">
                                                                50
                                                            </a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#">
                                                                100
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Table Card Section-->
                    <div class="wrapper-col table-card">
                        <div class="row">
                            @if($fonts->isEmpty())
                            <div class="col-inner">
                                <h3 class="text-center">No Font Found. Please add some Fonts.</h3>
                            </div>
                            @else
                            @foreach($fonts as $index => $font)
                            <div class="col-inner">
                                <div class="custom-card secondary">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="caption">
                                                    <p>
                                                        {{$index + 1}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="caption">
                                                    <p>
                                                        {{$font->name}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="caption">
                                                    <p>
                                                        {{$font->edited_name}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col deleteFonts" id="{{$font->id}}">
                                            <div class="row">
                                                <div class="icon">
                                                    <a class="icon-delete" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
        });

        $(document).on("click",".deleteFonts",function() {
            var id = $(this).attr('id');
            var request = $.ajax({
                url: "{{route('backendFontsDelete')}}",
                method: "POST",
                data:{ id: id},
                datatype: "json"
            });
            request.done(function(response) {
              window.location.reload();
            });

            request.fail(function(jqXHR, textStatus) {
            });
        });
        $("#create_font").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var request = $.ajax({
                url: "{{route('backendFontsCreate')}}",
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            request.done(function(response) {
                window.location.reload();
            });

            request.fail(function(jqXHR, textStatus) {
            });
        });
    });
</script>
@endsection

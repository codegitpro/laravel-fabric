@extends('backend.layout.default')
@section('content')
	<div class="modal new-font-modal fade" id="NewLogoModal" tabindex="-1" role="dialog" aria-labelledby="NewLogoModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <!--Modal Header Section-->

                <div class="modal-header">
                    <h3 id="NewLogoModalTitle">
                        New Mapping
                    </h3>
                    <a class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </a>
                </div>

                <!--Modal Body Section-->

                <form id="create_logo" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="body-inner">
                            <div class="row">
                                <div class="font-box">
                                    <div class="row">
                                        <div class="caption">
                                            <p>
                                                Image
                                            </p>
                                        </div>
                                        <div class="box">
                                            <div class="submit-box primary">
                                                <input type="file" name="product_image_file" id="product_image_file" class="inputfile" required />
                                                <label for="product_image_file"><span></span> <strong><i class="fas fa-upload"></i>Choose an Image</strong></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="font-edit-name-box">
                                    <div class="row">
                                        <div class="caption">
                                            <p>
                                                Product Name
                                            </p>
                                        </div>
                                        <div class="box">
                                            <div class="input-box primary">
                                                <!--  <select class="input-group-text w-100" name="product_name" required>
                                                    <option value="Apple">Apple</option>
                                                    <option value="AirPod">Airpod</option>
                                                    <option value="Samsung">Samsung</option>
                                                    <option value="LG">LG</option>
                                                    <option value="Huswei">Huswei</option>
                                                    <option value="Nokia">Nokia</option>
                                                    <option value="Sony">Sony</option>
                                                    <option value="HTC">HTC</option>
                                                    <option value="Motorola">Motorola</option>
                                                    <option value="Lenovo">Lenovo</option>
                                                    <option value="Xiaomi">Xiaomi</option>
                                                    <option value="Google">Google</option>
                                                    <option value="Honor">Honor</option>
                                                    <option value="Oppo">Oppo</option>
                                                    <option value="Realme">Realme</option>
                                                    <option value="Oneplus">Oneplus</option>
                                                    <option value="Vivo">Vivo</option>
                                                    <option value="Meizu">Meizu</option>
                                                    <option value="Blackberry">Blackberry</option>
                                                    <option value="Asus">Asus</option>
                                                    <option value="Alcatel">Alcatel</option>
                                                    <option value="ZTE">ZTE</option>
                                                    <option value="Microsoft">Microsoft</option>
                                                    <option value="Vodafone">Vodafone</option>
                                                    <option value="Energizer">Energizer</option>
                                                    <option value="Cat">Cat</option>
                                                    <option value="Sharp">Sharp</option>
                                                    <option value="Micromax">Micromax</option>
                                                    <option value="Infinix">Infinix</option>
                                                    <option value="lefone">lefone</option>
                                                    <option value="Tecno">Tecno</option>
                                                    <option value="BLU">BLU</option>
                                                    <option value="Acer">Acer</option>
                                                    <option value="Wiko">Wiko</option>
                                                    <option value="Panasonic">Panasonic</option>
                                                    <option value="Verykool">Verykool</option>
                                                    <option value="Plum">Plum</option>
                                                </select>  -->
                                                <input type="text" placeholder="Type Your Product Here" name="product_name" required />
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
                                    <input type="submit" href="javascript:void(0)" class="btn btn-block btn-add-modal">
                                    </input>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="page dashboard-mapping-page toggled">

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
                                                    Mapping
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
                                                    <input type="text" placeholder="Search Product" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action-button">
                                        <div class="row">
                                            <div class="button">
                                                <a class="btn btn-block btn-add" data-toggle="modal" data-target="#NewLogoModal">
                                                    <i class="fas fa-plus"></i>New Mapping
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
                            @if($mappings->isEmpty())
                            <div class="col-inner">
                                <h3 class="text-center">No Mapping Found. Please add some Mapping.</h3>
                            </div>
                            @else
                            @foreach($mappings as $index => $mapping)
                            <div class="col-inner">
                                <div class="custom-card tertiary">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="caption">
                                                    <p>
                                                        {{$mapping->product_name}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="image">
                                                    <a class="image-pop-up" href="{{$mapping->product_background}}">
                                                        <img src="{{$mapping->product_background}}" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col deleteLogo" id="{{$mapping->id}}">
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

        $(document).on("click",".deleteLogo",function() {
            var id = $(this).attr('id');
            var request = $.ajax({
                url: "{{route('backendMappingDelete')}}",
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
        $("#create_logo").submit(function(e) {
            e.preventDefault();    
            var formData = new FormData(this);
            var request = $.ajax({
                url: "{{route('backendMappingCreate')}}",
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
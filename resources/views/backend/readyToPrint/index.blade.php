@extends('backend.layout.default')
@section('content')
	
	<!-- Page Content -->

    <div class="page dashboard-ready-to-print-page toggled">

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
                                                <h3>
                                                    Ready To Print
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
                                                    <input type="text" placeholder="Search Template" />
                                                </div>
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
                            @if($readyToPrint->isEmpty())
                            <div class="col-inner">
                                <h3 class="text-center">No Order Found.</h3>
                            </div>
                            @else
                            @foreach($readyToPrint as $index => $readyToPrintTemplate)
                            <div class="col-inner">
                                <div class="custom-card quinary">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="image">
                                                    <a class="image-pop-up" href="{{$readyToPrintTemplate->order_image_url}}">
                                                       <div width="90" height="90">       
                                                             <image src="{{$readyToPrintTemplate->order_image_url}}" width="90" height="90"/>    
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="caption">
                                                    <p>
                                                        {{$readyToPrintTemplate->brand_name}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="caption">
                                                    <p>
                                                        {{$readyToPrintTemplate->template_id}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="caption">
                                                    <p>
                                                        {{$readyToPrintTemplate->order_id}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="button">
                                                    <a class="btn btn-block btn-download" href="{{route('backendReadyToPrintDownloadPdf', [$readyToPrintTemplate->order_id])}}">
                                                        <i class="fas fa-download"></i>Download
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
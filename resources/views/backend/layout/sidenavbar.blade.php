<!-- Sidebar -->

<div class="sidebar toggled" id="sidebar-wrapper">
    <div class="row">

        <!--Sidebar Content Section-->
        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
            @csrf
        </form>
        <div class="wrapper-col sidebar-content">
            <div class="row">
                <div class="col-inner">
                    <div class="row">
                        <div class="content-link">
                            <ul class="nav">
                                <li class="nav-item">
                                    @if(Request::url() == route('backendDashboard'))
                                    <a class="nav-link link-main" href="{{route('backendDashboard')}}">
                                    @else
                                    <a class="nav-link" href="{{route('backendDashboard')}}">
                                    @endif
                                        <i class="fas fa-home"></i>All Templates
                                    </a>
                                </li>
                                <li class="nav-item">
                                    @if(Request::url() == route('backendMapping'))
                                    <a class="nav-link link-mapping link-main" href="{{route('backendMapping')}}">
                                    @else
                                    <a class="nav-link link-mapping" href="{{route('backendMapping')}}">
                                    @endif
                                        <i class="fas fa-layer-group"></i>Mapping
                                    </a>
                                </li>
                                <li class="nav-item">
                                    @if(Request::url() == route('backendFonts'))
                                    <a class="nav-link link-font link-main" href="{{route('backendFonts')}}">
                                    @else
                                    <a class="nav-link link-font" href="{{route('backendFonts')}}">
                                    @endif
                                        <i class="fas fa-font"></i>Fonts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    @if(Request::url() == route('backendLogo'))
                                    <a class="nav-link link-logo link-main" href="{{route('backendLogo')}}">
                                    @else
                                    <a class="nav-link link-logo" href="{{route('backendLogo')}}">
                                    @endif
                                        <i class="fas fa-fingerprint"></i>Logo
                                    </a>
                                </li>
                                <li class="nav-item">
                                    @if(Request::url() == route('backendReadyToPrint'))
                                    <a class="nav-link link-ready-to-print link-main" href="{{route('backendReadyToPrint')}}">
                                    @else
                                    <a class="nav-link link-ready-to-print" href="{{route('backendReadyToPrint')}}">
                                    @endif
                                        <i class="fas fa-print"></i>Ready to Print
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Sidebar Footer Section-->

        <div class="wrapper-col sidebar-footer">
            <div class="row">
                <div class="col-inner">
                    <div class="row">
                        <div class="footer-button">
                            <div class="row">
                                <div class="button">
                                    <a class="btn btn-block btn-logout" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>Sign Out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

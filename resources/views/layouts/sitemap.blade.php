<div class="sidebar" id="notifications">
    <div class="sidebar-header d-block align-items-end">
        <div class="align-items-center d-flex justify-content-between py-4">
            Notifications
            <button data-sidebar-close>
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
        <ul class="nav nav-pills">
            @role(['admin','business_unit_head','front_sales_manager','front_sales_executive','support_manager','support_agent','sales_head'])
            <li class="nav-item">
                <a class="nav-link leadassignnotifytab active " data-bs-toggle="tab" href="#leads">Lead</a>
            </li>
            <li class="nav-item">
                <a class="nav-link opportunityassignnotifytab" data-bs-toggle="tab" href="#opportunity">Opportunity</a>
            </li>
            @endrole
            @role(['admin','business_unit_head','project_manager','support_manager','support_agent','quality_assurance_depart','production_manager','design_manager','development_manager','content_manager','video_manager','client','sales_head'])
            <li class="nav-item">
                <a class="nav-link projectassignnotifytab" data-bs-toggle="tab" href="#projects">Project</a>
            </li>
            @endrole
            @role(['admin','business_unit_head','project_manager','support_manager','front_sales_manager','human_resource_manager','sales_head','human_resource_executive','production_manager'])
            <li class="nav-item">
                <a class="nav-link attendancotifytab" data-bs-toggle="tab" href="#attendance">Attendance</a>
            </li>
            @endrole
            <li class="nav-item">
                <a class="nav-link leavesnotifytab" data-bs-toggle="tab" href="#leaves">Leaves/Discrepancies</a>
            </li>
        </ul>
    </div>
    <div class="sidebar-content">
        <div class="tab-content">
            @role(['admin','business_unit_head','front_sales_manager','front_sales_executive','support_manager','support_agent','sales_head'])
            <div class="tab-pane active " id="leads">
                <div class="tab-pane-body">
                    <ul class="list-group list-group-flush leadassignnotify">
                        @foreach(auth()->user()->getLeadsNotifications as $thisleadnotification)
                        <li class="px-0 list-group-item">
                            <a href="{{$thisleadnotification->url}}" class="d-flex">
                                <div class="flex-shrink-0">
                                    <figure class="avatar avatar-info me-3">
                                        <span class="avatar-text rounded-circle">
                                            <i class="bi bi-person"></i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-bold d-flex justify-content-between">
                                        {{$thisleadnotification->message}}
                                    </p>
                                    <span class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> {{time_elapsed_string($thisleadnotification->created_at)}}
                                    </span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane-footer">
                </div>
            </div>
            <div class="tab-pane " id="opportunity">
                <div class="tab-pane-body">
                    <ul class="list-group list-group-flush opportunityassignnotify">
                        @foreach(auth()->user()->getOpportunityNotifications as $thisopportunitynotification)
                        @php
                        $unserializedata = unserialize($thisopportunitynotification->data);
                        @endphp
                        <li class="px-0 list-group-item">
                            <a href="{{$thisopportunitynotification->url}}" class="d-flex">
                                <div class="flex-shrink-0">
                                    <figure class="avatar avatar-info me-3">
                                        <span class="avatar-text rounded-circle">
                                            <i class="bi bi-briefcase"></i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-bold d-flex justify-content-between">
                                        {{$thisopportunitynotification->message}}
                                    </p>
                                    <span class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> {{time_elapsed_string($thisopportunitynotification->created_at)}}
                                    </span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endrole
            @role(['admin','business_unit_head','project_manager','support_manager','support_agent','quality_assurance_depart','production_manager','design_manager','development_manager','content_manager','video_manager','client','sales_head'])
            <div class="tab-pane" id="projects">
                <div class="tab-pane-body">
                    <ul class="list-group list-group-flush">
                        @foreach(auth()->user()->getProjectNotifications as $thisprojnotification)
                        <li class="px-0 list-group-item">
                            <a href="javascript:;" class="d-flex">
                                <div class="flex-shrink-0">
                                    <figure class="avatar avatar-info me-3">
                                        <span class="avatar-text rounded-circle">
                                            <i class="bi bi-person"></i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-bold d-flex justify-content-between">
                                        {{$thisprojnotification->message}}
                                    </p>
                                    <span class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> {{time_elapsed_string($thisprojnotification->created_at)}}
                                    </span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane-footer">
                </div>
            </div>
            @endrole
            @role(['admin','business_unit_head','project_manager','support_manager','front_sales_manager','human_resource_manager','sales_head','human_resource_executive','production_manager'])
            <div class="tab-pane" id="attendance">
                <div class="tab-pane-body">
                    <ul class="list-group list-group-flush attendancenotify">
                        @foreach(auth()->user()->getAttendanceNotification as $thisprojnotification)
                        <?php
                        $data = unserialize($thisprojnotification->data);
                        ?>
                        <li class="px-0 list-group-item">
                            <a href="{{route('attendance.userAttendance',['id'=>$data['userid'],'month'=>sprintf("%02d", $data['month']),'year'=>$data['year']])}}" class="d-flex">
                                <div class="flex-shrink-0">
                                    <figure class="avatar avatar-info me-3">
                                        <span class="avatar-text rounded-circle">
                                            <i class="bi bi-person"></i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-bold d-flex justify-content-between">
                                        {{$thisprojnotification->message}}
                                    </p>
                                    <span class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> {{time_elapsed_string($thisprojnotification->created_at)}}
                                    </span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane-footer">
                </div>
            </div>
            @endrole
            <div class="tab-pane" id="leaves">
                <div class="tab-pane-body">
                    <ul class="list-group list-group-flush leavesnotify">
                        @foreach(auth()->user()->leavesAndDiscrepanciesNotifications()->take(10)->get() as $thisleavenotification)
                        <li class="px-0 list-group-item">
                            <a href="{{$thisleavenotification->url}}" class="d-flex">
                                <div class="flex-shrink-0">
                                    <figure class="avatar avatar-info me-3">
                                        <span class="avatar-text rounded-circle">
                                            <i class="bi bi-person"></i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-bold d-flex justify-content-between">
                                        {{$thisleavenotification->message}}
                                    </p>
                                    <span class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> {{time_elapsed_string($thisleavenotification->created_at)}}
                                    </span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./ notifications sidebar -->

<!-- settings sidebar -->
<div class="sidebar" id="settings">
    <div class="sidebar-header">
        <div>
            <i class="bi bi-gear me-2"></i>
            Settings
        </div>
        <button data-sidebar-close>
            <i class="bi bi-arrow-right"></i>
        </button>
    </div>
    <div class="sidebar-content">
        <ul class="list-group list-group-flush">
            <li class="list-group-item px-0 border-0">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked>
                    <label class="form-check-label" for="flexCheckDefault1">
                        Remember next visits
                    </label>
                </div>
            </li>
            <li class="list-group-item px-0 border-0">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" checked>
                    <label class="form-check-label" for="flexCheckDefault2">
                        Enable report generation.
                    </label>
                </div>
            </li>
            <li class="list-group-item px-0 border-0">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3" checked>
                    <label class="form-check-label" for="flexCheckDefault3">
                        Allow notifications.
                    </label>
                </div>
            </li>
            <li class="list-group-item px-0 border-0">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                    <label class="form-check-label" for="flexCheckDefault4">
                        Hide user requests
                    </label>
                </div>
            </li>
            <li class="list-group-item px-0 border-0">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5" checked>
                    <label class="form-check-label" for="flexCheckDefault5">
                        Speed up demands
                    </label>
                </div>
            </li>
            <li class="list-group-item px-0 border-0">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Hide menus
                    </label>
                </div>
            </li>
        </ul>
    </div>
    <div class="sidebar-action">
        <a href="#" class="btn btn-primary">All Settings</a>
    </div>
</div>
<!-- ./ settings sidebar -->

<!-- search sidebar -->
<div class="sidebar" id="search">
    <div class="sidebar-header">
        Search
        <button data-sidebar-close>
            <i class="bi bi-arrow-right"></i>
        </button>
    </div>
    <div class="sidebar-content">
        <form class="mb-4">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" aria-describedby="button-search-addon">
                <button class="btn btn-outline-light" type="button" id="button-search-addon">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        <h6 class="mb-3">Last searched</h6>
        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <a href="#" class="avatar avatar-sm me-3">
                    <span class="avatar-text rounded-circle">
                        <i class="bi bi-search"></i>
                    </span>
                </a>
                <a href="#" class="flex-fill">Reports for 2021</a>
                <a href="#" class="btn text-danger btn-sm" data-bs-toggle="tooltip" title="Remove">
                    <i class="bi bi-x"></i>
                </a>
            </div>
            <div class="d-flex align-items-center mb-3">
                <a href="#" class="avatar avatar-sm me-3">
                    <span class="avatar-text rounded-circle">
                        <i class="bi bi-search"></i>
                    </span>
                </a>
                <a href="#" class="flex-fill">Current users</a>
                <a href="#" class="btn" data-bs-toggle="tooltip" title="Remove">
                    <i class="bi bi-x"></i>
                </a>
            </div>
            <div class="d-flex align-items-center mb-3">
                <a href="#" class="avatar avatar-sm me-3">
                    <span class="avatar-text rounded-circle">
                        <i class="bi bi-search"></i>
                    </span>
                </a>
                <a href="#" class="flex-fill">Meeting notes</a>
                <a href="#" class="btn" data-bs-toggle="tooltip" title="Remove">
                    <i class="bi bi-x"></i>
                </a>
            </div>
        </div>
        <h6 class="mb-3">Recently viewed</h6>
        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <a href="#" class="avatar avatar-secondary avatar-sm me-3">
                    <span class="avatar-text rounded-circle">
                        <i class="bi bi-check-circle"></i>
                    </span>
                </a>
                <a href="#" class="flex-fill">Todo list</a>
                <a href="#" class="btn" data-bs-toggle="tooltip" title="Remove">
                    <i class="bi bi-x"></i>
                </a>
            </div>
            <div class="d-flex align-items-center mb-3">
                <a href="#" class="avatar avatar-warning avatar-sm me-3">
                    <span class="avatar-text rounded-circle">
                        <i class="bi bi-wallet2"></i>
                    </span>
                </a>
                <a href="#" class="flex-fill">Pricing table</a>
                <a href="#" class="btn" data-bs-toggle="tooltip" title="Remove">
                    <i class="bi bi-x"></i>
                </a>
            </div>
            <div class="d-flex align-items-center mb-3">
                <a href="#" class="avatar avatar-info avatar-sm me-3">
                    <span class="avatar-text rounded-circle">
                        <i class="bi bi-gear"></i>
                    </span>
                </a>
                <a href="#" class="flex-fill">Settings</a>
                <a href="#" class="btn" data-bs-toggle="tooltip" title="Remove">
                    <i class="bi bi-x"></i>
                </a>
            </div>
            <div class="d-flex align-items-center mb-3">
                <a href="#" class="avatar avatar-success avatar-sm me-3">
                    <span class="avatar-text rounded-circle">
                        <i class="bi bi-person-circle"></i>
                    </span>
                </a>
                <a href="#" class="flex-fill">Users</a>
                <a href="#" class="btn" data-bs-toggle="tooltip" title="Remove">
                    <i class="bi bi-x"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-action">
        <a href="#" class="btn btn-danger">All Clear</a>
    </div>
</div>
<!-- ./ search sidebar -->

<!-- ./ sidebars -->

<!-- menu -->
<div class="menu">
    <div class="menu-header">
        <a href="{{route('adminDashboard')}}" class="menu-header-logo">
            <img src="{{asset('images/logo.png')}}" alt="logo">
        </a>
        <a href="{{route('adminDashboard')}}" class="btn btn-sm menu-close-btn">
            <i class="bi bi-x"></i>
        </a>
    </div>
    <div class="menu-body">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                <div class="avatar me-3">
                    <img src="{{asset('images/'.Auth::user()->image)}}" class="rounded-circle" alt="image">
                </div>
                <div>
                    <div class="fw-bold">{{Auth::user()->name}}</div>
                    <small class="text-muted">{{Auth::user()->getMeta('designation')}}</small>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a href="{{route('profile.myProfile')}}" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-person dropdown-item-icon"></i> Profile
                </a>
                <!-- <a href="#" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-envelope dropdown-item-icon"></i> Inbox
                </a> -->
                <!-- <a href="#" class="dropdown-item d-flex align-items-center" data-sidebar-target="#settings">
                    <i class="bi bi-gear dropdown-item-icon"></i> Settings
                </a> -->

                <a class="log-out-btn dropdown-item d-flex align-items-center text-danger" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i class="bi bi-box-arrow-right dropdown-item-icon"></i> Logout </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
        @include('layouts.sidebar')
    </div>
</div>
<div class="layout-wrapper">

    <!-- header -->
    <div class="header">
        <div class="menu-toggle-btn"> <!-- Menu close button for mobile devices -->
            <a href="#">
                <i class="bi bi-list"></i>
            </a>
        </div>
        <!-- Logo -->
        <a href="{{route('adminDashboard')}}" class="logo">
            <img width="100" src="{{asset('images/logo.png')}}" alt="logo">
        </a>
        <!-- ./ Logo -->
        <form class="search-form">
            <div class="input-group form-floating">
                <button class="btn btn-outline-light" type="button" id="button-addon1">
                    <i class="bi bi-search"></i>
                </button>
                <input type="text" class="form-control" id="floatingInputInvalid" placeholder=" " aria-label="Example text with button addon" aria-describedby="button-addon1">
                <label style="left: 30px; for="floatingInputInvalid">Search</label>
                <a href="#" class="btn btn-outline-light close-header-search-bar">
                    <i class="bi bi-x"></i>
                </a>
            </div>
        </form>
        <!--  -->
        <div class="header-bar ms-auto">
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-notify" data-count="0" data-sidebar-target="#notifications">
                        <i class="bi bi-bell icon-lg"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Header mobile buttons -->
        <div class="header-mobile-buttons">
            <a href="#" class="search-bar-btn">
                <i class="bi bi-search"></i>
            </a>
            <a href="#" class="actions-btn">
                <i class="bi bi-three-dots"></i>
            </a>
        </div>
        <!-- ./ Header mobile buttons -->
    </div>
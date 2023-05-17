@extends('layouts.app')

@section('content')


<div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col-lg-3 col-md-12">
        <div class="card h-100">
            <div class="card-body icon-color-top">
                <div class="d-flex mb-3">
                    <div class="display-7">
                        <i class="bi bi-telephone-inbound"></i>
                        <!-- <i class="bi bi-basket"></i> -->
                    </div>
                    <div class="dropdown ms-auto">
                        <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">View Detail</a>
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                </div>
                <h4 class="mb-3">Total Leads</h4>
                <div class="d-flex mb-3">
                    <div class="display-7">{{$totalead}}</div>
                    <div class="ms-auto" id="total-orders"></div>
                </div>
                <div class="text-success">
                    Over last month 1.4% <i class="small bi bi-arrow-up"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12">
        <div class="card h-100">
            <div class="card-body icon-color-top">
                <div class="d-flex mb-3">
                    <div class="display-7">
                        <i class="bi bi-briefcase"></i>
                        <!-- <i class="bi bi-credit-card-2-front"></i> -->
                    </div>
                    <div class="dropdown ms-auto">
                        <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">View Detail</a>
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                </div>
                <h4 class="mb-3">Total Opportunities</h4>
                <div class="d-flex mb-3">
                    <div class="display-7">{{$totalopportunity}}</div>
                    <div class="ms-auto" id="total-opportunity"></div>
                </div>
                <div class="text-warning">
                    Over last month 2.4% <i class="small bi bi-arrow-down"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12">
        <div class="card h-100">
            <div class="card-body icon-color-top">
                <div class="d-flex mb-3">
                    <div class="display-7">
                        <i class="bi bi-box"></i>
                        <!-- <i class="bi bi-credit-card-2-front"></i> -->
                    </div>
                    <div class="dropdown ms-auto">
                        <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">View Detail</a>
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                </div>
                <h4 class="mb-3">Total Packages</h4>
                <div class="d-flex mb-3">
                    <div class="display-7">{{$totalpackage}}</div>
                    <div class="ms-auto" id="total-opportunity"></div>
                </div>
                <div class="text-danger">
                    Over last month 2.4% <i class="small bi bi-arrow-down"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12">
        <div class="card h-100">
            <div class="card-body icon-color-top">
                <div class="d-flex mb-3">
                    <div class="display-7">
                        <i class="bi bi-building"></i>
                        <!-- <i class="bi bi-credit-card-2-front"></i> -->
                    </div>
                    <div class="dropdown ms-auto">
                        <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">View Detail</a>
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                </div>
                <h4 class="mb-3">Total Brands</h4>
                <div class="d-flex mb-3">
                    <div class="display-7">{{$totalbrand}}</div>
                    <div class="ms-auto" id="total-sales"></div>
                </div>
                <div class="text-secondary">
                    Over last month 2.4% <i class="small bi bi-arrow-down"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-12">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title">
                    Attendance Chart
                    <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip" title="Company's Attendance Chart"></a>
                </h6>
                <div id="attendancechart" style="height: 300px"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-md-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex mb-4 masthead-followup-icon">
                    <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                        <i class="bi bi-clock"></i>
                    </span>
                    <h6 class="card-title px-3">Attendance Report</h6>
                </div>
                <div class="list-group list-group-flush" id="attendancedetails">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        @if($timedin == 0 && $timedout == 0)
                        <form action="{{route('attendance.timeIn')}}" method="POST">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-success">Check In</button>
                        </form>
                        @elseif($timedin == 1 && $timedout == 0)
                        <button type="button" class="btn btn-danger timeout"
                            rel="{{($attendance->timein)+32400}}">Checkout</button>
                        <h5>Your Working Time : <span id="demo"></span></h5>
                        @else
                        <h5>Your Today's Working Hours are <b>{{gmdate('H:i:s',$attendance->totalhours)}}</b></h5>
                        @endif
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex flex-grow-1 align-items-center">
                            <!-- <img width="45" class="me-3" src="{{asset('flags/venezuela.svg')}}" alt="..."> -->
                            <span>Leaves:</span>
                        </div>
                        <span>{{$myleaves}}/{{$totalleaves}}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex flex-grow-1 align-items-center">
                            <!-- <img width="45" class="me-3" src="{{asset('flags/salvador.svg')}}" alt="..."> -->
                            <span>Discrepancies:</span>
                        </div>
                        <span>0</span>
                    </div>

                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex flex-grow-1 align-items-center">
                            <!-- <img width="45" class="me-3" src="{{asset('flags/russia.svg')}}" alt="..."> -->
                            <span>Shift Timings:</span>
                        </div>
                        <span>{{auth()->user()->getMeta('shift_name')}}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex flex-grow-1 align-items-center">
                            <!-- <img width="45" class="me-3" src="{{asset('flags/russia.svg')}}" alt="..."> -->
                            <span>Joining Date:</span>
                        </div>
                        <span>{{date('d-M-Y',strtotime(auth()->user()->getMeta('joining')))}}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex flex-grow-1 align-items-center">
                            <!-- <img width="45" class="me-3" src="{{asset('flags/russia.svg')}}" alt="..."> -->
                            <span>Employment Status:</span>
                        </div>
                        <span>{{auth()->user()->getMeta('employment_status')}}</span>
                    </div>
                    @if(auth()->user()->getFleet->count() > 0)
                    @if(auth()->user()->hasMeta('drivinglicence_front'))
                    @else
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex flex-grow-1 align-items-center">
                            <!-- <img width="45" class="me-3" src="{{asset('flags/russia.svg')}}" alt="..."> -->
                            <span>Driving Licence:</span>
                        </div>
                        <a href="{{route('profile.myProfile')}}"><span class="blink">Please Upload Driving Licence</span></a>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-12">
        <div class="card widget h-100">
            <div class="card-header d-flex">
                <h6 class="card-title">
                    Sales Chart
                    <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip"
                        title="Daily orders and sales"></a>
                </h6>
                <div class="d-flex gap-3 align-items-center ms-auto">
                    <div class="dropdown">
                        <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">View Detail</a>
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-md-flex align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div class="display-7 me-3">
                            <i class="bi bi-bag-check me-2 text-success"></i> $10,450
                        </div>
                        <span class="text-success">
                            <i class="bi bi-arrow-up me-1 small"></i>8.30%
                        </span>
                    </div>
                    <div class="d-flex gap-4 align-items-center ms-auto mt-3 mt-lg-0">
                        <select class="form-select">
                            <optgroup label="2020">
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </optgroup>
                            <optgroup label="2021">
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May" selected>May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div id="sales-chart"></div>
                <div class="d-flex justify-content-center gap-4 align-items-center ms-auto mt-3 mt-lg-0">
                    <div>
                        <i class="bi bi-circle-fill mr-2 text-primary me-1 small"></i>
                        <span>Sales</span>
                    </div>
                    <div>
                        <i class="bi bi-circle-fill mr-2 text-success me-1 small"></i>
                        <span>Order</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-md-12">
        <div class="card widget h-100">
            <div class="card-header d-flex">
                <h6 class="card-title">
                    Channels
                    <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip"
                        title="Channels where your products are sold"></a>
                </h6>
                <div class="d-flex gap-3 align-items-center ms-auto">
                    <div class="dropdown">
                        <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">View Detail</a>
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="sales-channels"></div>
                <div class="row text-center mb-5 mt-4">
                    <div class="col-3">
                        <div class="display-7">48%</div>
                        <div class="text-success my-2 small">
                            <i class="bi bi-arrow-up me-1 small"></i>30.50%
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-circle-fill text-orange me-2 small"></i>
                            <span class="text-muted">Social Media</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="display-7">80%</div>
                        <div class="text-success my-2 small">
                            <i class="bi bi-arrow-up me-1 small"></i>50.50%
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-circle-fill text-orange me-2 small"></i>
                            <span class="text-muted">PPC</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="display-7">30%</div>
                        <div class="text-danger my-2 small">
                            <i class="bi bi-arrow-down me-1 small"></i>15.20%
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-circle-fill text-cyan me-2 small"></i>
                            <span class="text-muted">Google</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="display-7">22%</div>
                        <div class="text-success my-2 small">
                            <i class="bi bi-arrow-up me-1 small"></i>1.80%
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-circle-fill text-indigo me-2 small"></i>
                            <span class="text-muted">Email</span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-outline-primary btn-icon">
                        <i class="bi bi-download"></i> Download Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex mb-4">
                    <h6 class="card-title mb-0">Customer Rating</h6>
                    <div class="dropdown ms-auto">
                        <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">View Detail</a>
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="display-6">3.0</div>
                    <div class="d-flex justify-content-center gap-3 my-3">
                        <i class="bi bi-star-fill icon-lg text-warning"></i>
                        <i class="bi bi-star-fill icon-lg text-warning"></i>
                        <i class="bi bi-star-fill icon-lg text-warning"></i>
                        <i class="bi bi-star-fill icon-lg text-muted"></i>
                        <i class="bi bi-star-fill icon-lg text-muted"></i>
                        <span>(318)</span>
                    </div>
                </div>
                <div class="text-muted d-flex align-items-center justify-content-center">
                    <span class="text-success me-3 d-block">
                        <i class="bi bi-arrow-up me-1 small"></i>+35
                    </span> Point from last month
                </div>
                <div class="row my-4">
                    <div class="col-md-6 m-auto">
                        <div id="customer-rating"></div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-outline-primary btn-icon">
                        <i class="bi bi-download"></i> Download Report
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 bg-zenith-yellow">
            <div class="card-body text-center">
                <div class="text-white-50">
                    <div class="bi bi-box-seam display-6 mb-3"></div>
                    <div class="display-8 mb-2">Total Sales</div>
                    <h5>89 Packages Sold</h5>
                </div>
                <div id="products-sold"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card widget h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Online Users
                    <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip" title="All users, including offline users."></a>
                </h5>
                <a href="{{route('users.allUsers')}}">View All</a>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush p-4" style="overflow-y: scroll;height: 300px;">
                    @foreach($users as $thisuser)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="list-group list-group-flush">
                                <div
                                    class="avatar me-1  @if(isset($thisuser->latestattendance) && $thisuser->latestattendance->timeout == NULL) avatar-state-success @else avatar-state-light @endif">
                                    <a href="{{route('users.editUser',$thisuser->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisuser->name}}">
                                        <img src="{{asset('images/'.$thisuser->image)}}" class="rounded-circle" alt="avatar"></a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-bold">{{$thisuser->name}}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-5 col-md-12">
                <div class="card widget">
                    <div class="card-header">
                        <h5 class="card-title">Activity Overview</h5>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <div class="display-5">
                                        <i class="bi bi-truck text-secondary"></i>
                                    </div>
                                    <h5 class="my-3">Delivered</h5>
                                    <div class="text-muted">15 New Packages</div>
                                    <div class="progress mt-3" style="height: 5px">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <div class="display-5">
                                        <i class="bi bi-receipt text-warning"></i>
                                    </div>
                                    <h5 class="my-3">Ordered</h5>
                                    <div class="text-muted">72 New Items</div>
                                    <div class="progress mt-3" style="height: 5px">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 67%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <div class="display-5">
                                        <i class="bi bi-bar-chart text-info"></i>
                                    </div>
                                    <h5 class="my-3">Reported</h5>
                                    <div class="text-muted">50 Support New Cases</div>
                                    <div class="progress mt-3" style="height: 5px">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <div class="display-5">
                                        <i class="bi bi-cursor text-success"></i>
                                    </div>
                                    <h5 class="my-3">Arrived</h5>
                                    <div class="text-muted">34 Upgraded Boxed</div>
                                    <div class="progress mt-3" style="height: 5px">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 55%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

    <div class="col-lg-6 col-md-12">
        @can('view leads')
        <div class="card widget">
            <div class="card-header d-flex align-items-center justify-content-between icon-color">
                <h5 class="card-title"><span class="nav-link-icon">
                        <i class="bi bi-telephone-inbound"></i>
                    </span>Recent Leads </h5>
                <div class="dropdown ms-auto">
                    <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm btn-floating" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">Action</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item">Something else here</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <p class="text-muted">Brands added today. Click <a href="{{route('lead.allLeads')}}">here</a> for more
                    details</p>
                <div class="table-responsive">
                    <table class="table table-custom mb-0" id="recent-leads">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <!-- <th class="text-end">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $thislead)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <!-- <td><a href="{{route('brands.theBrandDesc',$thislead->id)}}">{{$thislead->name}}</a></td> -->
                                <td>{{$thislead->name}}</td>
                                <td>
                                    <a href="{{route('brands.theBrandDesc',$thislead->brand_id)}}" class="avatar"
                                        data-bs-toggle="tooltip" title=""
                                        data-bs-original-title="{{$thislead->getBrand->name}}">
                                        <img src="{{asset('images/'.$thislead->getBrand->image)}}" class="rounded w-auto" alt="image">
                                    </a>
                                </td>
                                <td>{{$thislead->brand}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endcan
    </div>

    <div class="col-lg-6 col-md-12">
        @can('view opportunities')
        <div class="card widget">
            <div class="card-header d-flex align-items-center justify-content-between icon-color">
                <h5 class="card-title"><span class="nav-link-icon">
                        <i class="bi bi-briefcase"></i>
                    </span>Recent Opportunities </h5>
                <div class="dropdown ms-auto">
                    <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm btn-floating" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">Action</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item">Something else here</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <p class="text-muted">Opportunities added today. Click <a
                        href="{{route('opportunity.allOpportunities')}}">here</a> for more details</p>
                <div class="table-responsive">
                    <table class="table table-custom mb-0" id="recent-opportunity">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Package</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($opportunities as $thisopportunities)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$thisopportunities->name}}</td>
                                <td>
                                    <a href="javascript:;" class="avatar" data-bs-toggle="tooltip" title=""
                                        data-bs-original-title="{{$thisopportunities->getBrand->name}}">
                                        <img src="{{asset('images/'.$thisopportunities->getBrand->image)}}" class="rounded" alt="image">
                                    </a>
                                </td>
                                <td>{{$thisopportunities->getpackage->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection
@push('scripts')
@if($attendance == NULL)
@else
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("{{date('M d,y H:i:s',($attendance->timein))}}").getTime();

    // Update the count down every 1 second
    var x = setInterval(function () {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = now - countDownDate;
        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);
    
    
</script>
@endif
<script>

    const body_styles = window.getComputedStyle(document.body);
const colors = {
        primary: $.trim(body_styles.getPropertyValue('--bs-primary')),
        secondary: $.trim(body_styles.getPropertyValue('--bs-secondary')),
        info: $.trim(body_styles.getPropertyValue('--bs-info')),
        success: $.trim(body_styles.getPropertyValue('--bs-success')),
        danger: $.trim(body_styles.getPropertyValue('--bs-danger')),
        warning: $.trim(body_styles.getPropertyValue('--bs-warning')),
        light: $.trim(body_styles.getPropertyValue('--bs-light')),
        dark: $.trim(body_styles.getPropertyValue('--bs-dark')),
        blue: $.trim(body_styles.getPropertyValue('--bs-blue')),
        indigo: $.trim(body_styles.getPropertyValue('--bs-indigo')),
        purple: $.trim(body_styles.getPropertyValue('--bs-purple')),
        pink: $.trim(body_styles.getPropertyValue('--bs-pink')),
        red: $.trim(body_styles.getPropertyValue('--bs-red')),
        orange: $.trim(body_styles.getPropertyValue('--bs-orange')),
        yellow: $.trim(body_styles.getPropertyValue('--bs-yellow')),
        green: $.trim(body_styles.getPropertyValue('--bs-green')),
        teal: $.trim(body_styles.getPropertyValue('--bs-teal')),
        cyan: $.trim(body_styles.getPropertyValue('--bs-cyan')),
        chartTextColor: $('body').hasClass('dark') ? '#6c6c6c' : '#b8b8b8',
        chartBorderColor: $('body').hasClass('dark') ? '#444444' : '#ededed',
    };
    function apex_chart_demo_6(){
        let options = {
            series: [{{$presentusers}}, {{$absentusers}}],
            chart: {
                width: '70%',
                type: 'pie',
                foreColor: colors.chartTextColor,
            },
            stroke: {
                show: false,
                width: 0
            },
            colors: [colors.success, colors.danger],
            labels: ['Present ({{$presentusers}})', 'Absent ({{$absentusers}})'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        new ApexCharts(document.querySelector("#attendancechart"), options).render();
    }

    apex_chart_demo_6();
</script>
@endpush
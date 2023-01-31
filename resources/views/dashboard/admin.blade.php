@extends('layouts.app')

@section('content')
<div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col-lg-3 col-md-12">
                <div class="card h-100">
                    <div class="card-body">
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
                    <div class="card-body">
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
                    <div class="card-body">
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
                    <div class="card-body">
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
                        <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip"
                        title="Your Attendance"></a>
                    </h6>
                        <div id="apex_chart_demo_6" style="height: 300px"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <h6 class="card-title mb-0">Attendance Report</h6>
                            
                        </div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            @if($timedin == 0 && $timedout == 0)
                            <form action="{{route('attendance.timeIn')}}" method="POST">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-success">Check In</button>
                            </form>
                            @elseif($timedin == 1 && $timedout == 0)
                            <form action="{{route('attendance.timeOut')}}" method="POST">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-danger"><p id="demo"></p></button>
                            </form>
                            @else
                            <span>Your Today's Working Hours are {{date('H:i:s',$attendance->totalhours)}}</span>
                            @endif
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <img width="45" class="me-3" src="{{asset('flags/venezuela.svg')}}" alt="...">
                                    <span>Venezuela</span>
                                </div>
                                <span>$1.064,75</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <img width="45" class="me-3" src="{{asset('flags/salvador.svg')}}" alt="...">
                                    <span>Salvador</span>
                                </div>
                                <span>$1.055,98</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <img width="45" class="me-3" src="{{asset('flags/russia.svg')}}" alt="...">
                                    <span>Russia</span>
                                </div>
                                <span>$1.042,00</span>
                            </div>
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
                                    <i class="bi bi-bag-check me-2 text-success"></i> $10.552,40
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
            
            <!-- <div class="col-lg-4 col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <h6 class="card-title">Recent Reviews</h6>
                            <div class="dropdown ms-auto">
                                <a href="#">View All</a>
                            </div>
                        </div>
                        <div class="summary-cards">
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-3">
                                        <img src="{{asset('images/user/women_avatar5.jpg')}}" class="rounded-circle"
                                            alt="image">
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Amara Keel</h5>
                                        <ul class="list-inline ms-auto mb-0">
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-muted"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">(4)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>I love your products. It is very easy and fun to use this panel.</div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-3">
                                        <span class="avatar-text bg-indigo rounded-circle">J</span>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Johnath Siddeley</h5>
                                        <ul class="list-inline ms-auto mb-0">
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">(5)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>Very nice glasses. I ordered for my friend.</div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-3">
                                        <span class="avatar-text bg-yellow rounded-circle">D</span>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">David Berks</h5>
                                        <ul class="list-inline ms-auto mb-0">
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </li>
                                            <li class="list-inline-item mb-0">(5)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div>I am very satisfied with this product.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-lg-4 col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <h6 class="card-title mb-0">Customer Rating</h6>
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
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
                <div class="card h-100 bg-purple">
                    <div class="card-body text-center">
                        <div class="text-white-50">
                            <div class="bi bi-box-seam display-6 mb-3"></div>
                            <div class="display-8 mb-2">Products Sold</div>
                            <h5>89 Sold</h5>
                        </div>
                        <div id="products-sold"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card widget h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">
                            Your Top Countries
                            <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip"
                            title="Sales performance revenue based by country"></a>
                        </h5>
                        <a href="#">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <img width="45" class="me-3"
                                        src="{{asset('flags/united-states-of-america.svg')}}" alt="...">
                                    <span>United States</span>
                                </div>
                                <span>$1.671,10</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <img width="45" class="me-3" src="{{asset('flags/venezuela.svg')}}" alt="...">
                                    <span>Venezuela</span>
                                </div>
                                <span>$1.064,75</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <img width="45" class="me-3" src="{{asset('flags/salvador.svg')}}" alt="...">
                                    <span>Salvador</span>
                                </div>
                                <span>$1.055,98</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex flex-grow-1 align-items-center">
                                    <img width="45" class="me-3" src="{{asset('flags/russia.svg')}}" alt="...">
                                    <span>Russia</span>
                                </div>
                                <span>$1.042,00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
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
            </div>
            <div class="col-lg-7 col-md-12">
                <div class="card widget">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title">Recent Brands</h5>
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-sm btn-floating" aria-haspopup="true"
                            aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Action</a>
                                <a href="#" class="dropdown-item">Another action</a>
                                <a href="#" class="dropdown-item">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Brands added today. Click <a href="{{route('brands.allBrands')}}">here</a> for more details</p>
                        <div class="table-responsive">
                            <table class="table table-custom mb-0" id="recent-brands">
                                <thead>
                                <tr>
                                    <th>
                                        <input class="form-check-input select-all" type="checkbox"
                                            data-select-all-target="#recent-brands" id="defaultCheck1">
                                    </th>
                                    <th>ID</th>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Initials</th>
                                    <th>Type</th>
                                    <th>URL</th>
                                    <!-- <th class="text-end">Actions</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($brands as $thisbrand)
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox">
                                    </td>
                                    <td>{{$thisbrand->id}}</td>
                                    <td>
                                        <a href="javascript:;">
                                            <img src="{{asset('images/'.$thisbrand->image)}}" class="rounded" width="40"
                                                alt="...">
                                        </a>
                                    </td>
                                    <td><a href="{{route('brands.theBrandDesc',$thisbrand->id)}}">{{$thisbrand->name}}</a></td>
                                    <td>{{$thisbrand->initials}}</td>
                                    <td>{{$thisbrand->type}}</td>
                                    <td>{{$thisbrand->url}}</td>
                                    <!-- <td>{{$thisbrand->created_at}}</td> -->
                                    <!-- <td class="text-end">
                                        <div class="d-flex">
                                        <div class="dropdown ms-auto">
                                            <a href="#" data-bs-toggle="dropdown"
                                            class="btn btn-floating"
                                            aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="javascript:;" class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#ShowbrandModal" data-bs-id="{{$thisbrand->id}}" data-bs-name="{{$thisbrand->name}}" data-bs-image="{{asset('images/'.$thisbrand->image)}}" data-bs-type="{{$thisbrand->type}}" data-bs-url="{{$thisbrand->url}}" data-bs-initials="{{$thisbrand->initials}}" data-bs-created_at="{{$thisbrand->created_at}}">Show</a>
                                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditbrandModal" data-bs-id="{{$thisbrand->id}}" data-bs-name="{{$thisbrand->name}}" data-bs-image="{{asset('images/'.$thisbrand->image)}}" data-bs-type="{{$thisbrand->type}}" data-bs-url="{{$thisbrand->url}}" data-bs-initials="{{$thisbrand->initials}}" data-bs-oldimagelink="{{$thisbrand->image}}">Edit</a>
                                                <a href="javascript:;" class="dropdown-item deleteBrand" rel="{{$thisbrand->id}}">Delete</a>
                                            </div>
                                        </div>
                                        </div>
                                    </td> -->
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="table-responsive">
                            <table class="table table-custom mb-0" id="recent-products">
                                <thead>
                                <tr>
                                    <th>
                                        <input class="form-check-input select-all" type="checkbox"
                                            data-select-all-target="#recent-products" id="defaultCheck1">
                                    </th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox">
                                    </td>
                                    <td>
                                        <a href="#">
                                            <img src="{{asset('images/products/10.jpg')}}" class="rounded" width="40"
                                                alt="...">
                                        </a>
                                    </td>
                                    <td>Cookie</td>
                                    <td>
                                        <span class="text-danger">Out of Stock</span>
                                    </td>
                                    <td>$10,50</td>
                                    <td class="text-end">
                                        <div class="d-flex">
                                            <div class="dropdown ms-auto">
                                                <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-floating"
                                                aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item">Action</a>
                                                    <a href="#" class="dropdown-item">Another action</a>
                                                    <a href="#" class="dropdown-item">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox">
                                    </td>
                                    <td>
                                        <a href="#">
                                            <img src="{{asset('images/products/7.jpg')}}" class="rounded" width="40"
                                                alt="...">
                                        </a>
                                    </td>
                                    <td>Glass</td>
                                    <td>
                                        <span class="text-success">In Stock</span>
                                    </td>
                                    <td>$70,20</td>
                                    <td class="text-end">
                                        <div class="d-flex">
                                            <div class="dropdown ms-auto">
                                                <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-floating"
                                                aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item">Action</a>
                                                    <a href="#" class="dropdown-item">Another action</a>
                                                    <a href="#" class="dropdown-item">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox">
                                    </td>
                                    <td>
                                        <a href="#">
                                            <img src="{{asset('images/products/8.jpg')}}" class="rounded" width="40"
                                                alt="...">
                                        </a>
                                    </td>
                                    <td>Headphone</td>
                                    <td>
                                        <span class="text-success">In Stock</span>
                                    </td>
                                    <td>$870,50</td>
                                    <td class="text-end">
                                        <div class="d-flex">
                                            <div class="dropdown ms-auto">
                                                <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-floating"
                                                aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item">Action</a>
                                                    <a href="#" class="dropdown-item">Another action</a>
                                                    <a href="#" class="dropdown-item">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox">
                                    </td>
                                    <td>
                                        <a href="#">
                                            <img src="{{asset('images/products/9.jpg')}}" class="rounded" width="40"
                                                alt="...">
                                        </a>
                                    </td>
                                    <td>Perfume</td>
                                    <td>
                                        <span class="text-success">In Stock</span>
                                    </td>
                                    <td>$170,50</td>
                                    <td class="text-end">
                                        <div class="d-flex">
                                            <div class="dropdown ms-auto">
                                                <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-floating"
                                                aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item">Action</a>
                                                    <a href="#" class="dropdown-item">Another action</a>
                                                    <a href="#" class="dropdown-item">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div> -->
                    </div>
                </div>
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
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = now - countDownDate;
console.log(countDownDate);
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
@endpush
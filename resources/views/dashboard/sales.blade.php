@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-8 col-md-12">

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card bg-cyan text-white-90">
                    <div class="card-body d-flex align-items-center">
                        <!-- <a href="{{route('lead.allLeads')}}"></a> -->
                        <i class="bi bi-box-seam display-7 me-3"></i>
                        <div>
                            <h4 class="mb-0">{{$totalleads}}</h4>
                            <span>My Leads</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-purple text-white-90">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-briefcase display-7 me-3"></i>
                        <div>
                            <h4 class="mb-0">{{$totalopportunities}}</h4>
                            <span>My Opportunities</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-teal text-white-90">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-wallet2 display-7 me-3"></i>
                        <div>
                            <h4 class="mb-0">$0</h4>
                            <span>My Sales</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="card-title mb-4">Sales this month</h6>
                <div id="profit"></div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="card-title mb-4">Recent Activities</h6>
                <ul class="list-group list-group-flush">
                    @foreach( Auth::user()->getUserNotifications as $thisnotification )
                    <li class="px-0 list-group-item d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-warning me-3">
                                <span class="avatar-text fw-bold rounded-circle">
                                    <i class="bi bi-file-text"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 d-md-flex">
                            <div class="flex-fill mb-1 mb-lg-0">
                                <p class="mb-1">
                                    {{$thisnotification->message}}
                                </p>
                                <span class="text-muted small">
                                    <i class="bi bi-clock me-1"></i> {{time_elapsed_string($thisnotification->created_at)}}
                                </span>
                            </div>
                                <!--<a href="#">Show</a>-->
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-12">
        <div class="card ">
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
                        <h5> <span id="demo"></span></h5>
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
                        <a href="{{route('profile.myProfile')}}"><span class="blink">Please upload driving licence</span></a>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="card widget ">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Online Users
                    <a href="#" class="bi bi-question-circle ms-1 small" data-bs-toggle="tooltip"
                        title="All users, including offline users."></a>
                </h5>
                <a href="{{route('users.allUsers')}}">View All</a>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush p-4" style="overflow-y: scroll;height: 300px;">
                    @foreach($users as $thisuser)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex flex-grow-1 align-items-center">
                            <div class="list-group list-group-flush">
                                <div class="avatar me-1  @if(isset($thisuser->latestattendance) && $thisuser->latestattendance->timeout == NULL) avatar-state-success @else avatar-state-light @endif">
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
    
        <div class="col-lg-6 col-md-12">
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
                <p class="text-muted">Leads added today. Click <a href="{{route('lead.allLeads')}}">here</a> for more
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
                                        data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thislead->getBrand->name}}">
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
    </div>

    <div class="col-lg-6 col-md-12">
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
                                    <a href="javascript:;" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisopportunities->getBrand->name}}">
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
    </div>
</div>

@endsection


@push('scripts')

<script type="text/javascript">
    $(function () {

        // Dashboard chart colors
        let body_styles = window.getComputedStyle(document.body);
        let colors = {
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

        function profit() {
            if ($('#profit').length) {
                const options = {
                    series: [
                        {
                            name: 'Sales',
                            data: [165, 140, 180, 200, 190, 150, 160, 165, 145, 160, 180, 150]
                        }
                    ],
                    chart: {
                        height: 280,
                        type: 'line',
                        offsetX: -15,
                        width: '103%',
                        foreColor: colors.chartTextColor,
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    theme: {
                        mode: $('body').hasClass('dark') ? 'dark' : 'light',
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: [colors.primary],
                    stroke: {
                        width: 4,
                        curve: 'smooth'
                    },
                    legend: {
                        show: false
                    },
                    markers: {
                        size: 0,
                        hover: {
                            sizeOffset: 6
                        }
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    },
                    tooltip: {
                        y: [
                            {
                                title: {
                                    formatter: function (val) {
                                        return val
                                    }
                                }
                            },
                            {
                                title: {
                                    formatter: function (val) {
                                        return '$' + val
                                    }
                                }
                            },
                            {
                                title: {
                                    formatter: function (val) {
                                        return val;
                                    }
                                }
                            }
                        ]
                    },
                    grid: {
                        borderColor: colors.chartBorderColor,
                    }
                };

                new ApexCharts(document.querySelector("#profit"), options).render();
            }
        }

        profit();

    });
</script>
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
@endpush
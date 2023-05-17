@extends('layouts.app')

@section('content')
            
<div class="row">
        <div class="col-md-8">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card bg-cyan text-white-90">
                            <div class="card-body d-flex align-items-center">
                            <!-- <a href="{{route('lead.allLeads')}}"></a> -->
                        <i class="bi bi-box-seam display-7 me-3"></i>
                                <div>
                                    <h4 class="mb-0">{{$totalLeaves}}</h4>
                                    <span>Pending Leaves</span>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-purple text-white-90">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-heart display-7 me-3"></i>
                            <div>
                                <h4 class="mb-0">{{$totalusers}}</h4>
                                <span>Total Employees</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-teal text-white-90">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-wallet2 display-7 me-3"></i>
                            <div>
                                <h4 class="mb-0">{{$totalFinance}}</h4>
                                <span>Total Finance</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
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
            <div class="card mb-4 mt-4">
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
                                    <a href="#">
                                        <p class="mb-1">
                                            {{$thisnotification->message}}
                                        </p>
                                    </a>
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
            <div class="card mb-4 mt-4">
                <div class="card-body">
                    <h6 class="card-title mb-4">Generate Attendance Reports</h6>
                    <ul class="list-group list-group-flush">
                        <li class="px-0 list-group-item d-flex align-items-center">
                            <div class="flex-grow-1 d-md-flex">
                                <div class="flex-fill mb-1 mb-lg-0">
                                    <div class="d-flex mb-4 masthead-followup-icon">
                                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="">
                                            <i class="bi bi-clock"></i>
                                        </span>
                                        <h6 class="card-title px-3">Company's Attendance</h6>
                                    </div>
                                    <!--<a href="#">-->
                                    <!--    <p class="card-title mb-3">Company's Attendance</p>-->
                                    <!--</a>-->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <select class="form-select select2-example cmpmonth" aria-label="Floating label select example" name="cmpmonth">
                                                <option selected disabled>Month</option>
                                                @for($i=01;$i<=12;$i++) <option value="{{$i}}" >{{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select class="form-select select2-example cmpyear" aria-label="Floating label select example" name="cmpyear">
                                                <option selected disabled>Year</option>
                                                @for($i=2023;$i<=2026;$i++) <option value="{{$i}}">{{$i}}</option>@endfor
                                            </select>
                                        </div>
                                    </div>
                                    <button class="btn btn-success filterattendancecompanycsv">Generate</button>
                                </div>
                            </div>
                        </li>
                        <!--<li class="px-0 list-group-item d-flex align-items-center">
                            <div class="flex-grow-1 d-md-flex">
                                <div class="flex-fill mb-1 mb-lg-0">
                                    <a href="#">
                                        <p class="mb-1">
                                            Perticular User's Attendance
                                        </p>
                                    </a>
                                </div>
                                <select class="form-select userid" name="user">
                                    <option selected disabled>Select User</option>
                                    @foreach($users as $thisuser)
                                    <option value="{{$thisuser->id}}">{{$thisuser->name}}</option>
                                    @endforeach
                                </select>
                                <select class="form-select month" name="month">
                                    <option selected disabled>Month</option>
                                    @for($i=01;$i<=12;$i++) <option value="{{$i}}" >{{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                    @endfor
                                </select>
                                <select class="form-select year" name="year">
                                    <option selected disabled>Year</option>
                                    @for($i=2023;$i<=2026;$i++) <option value="{{$i}}">{{$i}}</option>@endfor
                                </select>
                                <button class="btn btn-success filterattendancecsv">Generate</button>
                            </div>
                        </li>-->
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
                            <button type="button" class="btn btn-danger timeout" rel="{{($attendance->timein)+32400}}">Checkout</button>
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
                                <span>{{$discrepancies}}</span>
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
                                                <img src="{{asset('images/'.$thisuser->image)}}" class="rounded-circle" alt="avatar">
                                            </a>
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
            
    </div>
    
@endsection
@push('scripts')
<script type="text/javascript">
$('.filterattendancecsv').on('click', function(e) {
        e.preventDefault();
        var userid = $('.userid').val();
        var month = $('.month').val();
        var year = $('.year').val();
        var url = "{{ route('attendance.attendanceCSV',['id'=>':userid','month'=>':month','year'=>':year']) }}";
        url = url.replace(':userid', userid);
        url = url.replace(':month', month);
        url = url.replace(':year', year);
        location.href = url;
    })
    $('.filterattendancecompanycsv').on('click', function(e) {
        e.preventDefault();
        var month = $('.cmpmonth').val();
        var year = $('.cmpyear').val();
        var url = "{{ route('attendance.companyattendanceCSV',['month'=>':month','year'=>':year']) }}";
        url = url.replace(':month', month);
        url = url.replace(':year', year);
        location.href = url;
    })
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
var x = setInterval(function() {

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
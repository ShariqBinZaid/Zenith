@extends('layouts.app')

@section('content')
<div class="content ">
        
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('lead.allLeads')}}">
                        <i class="bi bi-globe2 small me-2"></i> User
                    </a>
                </li>
                <li class="breadcrumb-item " aria-current="page">Attendance</li>
                
                <li class="breadcrumb-item active" aria-current="page">{{date('F', mktime(0, 0, 0, $month, 10))}} - {{$year}}</li>
            </ol>
        </nav>
    </div>
    <div class="container d-flex align-items-center justify-content-center h-100 flex-column flex-md-row text-center text-md-start mb-3">
            <div class="avatar avatar-xl me-3">
                <img src="{{asset('images/'.$userdata->image)}}" class="rounded-circle" alt="...">
            </div>
            <div class="my-4 my-md-0">
                <h3 class="mb-1">{{$userdata->name}}</h3>
                <small>{{ucwords(strtolower(str_replace('_',' ',$userdata->roles->pluck('name')[0] ?? '')), '\',. ')}}</small>
            </div>
            <div class="ms-md-auto">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="list-group list-group-flush" id="attendancedetails">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <span>Email:</span>
                                    </div>
                                    <span>{{$userdata->email}}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <span>Phone:</span>
                                    </div>
                                    <span>{{$userdata->phone}}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <span>Joining Date:</span>
                                    </div>
                                    <span>{{date('d-M-Y',strtotime($userdata->getMeta('joining')))}}</span>  
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex flex-grow-1 align-items-center">
                                        <span>Shift:</span>
                                    </div>
                                    <span>{{$userdata->getMeta('shift_name')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <div class="row g-4">
        <div class="card mb-4">
                <div class="card-body">
                    <div class="row row-vertical-border text-center">
                        <div class="col-4 text-warning">
                            <h3>10</h3>
                            <span>{{$year}}'s Used Leaves</span>
                        </div>
                        <div class="col-4 text-info">
                            <h3>2</h3>
                            <span>{{date('F', mktime(0, 0, 0, $month, 10))}}'s Discrepancies</span>
                        </div>
                        <div class="col-4 text-success">
                            <h3>32</h3>
                            <span>{{$year}}'s Remaining Leaves</span>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="card">
                <div class="card-body">
                    <div class="d-md-flex gap-4 align-items-center">
                        <div class="d-none d-md-flex">Sort By</div>
                        <div class="d-md-flex gap-4 align-items-center">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="hidden" value="{{$userdata->id}}" class="userid"/>
                                        <select class="form-select month">
                                            <option selected disabled>Month</option>
                                            @for($i=01;$i<=12;$i++)
                                            <option value="{{$i}}" {{($month == $i) ? "selected" :"none"; }}>{{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select year">
                                            <option selected disabled>Year</option>
                                            @for($i=2023;$i<=2026;$i++)
                                            <option value="{{$i}}" {{($year == $i) ? "selected" :"none"; }}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class=" ms-auto"><button class="btn btn-primary filterattendance">Search</button></div>
                        </div>
                    </div>
                </div>
            </div>
    <div class="table-responsive" id="attendance">
        <table class="table table-custom table-lg mb-0" id="attendance">
            <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Timein</th>
                <th>Timeout</th>
                <th>Working Hours</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
                @foreach($attendance as $thisattendance)
                <tr class="@if($thisattendance['status'] == 'present') table-success @elseif($thisattendance['status'] == 'today') table-dark @elseif($thisattendance['status'] == 'halfday') table-warning @elseif($thisattendance['status'] == 'future' || $thisattendance['status'] == 'beforejoining') table-light @else table-danger @endif">
                    <td>{{$loop->iteration}}</td>
                    <td>{{date('d-M-Y',$thisattendance['date'])}}</td>
                    @if($thisattendance['status'] == 'nohalfday')
                    <td>{{date('h:i:s A',$thisattendance['timein'])}}</td>
                    <td>{{date('h:i:s A',$thisattendance['timeout'])}}</td>
                    <td>{{gmdate('H:i:s',$thisattendance['totalhours'])}}</td>
                    <td><span>Absent</span></td>
                    
                    @elseif($thisattendance['status'] == 'absent')
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td><span>Absent</span></td>
                    @elseif($thisattendance['status'] == 'today')
                    <td>{{date('h:i:s A',$thisattendance['timein'])}}</td>
                    <td>---</td>
                    <td>---</td>
                    <td><span>Today</span></td>
                    @elseif($thisattendance['status'] == 'future')
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td><span></span></td>
                    @elseif($thisattendance['status'] == 'beforejoining')
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td><span>Not Joined</span></td>
                    @elseif($thisattendance['status'] == 'halfday')
                    <td>{{date('h:i:s A',$thisattendance['timein'])}}</td>
                    <td>{{date('h:i:s A',$thisattendance['timeout'])}}</td>
                    <td>{{gmdate('H:i:s',$thisattendance['totalhours'])}}</td>
                    <td><span>Half Day</span></td>
                    @else
                    <td>{{date('h:i:s A',$thisattendance['timein'])}}</td>
                    <td>{{date('h:i:s A',$thisattendance['timeout'])}}</td>
                    <td>{{gmdate('H:i:s',$thisattendance['totalhours'])}}</td>
                    <td><span>Present</span></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
@push('scripts')
<script>
    $('.filterattendance').on('click',function(e){
        e.preventDefault();
        var userid = $('.userid').val();
        var month = $('.month').val();
        var year = $('.year').val();
        var url = "{{ route('attendance.userAttendance',['id'=>':userid','month'=>':month','year'=>':year']) }}";
        url = url.replace(':userid', userid);
        url = url.replace(':month', month);
        url = url.replace(':year', year);
        location.href = url;
    })
</script>
@endpush
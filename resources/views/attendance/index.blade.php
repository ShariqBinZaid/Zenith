@extends('layouts.app')

@section('content')
<div class="content ">
        
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('lead.allLeads')}}">
                        <i class="bi bi-globe2 small me-2"></i> Attendance
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4">
        <div class="col-lg-4 col-md-6 col-sm-12" style="margin:0px auto;">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/'.$userdata->image)}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h6><a href="{{route('users.editUser',$userdata->id)}}">{{$userdata->name}}</a></h6>
                        
                        <h6>{{$userdata->email}}</h6>
                        
                        <h6>{{$userdata->phone}}</h6>
                        <div class="text-muted">{{ucwords(strtolower(str_replace('_',' ',$userdata->roles->pluck('name')[0] ?? '')), '\',. ')}}</div>
                        
                    </div>
                    
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
                <tr class="@if($thisattendance['status'] == 'present') table-success @elseif($thisattendance['status'] == 'today') table-light @else table-danger @endif">
                    <td>{{$loop->iteration}}</td>
                    <td>{{date('d-M-Y',$thisattendance['date'])}}</td>
                    @if($thisattendance['status'] == 'absent')
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td><span>Absent</span></td>
                    @elseif($thisattendance['status'] == 'today')
                    <td>{{date('h:i:s A',$thisattendance['timein'])}}</td>
                    <td>---</td>
                    <td>---</td>
                    <td><span>Today</span></td>
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
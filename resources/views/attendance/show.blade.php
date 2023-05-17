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
                <li class="breadcrumb-item " aria-current="page">Attendance Status</li>

                <li class="breadcrumb-item active" aria-current="page">Todays Attendance</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4">
        <div class="card mb-4">
            <div class="card-body">
                <div id="attendancechart" style="height: 100px"></div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row row-vertical-border text-center">
                    <div class="col-6 text-success">
                        <h3></h3>
                        <span>Approved</span>
                    </div>
                    <div class="col-6 text-warning">
                        <h3></h3>
                        <span>Reject</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="table-responsive" id="attendance">
        <table class="table table-custom table-lg mb-0" id="attendance">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Timein</th>
                    <th>Timeout</th>
                    <th>Working Hours</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($companydiscrepency as $thisdiscrepency)
                    <tr class="@if($thiscompanyleave->final_status == 'pending') table-warning @elseif($thiscompanyleave->final_status == 'rejected') table-danger @else table-success @endif " )>
                        <td>{{$loop->iteration}}</td>
                        <td><a href="{{route('users.editUser',$thisdiscrepency->userid)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisdiscrepency->user->getMeta('designation')}} ({{$thisdiscrepency->user->getDepart->name}})">
                                <img src="{{asset('images/'.$thisdiscrepency->user->image)}}" class="rounded-circle" alt="image"></a></td>
                        <td>{{$thisdiscrepency->user->name}}</td>
                        <td>{{$thisdiscrepency->leavetype->name}}</td>
                        <td>{{date('d-M-Y',$thisdiscrepency->date)}}</td>
                        <td class="text-uppercase showreason" style="cursor: pointer;" id="reason" name="reason" data-bs-toggle="modal" data-bs-target="#ReasonModal" rel="{{$thiscompanyleave->reason}}"><span class="badge bg-success rounded-pill">View Reason</span></td>
                        <td class="text-uppercase"><span class="badge rounded-pill bg-warning text-dark">{{$thiscompanyleave->lead_status}}</span></td>
                        <td class="text-uppercase"><span class="badge rounded-pill bg-dark">{{$thiscompanyleave->hr_status}}</span></td>
                        <td class="text-uppercase"><span class="badge rounded-pill bg-danger">{{$thiscompanyleave->final_status}}</span></td>
                        <td class="text-end">
                            <div class="d-flex">
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" class="dropdown-item approvediscrepency" rel="{{$thiscompanyleave->id}}">Approve</a>
                                        <a href="javascript:;" class="dropdown-item rejectdiscrepency" rel="{{$thiscompanyleave->id}}">Reject</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>

@endsection


@push('scripts')

@endpush
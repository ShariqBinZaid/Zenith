@extends('layouts.app')
<style>
    .disablediscrepency {
        cursor: not-allowed;
        color: #b3b3b3 !important;
    }
</style>
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

                <li class="breadcrumb-item active" aria-current="page">{{date('F', mktime(0, 0, 0, $month, 10))}} -
                    {{$year}}</li>
            </ol>
        </nav>
    </div>
    @can('attendance user filter')
    <div class="row align-items-center">
        <div class="col-md-4 offset-2">
            <select class="form-select select2-example user">
                <option selected disabled>Select User</option>
                @foreach($users as $thisuser)
                <option value="{{$thisuser->id}}" {{($userdata->id == $thisuser->id) ? "selected" :"none";
                    }}>{{$thisuser->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="submit" class="changeuser btn btn-primary" name="submit" value="Filter" />
        </div>
    </div>

    @endcan
    <div class="container d-flex align-items-center justify-content-center h-100 flex-column flex-md-row text-center text-md-start mb-3">
        <div class="avatar avatar-xl me-3">
            <img src="{{asset('images/'.$userdata->image)}}" class="rounded-circle" alt="...">
        </div>
        <div class="my-4 my-md-0">
            <h3 class="mb-1">{{$userdata->name}}</h3>
            <small>{{$userdata->getMeta('designation')}}</small>
        </div>
        <div class="ms-md-auto">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-group list-group-flush" id="attendancedetails">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <b>Email:</b>
                            </div>
                            <a href="mailto:{{$userdata->email}}">
                                <span class="m-2">{{$userdata->email}}</span>
                            </a>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <b>Phone:</b>
                            </div>
                            <a href="tel:{{$userdata->phone}}">
                                <span>{{$userdata->phone}}</span>
                            </a>    
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <b>Joining Date:</b>
                            </div>
                            <span>{{date('d-M-Y',strtotime($userdata->getMeta('joining')))}}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <b>Shift:</b>
                            </div>
                            <span>{{$userdata->getMeta('shift_name')}}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <b>Designation:</b>
                            </div>
                            <span>{{$userdata->getMeta('designation')}}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <b>Job Type:</b>
                            </div>
                            <span>{{$userdata->getMeta('job_type')}}</span>
                        </div>
                        @if($userdata->getDepart == NULL)
                        @else
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <b>Department:</b>
                            </div>
                            <span>{{$userdata->getDepart->name}}</span>
                        </div>
                        @endif
                        @if($userdata->getReportingAuthority == NULL)
                        @else
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <b>Reporting Authority:</b>
                            </div>
                            <span><a href="{{route('users.editUser',$userdata->getReportingAuthority->id)}}">{{$userdata->getReportingAuthority->name}}</a></span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row row-vertical-border text-center">
                    <div class="col-3 text-warning">
                        <h3>{{$annualleaves}}</h3>
                        <span>Annual Leaves left</span>
                    </div>
                    <div class="col-3 text-info">
                        <h3>{{$casualleaves}}</h3>
                        <span>Casual Leaves left</span>
                    </div>
                    <div class="col-3 text-success">
                        <h3>{{$sickleaves}}</h3>
                        <span>Sick Leaves left</span>
                    </div>
                    <div class="col-3 text-success">
                        <h3>RS {{$expecteddeduction}} </h3>
                        <span>Expected Deduction</span>
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
                    <div class="col-md-6">
                        <input type="hidden" value="{{$userdata->id}}" class="userid" />
                        <select class="form-select select2-example month">
                            <option selected disabled>Month</option>
                            @for($i=01;$i<=12;$i++) <option value="{{$i}}" {{($month==$i) ? "selected" :"none"; }}>
                                {{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select select2-example year">
                            <option selected disabled>Year</option>
                            @for($i=2023;$i<=2026;$i++) <option value="{{$i}}" {{($year==$i) ? "selected" :"none"; }}>
                                {{$i}}</option>@endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class=" ms-auto"><button class="btn btn-primary filterattendance">Search</button></div>
                    </div>
                    <div class="col-md-4">
                        <div class=" ms-auto"><button class="btn btn-primary filterattendancecsv">Generate CSV</button>
                        </div>
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
                    <th>Day</th>
                    <th>Date</th>
                    <th>Timein</th>
                    <th>Timeout</th>
                    <th>Working Hours</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendance as $thisattendance)
                <tr class="@if($thisattendance['status'] == 'present' || $thisattendance['status'] == 'weekend' || $thisattendance['status'] == 'holiday' || $thisattendance['status'] == 'workfromhomeapproved') table-success @elseif($thisattendance['status'] == 'today') table-dark @elseif($thisattendance['status'] == 'halfday') table-warning @elseif($thisattendance['status'] == 'future' || $thisattendance['status'] == 'beforejoining') table-light @else table-danger @endif">
                    <td>{{$loop->iteration}}</td>
                    <td>{{date('d-M-Y',$thisattendance['date'])}}</td>
                    <td>{{$thisattendance['day']}}</td>
                    @if($thisattendance['timein'] == '-')
                    <td>---</td>
                    @else
                    <td>{{date('h:i:s A',$thisattendance['timein'])}}</td>
                    @endif
                    @if($thisattendance['timeout'] == '-')
                    <td>---</td>
                    @else
                    <td>{{date('h:i:s A',$thisattendance['timeout'])}}</td>
                    @endif
                    @if($thisattendance['totalhours'] == '-')
                    <td>---</td>
                    @else
                    <td>{{gmdate('H:i:s',$thisattendance['totalhours'])}}</td>
                    @endif
                    <td><span>{{$thisattendance['name']}}</span>@if($thisattendance['status'] == 'forgettotimeout')
                        @else @endif</td>
                    <td>
                        @if($thisattendance['status'] == 'forgettotimeout') @if($thisattendance['num_of_descrepancy'] ==
                        0) @if($thisattendance['disc_allowed'] == 1)
                            <a href="javascript:;" data-bs-original-title="Fill Discrepancy" data-bs-toggle="modal" data-bs-target="#EditDiscrepencyModal" data-date="{{ $thisattendance['date'] }}" class="filldiscrepency"><i style="font-size: 32px;line-height: 18px;" class="bi bi-card-text disable-after-submit"></i></a> @else <a href="javascript:;" class="disablediscrepency" data-bs-toggle="tooltip" data-bs-original-title="Discrepancy Limit Exceed this month"><i style="font-size: 32px;line-height: 18px;" class="bi bi-card-text"></i></a> @endif @else
                            <a href="javascript:;" class="disablediscrepency" data-bs-toggle="tooltip" data-bs-original-title="Discrepancy Status = {{$thisattendance['disc_status']}}"><i style="font-size: 32px;line-height: 18px;" class="bi bi-card-text"></i></a> @endif @else
                        @endif
                        @if($userdata->getMeta('employment_status') == 'Permanent')
                        @if($thisattendance['status'] == 'nohalfday' || $thisattendance['status'] == 'absent')
                        @if($thisattendance['no_of_leaves'] == 0) 
                            <a href="javascript:;" data-bs-original-title="Fill Leave" data-bs-toggle="modal" data-bs-target="#EditLeaveModal" data-date="{{ $thisattendance['date'] }}" class="fillleave"><i style="font-size: 32px;line-height: 18px;" class="bi bi-calendar-plus disable-after-submit"></i></a>
                            <a href="javascript:;" data-bs-original-title="Work From Home" data-bs-toggle="modal" data-bs-target="#EditWorkModal" data-date="{{ $thisattendance['date'] }}" class="workfromhome ps-3"><i style="font-size: 32px;line-height: 18px;" class="bi bi-house-door disable-after-submit"></i></a>@else 
                            <a href="javascript:;" class="disablediscrepency" data-bs-toggle="tooltip" data-bs-original-title="Applied Leave Status = {{$thisattendance['leave_status']}}"><i style="font-size: 32px;line-height: 18px;" class="bi bi-card-text"></i></a> @endif @else
                        @endif
                        @else @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


@push('scripts')


<script>
    $('.filterattendance').on('click', function (e) {
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
    $('.changeuser').on('click', function (e) {
        e.preventDefault();
        var userid = $('.user').val();
        var month = $('.month').val();
        var year = $('.year').val();
        var url = "{{ route('attendance.userAttendance',['id'=>':userid','month'=>':month','year'=>':year']) }}";
        url = url.replace(':userid', userid);
        url = url.replace(':month', month);
        url = url.replace(':year', year);
        location.href = url;
    })
    $('.filterattendancecsv').on('click', function (e) {
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
</script>



<!--Edit-->

<div class="modal fade" id="EditDiscrepencyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <h5 class="modal-title" id="EditDiscrepencyModalLabel">Fill Discrepency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="updatedisform" id="updatedisform" method="POST"
                action="{{route('discrepancy.addDiscrepancy')}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <input type="hidden" name="date" class="form-control date" />
                            <input type="hidden" name="id" class="id" id="id">
                            {{@csrf_field()}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="recipient-name" class="col-form-label">Description:</label>
                            <textarea name="desc" class="desc form-control" placeholder="Description" id="desc" rows="6" cols="50"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary updatetaxsubmit" id="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal fade" id="EditWorkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <h5 class="modal-title" id="EditWorkModalLabel">Work From Home</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="workfromhomeform" id="workfromhome" method="POST" action="{{route('workfromhome.addWorkFromHome')}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <input type="hidden" name="date" class="form-control date" />
                            <input type="hidden" name="id" class="id" id="id">
                            {{@csrf_field()}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="recipient-name" class="col-form-label">Reason:</label>
                            <textarea name="desc" class="desc form-control" placeholder="Reason" id="desc" rows="6" cols="50"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary updateworksubmit" id="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal fade" id="EditLeaveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <h5 class="modal-title" id="EditLeaveModalLabel">Fill Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="updatedisform" id="leaveform" method="POST" action="{{route('leaves.requestLeave')}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <input type="hidden" name="date" class="form-control date" />
                            <input type="hidden" name="half_day" class="form-control " value="NULL" />
                            {{@csrf_field()}}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="recipient-name" class="col-form-label">Leave Type:</label>
                            <select class="form-select select2-example" aria-label="Floating label select example"
                                name="type">
                                <option selected disbaled>--Select Leave Type--</option>
                                @foreach($leavetypes as $thisleavetype)
                                <option value="{{$thisleavetype->id}}">{{$thisleavetype->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="recipient-name" class="col-form-label">Description:</label>
                            <textarea name="desc" class="desc form-control" placeholder="Description" id="desc" rows="6" cols="50"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary updatetaxsubmit" id="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('body').on('click', '.filldiscrepency', function () {
            let date = $(this).data('date');
            $('#updatedisform').find('input[name="date"]').val(date)
        })
        $('body').on('click', '.fillleave', function () {
            let date = $(this).data('date');
            $('#leaveform').find('input[name="date"]').val(date)
        })
        $('body').on('click', '.workfromhome',function () {
            let date = $(this).data('date');
            $('#workfromhome').find('input[name="date"]').val(date)
        })
    })


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#leaveform').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{route('leaves.requestLeaveajax')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response[1] == 'success') {
                    Swal.fire(
                        'Applied!',
                        response[0],
                        'success'
                    )
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    Swal.fire(
                        'Error!',
                        response[0],
                        'error'
                    )
                }
            }
        });
    });
</script>

<!--Edit-->

@endpush
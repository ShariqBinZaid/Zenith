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
                <li class="breadcrumb-item active" aria-current="page">Team's Attendance</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row row-vertical-border text-center">
                    <div class="col-6 text-success">
                        <h3>{{$presentusers}}</h3>
                        <span>Present</span>
                    </div>
                    <div class="col-6 text-warning">
                        <h3>{{$absentusers}}</h3>
                        <span>Absent</span>
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
                    <form class="d-md-flex gap-4 align-items-center" method="GET" action="{{route('attendance.teamAttendance')}}">
                        <div class="row g-3 align-items-center">
                            <div class="col form-floating">
                                <input type="date" class="form-control filterdate" id="floatingInputGrid" name="date" placeholder="Date" aria-label="Date" value="{{date('Y-m-d',$date)}}">
                                <label for="floatingInputGrid">Date</label>
                            </div>
                            <div class="col form-floating">
                                <select class="form-select select2-example" aria-label="Floating label select example" name="status">
                                    <option selected disabled>Select Status</option>
                                    <option value="All" {{ $statussearch == 'All' ? 'selected' : '' }}>All</option>
                                    <option value="Present" {{ $statussearch == 'Present' ? 'selected' : '' }}>Present</option>
                                    <option value="Absent" {{ $statussearch == 'Absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="Gone" {{ $statussearch == 'Gone' ? 'selected' : '' }}>Gone</option>
                                </select>
                            </div>
                        </div>
                        <div class=" ms-auto">
                            <input type="submit" name="submit" value="Filter" class="btn btn-primary ">
                        </div>
                    </form>
                    <form class="d-md-flex gap-4 align-items-center" method="GET" action="{{route('attendance.teamAttendanceCSV')}}">
                        <div class="row g-3 d-none">
                            <div class="col form-floating">
                                <input type="date" class="form-control filterdate" id="floatingInputGrid" name="date"
                                    placeholder="Date" aria-label="Date" value="{{date('Y-m-d',$date)}}">
                                <label for="floatingInputGrid">Date</label>
                            </div>
                            <div class="col form-floating">
                                <select class="form-select select2-example" aria-label="Floating label select example" name="status">
                                    <option selected disabled>Select Status</option>
                                    <option value="All" {{ $statussearch == 'All' ? 'selected' : '' }}>All</option>
                                    <option value="Present" {{ $statussearch == 'Present' ? 'selected' : '' }}>Present</option>
                                    <option value="Absent" {{ $statussearch == 'Absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="Gone" {{ $statussearch == 'Gone' ? 'selected' : '' }}>Gone</option>
                                </select>
                            </div>
                        </div>
                        <div class=" ms-auto">
                            <input type="submit" name="submit" value="Download CSV" class="btn btn-primary ">
                        </div>
                    </form>
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
                    <th>Phone</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Working Hours</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($finalarray as $user)
                <tr class="{{$user['class']}}">
                    <td><a href="{{route('users.editUser',$user['userid'])}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$user['designation']}} ({{$user['department']}})">
                            <img src="{{asset('images/'.$user['image'])}}" class="rounded-circle" alt="image">
                    <td>{{$user['username']}}</td>
                    <td><a href="https://wa.me/+923178897661?text=Hi,%20please%20check%20CRM (Zenithcodes)." data-bs-toggle="tooltip" data-bs-original-title="{{$user['phone']}}" target="_blank"><i style="font-size:25px;" class="bi bi-whatsapp"></i></td>
                    <td>{{$user['timein']}}</td>
                    <td>{{$user['timeout']}}</td>
                    <td>{{$user['workinghours']}}</td>
                    <td>{{$user['status']}}</td>
                    </a></td>
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
        var date = $('.filterdate').val();
        var depart = $('.departments').val();
        var url = "{{ url('attendance/company?date=:date&depart=:depart') }}";
        url = url.replace(':date', date);
        url = url.replace(':depart', depart);
        location.href = url;
    })
</script>

@endpush
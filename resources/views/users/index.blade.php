@extends('layouts.app')

@section('content')
<div class="content ">
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('adminDashboard')}}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>
    </div>
    @can('create users')
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-person me-3"></i>
                        <h6 class="card-title mb-5">Add New User</h6>
                    </div>

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('users.addUser')}}">
                        {{csrf_field()}}

                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInputGrid" name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInputGrid">Name</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('email') }}" name="email" class="form-control" id="floatingInputGrid" placeholder="Email" aria-label="Email">
                                <label for="floatingInputGrid">Email</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('phone') }}" name="phone" class="form-control" id="floatingInputGrid" placeholder="Phone" aria-label="Phone">
                                <label for="floatingInputGrid">Phone</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('emp_id') }}" name="emp_id" class="form-control" id="floatingInputGrid" placeholder="Emp id" aria-label="Employee ID">
                                <label for="floatingInputGrid">Employee ID</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="" name="cnic" class="form-control" id="cnic floatingInputGrid" placeholder="CNIC Number" aria-label="CNIC Number">
                                <label for="floatingInputGrid">CNIC Number Without Dashes</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('designation') }}" name="designation" class="form-control" id="designation floatingInputGrid" placeholder="Designation" aria-label="Designation">
                                <label for="floatingInputGrid">Designation</label>
                            </div>

                            <div class="col form-floating">
                                <input type="text" value="{{ old('salary') }}" name="salary" class="form-control" id="salary floatingInputGrid" placeholder="Salary" aria-label="Salary">
                                <label for="floatingInputGrid">Salary</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{date('m/d/Y',strtotime(old('joining')))}}" class="form-control" id="floatingInputGrid" name="joining" placeholder="Joining" aria-label="Joining">
                                <label for="floatingInputGrid">Date Of Joining (Month-Day-Year)</label>
                            </div>
                            <div class="col">
                                <select class="form-select select2-example" aria-label="Floating label select example" name="unit_id">
                                    <option selected disabled>Select Unit</option>
                                    <option value="0">Centralized</option>
                                    @foreach($units as $thisunit)
                                    <option value="{{$thisunit->id}}">{{$thisunit->name}}( {{$thisunit->getCompany->name}} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-select select2-example" aria-label="Floating label select example" name="shift">
                                    <option selected disabled>Timings</option>
                                    @foreach($allshifts as $thisshift)
                                    <option value="{{$thisshift->id}}">{{$thisshift->name}}( {{$thisshift->timing}} )</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select select2-example" aria-label="Floating label select example" name="gender">
                                    <option selected disabled>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-select select2-example" aria-label="Floating label select example" name="role">
                                    <option selected disabled>Role</option>
                                    @foreach($allRoles as $thisRole)
                                    <option value="{{$thisRole->id}}">{{ucwords(strtolower(str_replace('_',' ',$thisRole->name)), '\',. ')}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select select2-example" aria-label="Floating label select example" name="depart_id">
                                    <option selected disabled>Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-select select2-example" aria-label="Floating label select example" name="reporting_authority">
                                    <option selected disabled>Select Reporting Authority</option>
                                    @foreach($allusers as $thiuser)
                                    <option value="{{$thiuser->id}}">{{$thiuser->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="probation" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Probation Period</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-4 masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-person"></i>
                        </span>
                        <h6 class="card-title px-3">Total {{$charaterstic}} Users</h6>
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$users->total()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <form action="{{ route('users.allUsers') }}" method="GET">
                                    <div class="input-group form-floating" style="border: 0.5px solid #ced4da; border-radius: 9px;">
                                        <input style="background: transparent;" type="text" class="form-control" id="floatingInputInvalid" placeholder="Search" name="search" value="{{ $search ?? '' }}">
                                        <label for="floatingInputInvalid">Search</label>
                                        <button class="btn btn-outline-light" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
                @can('view inactive users')
                <div class="dropdown ms-auto">
                    <a href="#" data-bs-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-haspopup="true" aria-expanded="false">More</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{route('users.allUsers')}}" class="dropdown-item">Active Users</a>
                        <a href="{{route('users.inactiveUsers')}}" class="dropdown-item">In-Active Users</a>
                        <a href="{{route('users.UserCSV')}}" class="dropdown-item">Download CSV</a>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-lg mb-0" id="allUsers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Designations</th>
                    <th>Date Of Joining</th>
                    @can('update users')
                    <th class="text-end">Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($users as $thisuser)
                <tr>
                    <td>
                        <a href="javascript:;">{{$loop->iteration}}</a>
                    </td>
                    <td><a class="image-popup" href="{{asset('images/'.$thisuser->image)}}"><img src="{{asset('images/'.$thisuser->image)}}" height="60px" width="60px" class="showusersimage" /></a></td>
                    <td><a href="{{route('users.editUser',$thisuser->id)}}">{{$thisuser->name}}</a></td>
                    <td>{{$thisuser->email}}</td>
                    <td>{{$thisuser->getMeta('designation')}}</td>
                    <td>{{date('d/M/Y',strtotime($thisuser->getMeta('joining', '')))}}</td>
                    @can('update users')
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('view users attendance')
                                    <a href="{{route('attendance.userAttendance',['id'=>$thisuser->id,'month'=>date('m'),'year'=>date('Y')])}}" class="dropdown-item">Show Attendance</a>
                                    @endcan
                                    @can('view users leaves')
                                    <a href="{{route('leaves.showUserLeaves',$thisuser->id)}}" class="dropdown-item">Show Leaves</a>
                                    @endcan
                                    @if($charaterstic == 'Active')
                                    <a href="{{route('users.editUser',$thisuser->id)}}" class="dropdown-item">Show Profile/Edit Profile</a>
                                    <a href="javascript:;" class="dropdown-item deleteUser" rel="{{$thisuser->id}}">In-Active this User</a>
                                    @else
                                    <a href="javascript:;" class="dropdown-item activeUser" rel="{{$thisuser->id}}">Active this User</a>
                                    @endif
                                    <a href="{{route('users.rolesandpermissions',$thisuser->id)}}" class="dropdown-item">Assign Roles and Permissions to User</a>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav class="mt-4" aria-label="Page navigation example">
        {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>

</div>
@endsection


@push('scripts')

<script>
    $(document).ready(function() {
        $('input[name="joining"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true
        });
    })
</script>


<!-- Delete Roles Ajax Start -->

<script type="text/javascript">
    $(document).on('click', '.deleteRole', function(e) {
        e.preventDefault();
        var id = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure you want to delete this Role?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('admin.deleteRole')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        type: 'deleteRole',
                        id: id
                    },
                    success: function(res) {
                        Swal.fire(
                            'Deleted!',
                            'Role has been deleted successfully!',
                            'success'
                        )
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                })
            }
        })
    })
</script>

<!-- Delete Roles Ajax End -->

<!-- Inactive User Ajax Start -->

<script type="text/javascript">
    $(document).on('click', '.deleteUser', function(e) {
        e.preventDefault();
        var id = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure you want to In-Active this User?',
            text: "You can revert it back!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, inactivate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('users.inactiveUser')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        type: 'inactiveUser',
                        id: id
                    },
                    success: function(res) {
                        Swal.fire(
                            'Deleted!',
                            'User has been inactivated successfully!',
                            'success'
                        )
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                })
            }
        })
    })
</script>

<!-- Inactive User Ajax End -->


<!-- Active User Ajax Start -->

<script type="text/javascript">
    $(document).on('click', '.activeUser', function(e) {
        e.preventDefault();
        var id = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure you want to Active this User?',
            text: "You can revert it back!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, activate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('users.activeUser')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        type: 'activeUser',
                        id: id
                    },
                    success: function(res) {
                        Swal.fire(
                            'Deleted!',
                            'User has been activated successfully!',
                            'success'
                        )
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                })
            }
        })
    })
</script>

<!-- Active User Ajax End -->

@endpush
@extends('layouts.app')

@section('content')
<div class="content ">
        
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('users.allUsers')}}">
                        <i class="bi bi-user small me-2"></i> Users
                    </a>
                </li>
                <li class="breadcrumb-item " aria-current="page">User Profile</li>
                <li class="breadcrumb-item active" aria-current="page">{{$userdata->name}}</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        @can('update users')
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-person me-3"></i>
                        <h6 class="card-title mb-5">Edit {{$userdata->name}}'s Profile</h6>
                    </div>
                    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Change Password</a>
                    </li>
                    </ul>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if ($message = Session::get('errordb'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                    <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        
                        <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('users.updateUser',request()->route('id'))}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="row mb-3">
                                
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="hidden" name="id" value="{{request()->route('id')}}"/>
                                    <input type="text" value="{{$userdata->name}}" class="form-control" id="floatingInputGrid" name="name" placeholder="Name" aria-label="Name">
                                    <label for="floatingInputGrid">Name</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->getMeta('psuedo', '')}}" class="form-control" id="floatingInputGrid" name="psuedo" placeholder="Psuedo" aria-label="Psuedo">
                                    <label for="floatingInputGrid">Psuedo</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->email}}" name="email" class="form-control" id="floatingInputGrid" placeholder="Email" aria-label="Email" disabled>
                                    <label for="floatingInputGrid">Email</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->phone}}" name="phone" class="form-control" id="floatingInputGrid" placeholder="Phone" aria-label="Phone" >
                                    <label for="floatingInputGrid">Phone</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->getMeta('emp_id', '')}}" class="form-control" id="floatingInputGrid" name="emp_id" placeholder="Employee ID" aria-label="Employee ID">
                                    <label for="floatingInputGrid">Employee ID</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->getMeta('father_name', '')}}" class="form-control" id="floatingInputGrid" name="father_name" placeholder="Father Name" aria-label="Father Name">
                                    <label for="floatingInputGrid">Father Name</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{date('m/d/Y',strtotime($userdata->getMeta('dob', '')))}}" class="form-control datetime" id="dob floatingInputGrid" name="dob" placeholder="Date Of Birth" aria-label="Date Of Birth">
                                    <label for="floatingInputGrid">Date Of Birth (Month-Day-Year)</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->getMeta('cnic', '')}}" class="form-control" id="floatingInputGrid" name="cnic" placeholder="CNIC Number" aria-label="CNIC Number">
                                    <label for="floatingInputGrid">CNIC Number</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->getMeta('address', '')}}" class="form-control" id="floatingInputGrid" name="address" placeholder="Address" aria-label="Address">
                                    <label for="floatingInputGrid">Address</label> 
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->getMeta('designation', '')}}" name="designation" class="form-control" id="designation floatingInputGrid" placeholder="Designation" aria-label="Designation">
                                    <label for="floatingInputGrid">Designation</label>
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{$userdata->getMeta('salary', '')}}" name="salary" class="form-control" id="floatingInputGrid" placeholder="Salary" aria-label="Salary">
                                    <label for="floatingInputGrid">Salary</label>
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="text" value="{{date('m/d/Y',strtotime($userdata->getMeta('joining', '')))}}" name="joining" class="form-control datetime" placeholder="Joining" aria-label="Joining">
                                    <label for="floatingInputGrid">Date of Joining (Month-Day-Year)</label>
                                </div>
                                <div class="col-md-6 form-floating">
                                    <input type="file" class="form-control" name="image" id="floatingInputGrid" placeholder="Profile Picture" aria-label="Profile Picture">
                                    <label for="floatingInputGrid">Upload Profile Picture</label>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select select2-example" name="gender">
                                        <option selected disabled>Choose the Gender...</option>
                                        <option value="male"  {{ ($userdata->getMeta('gender', NULL) == 'male')? "selected":""}} >Male</option>
                                        <option value="female" {{($userdata->getMeta('gender', NULL) == 'female')? "selected":""}}>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select select2-example" name="shift">
                                        <option selected disabled>Choose the Shift Timings...</option>
                                        @foreach($allshifts as $thisshift)
                                        <option value="{{$thisshift->id}}" {{($userdata->getMeta('shift', NULL) == $thisshift->id)? "selected":""}}>{{$thisshift->name}}( {{$thisshift->timing}} )</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select select2-example" name="unit_id">
                                        <option selected disabled>Select the Unit..</option>
                                        <option value="0" {{($userdata->unit_id == 0)? "selected":""}}>Centralized</option>
                                        @foreach($units as $thisunit)
                                        <option value="{{$thisunit->id}}" {{($userdata->unit_id == $thisunit->id)? "selected":""}}>{{$thisunit->name}}( {{$thisunit->getCompany->name}} )</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select select2-example" name="role">
                                        <option selected disabled>Select the Role..</option>
                                        @foreach($allRoles as $thisrole)
                                        <option value="{{$thisrole->id}}" {{($thisrole->id == $userdata->roles[0]->id)? "selected":""}}>{{$thisrole->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select select2-example" name="depart_id">
                                        <option selected disabled>Select the Department..</option>
                                        @foreach($departments as $department)
                                        <option value="{{$department->id}}" {{($department->id == $userdata->depart_id)? "selected":""}}>{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select select2-example" name="reporting_authority">
                                        <option selected disabled>Select the Reporting Authority..</option>
                                        @foreach($users as $thisuser)
                                        <option value="{{$thisuser->id}}" @if($userdata->reporting_authority == $thisuser->id) selected @else @endif>{{$thisuser->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-switch form-check">
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Probation Period</label>
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="probation" {{ ($userdata->getMeta('employment_status') == 'Probation')? "checked":""  }}>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    
                        <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('users.changePassword')}}">
                        {{csrf_field()}}
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3 form-floating">
                                    <input type="hidden" name="id" value="{{request()->route('id')}}"/>
                                    <input type="text" class="form-control" id="floatingInputGrid" name="old_password" placeholder="Current Password" aria-label="Current Password">
                                    <label for="floatingInputGrid">Current Password</label>
                                </div>
                                <div class="col-md-6 mb-3 form-floating">
                                    <input type="password" name="new_password" class="form-control" id="floatingPassword" placeholder="New Password" aria-label="New Password">
                                    <label for="floatingPassword">New Password</label>
                                </div>
                                <div class="col-md-6 form-floating">
                                    <input type="password" name="new_password_confirmation" class="form-control" id="floatingPassword" placeholder="Confirm New Password" aria-label="Confirm New Password">
                                    <label for="floatingPassword">Confirm New Password</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-4 masthead-followup-icon text-center">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-person me-3"></i>
                        <h6 class="card-title mb-0">{{$userdata->name}}'s Profile</h6>
                    </div>
                    <div class="text-center">
                     <a class="image-popup" href="{{asset('images/'.$userdata->image)}}">
                        <div class="avatar avatar-xl">
                            <img src="{{asset('images/'.$userdata->image)}}" class="rounded-circle" alt="image">
                        </div>
                     </a>
                    </div>
                    <div class="text-center">
                        <div class="card mt-3" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>Name</b> : {{$userdata->name}}</li>
                                <li class="list-group-item"><b>Email</b> :  <a href="mailto:{{$userdata->email}}">{{$userdata->email}}</a></li>
                                <li class="list-group-item"><b>Designation</b> :  {{$userdata->getMeta('designation')}}</li>
                                <li class="list-group-item"><b>Job Type</b> :  {{$userdata->getMeta('job_type')}}</li>
                                @if($userdata->getReportingAuthority == NULL)@else<li class="list-group-item"><b>Department</b> :  {{$userdata->getDepart->name ?? null}}</li>@endif
                                @if($userdata->getReportingAuthority == NULL)@else<li class="list-group-item"><b>Reporting Authority</b> :  <a href="{{route('users.editUser',$userdata->getReportingAuthority->id)}}">{{$userdata->getReportingAuthority->name}}</a></li>@endif
                                @if($unithead == NULL)@else<li class="list-group-item"><b>Unit Head</b> :  {{$unithead->name}}</li>@endif
                                @can('employee personal details')
                                <li class="list-group-item"><b>CNIC</b> :  {{$userdata->getMeta('cnic', '')}}</li>
                                <li class="list-group-item"><b>Phone</b> :  <a href="tel:{{$userdata->phone}}">{{$userdata->phone}}</a></li>
                                <li class="list-group-item"><b>Employment Status</b> :  {{$userdata->getMeta('employment_status')}}</li>
                                <li class="list-group-item" style="text-transform: capitalize;"><b>Emergency Contact #1</b> :  {{$userdata->getMeta('emergency_name')}} ( {{$userdata->getMeta('emergency_relation')}} ) <a class="progress-bar ps-4 ms-4 me-4 mt-2" href="tel:{{$userdata->getMeta('emergency_number')}}">{{$userdata->getMeta('emergency_number')}}</a></li>
                                <li class="list-group-item" style="text-transform: capitalize;"><b>Emergency Contact #2</b> :  {{$userdata->getMeta('emergency_name_2')}} ( {{$userdata->getMeta('emergency_relation_2')}} ) <a class="progress-bar ps-4 ms-4 me-4 mt-2" href="tel:{{$userdata->getMeta('emergency_number_2')}}">{{$userdata->getMeta('emergency_number_2')}}</a></li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection


    @push('scripts')

        <script>
            $(document).ready(function() {
                $('.datetime').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true
                });
                // $('input[name="joining"]').daterangepicker({
                //     singleDatePicker: true,
                //     showDropdowns: true
                // });
            })
        </script>
 
     @endpush
@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('adminDashboard')}}">
                        <i class="bi bi-gear small me-2"></i> Settings
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">My Profile</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-4">
                            <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-person-lines-fill me-3"></i>
                        <h6 class="card-title mb-3">Edit Your Profile</h6>
                    </div>
                    
                    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Basic Information</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="additional-tab" data-bs-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="true">Additional Information</a>
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

                            <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('profile.editProfile')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="text" value="{{ Auth::user()->name }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                        <label for="floatingInput">Name</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="text" value="{{ Auth::user()->email }}" name="email" id="floatingInput" class="form-control" placeholder="Email" aria-label="Email" disabled>
                                        <label for="floatingInput">Email</label>
                                    </div>
                                    <div class="col-md-6 ">
                                         <label for="floatingInputGrid">Profile Picture</label> 
                                        <input type="file" class="form-control" name="image" placeholder="Profile Picture" aria-label="Profile Picture">
                                    </div>

                                    <div class="col-md-6 mb-3 mt-3 form-floating">
                                        <input type="tel" value="{{Auth::user()->phone}}" name="phone" class="form-control" id="floatingInput" placeholder="Phone" aria-label="Phone">
                                        <label for="floatingInput">Phone</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">

                            <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('profile.additionalData')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="text" value="{{Auth::user()->getMeta('pseudo')}}" class="form-control" id="floatingInputGrid" name="psuedo" placeholder="Psuedo" aria-label="Name">
                                        <label for="floatingInputGrid">Psuedo</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="text" value="{{Auth::user()->getMeta('father_name')}}" name="father_name" class="form-control" id="floatingInput" placeholder="Father's Name" aria-label="Father's Name">
                                        <label for="floatingInput">Father's Name</label>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="gender">
                                            <option selected disabled>Choose the Gender...</option>
                                            <option value="Male" {{ (auth()->user()->getMeta('gender', NULL) == 'Male')? "selected":""}}>Male</option>
                                            <option value="Female" {{(auth()->user()->getMeta('gender', NULL) == 'Female')? "selected":""}}>Female</option>
                                            <option value="Other" {{(auth()->user()->getMeta('gender', NULL) == 'Other')? "selected":""}}>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="tel" value="{{Auth::user()->getMeta('cnic')}}" name="cnic" class="form-control" id="floatingInput" placeholder="CNIC Number" aria-label="CNIC Number">
                                        <label for="floatingInput">CNIC Number</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="tel" value="{{Auth::user()->getMeta('address')}}" name="address" class="form-control" id="floatingInput" placeholder="Address" aria-label="Address">
                                        <label for="floatingInput">Address</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="text" value="{{Auth::user()->getMeta('dob')}}" name="dob" class="form-control datetime" id="floatingInput" placeholder="Date of Birth" aria-label="Date of Birth">
                                        <label for="floatingInput">Date of Birth</label>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="religion">
                                            <option selected disabled>Select Religion..</option>
                                            <option value="Muslim" @if(Auth::user()->getMeta('religion') == 'Muslim') selected @else @endif>Muslim</option>
                                            <option value="Hindu" @if(Auth::user()->getMeta('religion') == 'Hindu') selected @else @endif>Hindu</option>
                                            <option value="Christian" @if(Auth::user()->getMeta('religion') == 'Christian') selected @else @endif>Christian</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="marital">
                                            <option selected disabled>Choose the Marital Status...</option>
                                            <option value="Single" {{ (auth()->user()->getMeta('marital', NULL) == 'Single')? "selected":""}}>Single</option>
                                            <option value="Married" {{(auth()->user()->getMeta('marital', NULL) == 'Married')? "selected":""}}>Married</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="job_type">
                                            <option selected disabled>Select Job Type...</option>
                                            <option value="Remote" {{ (auth()->user()->getMeta('job_type', NULL) == 'Remote')? "selected":""}}>Remote</option>
                                            <option value="Onsite" {{(auth()->user()->getMeta('job_type', NULL) == 'Onsite')? "selected":""}}>Onsite</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="comorbidities">
                                            <option selected disabled>Any Comorbidities...</option>
                                            <option value="Yes" {{ (auth()->user()->getMeta('comorbidities', NULL) == 'Yes')? "selected":""}}>Yes</option>
                                            <option value="No" {{(auth()->user()->getMeta('comorbidities', NULL) == 'No')? "selected":""}}>No</option>
                                        </select>
                                    </div>
                                    <b class="mb-3">Emergency Contact #1</b>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="name" value="{{Auth::user()->getMeta('emergency_name')}}" name="emergency_name" class="form-control" id="floatingInput" placeholder="Contact Name" aria-label="Contact Name">
                                        <label for="floatingInput">Contact Name</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="name" value="{{Auth::user()->getMeta('emergency_number')}}" name="emergency_number" class="form-control" id="floatingInput" placeholder="Contact Number" aria-label="Contact Number">
                                        <label for="floatingInput">Contact Number</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <select class="form-select select2-example" name="emergency_relation">
                                            <option selected disabled>Choose the Relation...</option>
                                            <option value="Father" {{ (auth()->user()->getMeta('emergency_relation', NULL) == 'Father')? "selected":""}}>Father</option>
                                            <option value="Mother" {{(auth()->user()->getMeta('emergency_relation', NULL) == 'Mother')? "selected":""}}>Mother</option>
                                            <option value="Brother" {{(auth()->user()->getMeta('emergency_relation', NULL) == 'Brother')? "selected":""}}>Brother</option>
                                            <option value="Sister" {{(auth()->user()->getMeta('emergency_relation', NULL) == 'Sister')? "selected":""}}>Sister</option>
                                            <option value="Other" {{(auth()->user()->getMeta('emergency_relation', NULL) == 'Other')? "selected":""}}>Other</option>
                                        </select>
                                    </div>
                                    
                                    <b class="mb-3">Emergency Contact #2</b>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="name" value="{{Auth::user()->getMeta('emergency_name_2')}}" name="emergency_name_2" class="form-control" id="floatingInput" placeholder="Contact Name" aria-label="Contact Name">
                                        <label for="floatingInput">Contact Name</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="name" value="{{Auth::user()->getMeta('emergency_number_2')}}" name="emergency_number_2" class="form-control" id="floatingInput" placeholder="Contact Number" aria-label="Contact Number">
                                        <label for="floatingInput">Contact Number</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <select class="form-select select2-example" name="emergency_relation_2">
                                            <option selected disabled>Choose the Relation...</option>
                                            <option value="Father" {{ (auth()->user()->getMeta('emergency_relation_2', NULL) == 'Father')? "selected":""}}>Father</option>
                                            <option value="Mother" {{(auth()->user()->getMeta('emergency_relation_2', NULL) == 'Mother')? "selected":""}}>Mother</option>
                                            <option value="Brother" {{(auth()->user()->getMeta('emergency_relation_2', NULL) == 'Brother')? "selected":""}}>Brother</option>
                                            <option value="Sister" {{(auth()->user()->getMeta('emergency_relation_2', NULL) == 'Sister')? "selected":""}}>Sister</option>
                                            <option value="Other" {{(auth()->user()->getMeta('emergency_relation_2', NULL) == 'Other')? "selected":""}}>Other</option>
                                        </select>
                                    </div>
                                    
                                    <b class="mb-3">Last Education</b>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="text" value="{{Auth::user()->getMeta('degree')}}" name="degree" class="form-control" id="floatingInput" placeholder="Degree" aria-label="Degree">
                                        <label for="floatingInput">Degree</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="name" value="{{Auth::user()->getMeta('institute_name')}}" name="institute_name" class="form-control" id="floatingInput" placeholder="Institute Name" aria-label="Institute Name">
                                        <label for="floatingInput">Institute Name</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="text" value="{{Auth::user()->getMeta('institute_from')}}" name="institute_from" class="form-control datetime" id="floatingInput" placeholder="Institute From" aria-label="Institute Name">
                                        <label for="floatingInput">Institute From</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="text" value="{{Auth::user()->getMeta('institute_to')}}" name="institute_to" class="form-control datetime" id="floatingInput" placeholder="Institute To" aria-label="Institute To">
                                        <label for="floatingInput">Institute To</label>
                                    </div>
                                    
                                    <b class="mb-3">Driving License</b>
                                    <div class="col-md-6 ">
                                         <label for="floatingInputGrid">Upload Driving License (Front)</label> 
                                        <input type="file" class="form-control" name="drvl_front" placeholder="Driving License" aria-label="Driving License">
                                        <a class="btn btn-dark mt-3 d-none" href="{{asset('images/'.$userdata->getMeta('drivinglicence_front'))}}">Download</a>
                                    </div>
                                    <div class="col-md-6 ">
                                         <label for="floatingInputGrid">Upload Driving License (Back)</label> 
                                        <input type="file" class="form-control" name="drvl_back" placeholder="Driving License" aria-label="Driving License">
                                        <a class="btn btn-dark mt-3 d-none" href="{{asset('images/'.$userdata->getMeta('drivinglicence_back'))}}">Download</a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('profile.changePassword')}}">
                                {{csrf_field()}}
                                <div class="row mb-3">
                                    <div class="col-md-12 mb-3 form-floating">
                                        <input type="password" class="form-control" id="floatingInput" name="old_password" placeholder="Current Password" aria-label="Current Password">
                                        <label for="floatingInput">Current Password</label>
                                    </div>
                                    <div class="col-md-6 mb-3 form-floating">
                                        <input type="password" name="new_password" id="floatingInput" class="form-control" placeholder="New Password" aria-label="New Password">
                                        <label for="floatingInput">New Password</label>
                                    </div>
                                    <div class="col-md-6 form-floating">
                                        <input type="password" name="new_password_confirmation" class="form-control" id="floatingInput" placeholder="Confirm New Password" aria-label="Confirm New Password">
                                        <label for="floatingInput">Confirm New Password</label>
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
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-4 masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-person-lines-fill"></i>
                        </span>
                        <h6 class="card-title px-3">My Profile</h6>
                    </div>
                    <div class="text-center">
                        <a class="image-popup" href="{{asset('images/'.Auth::user()->image)}}">
                            <div class="avatar avatar-xl me-3">
                                <img src="{{asset('images/'.Auth::user()->image)}}" class="rounded-circle" alt="image">
                            </div>
                        </a>
                    </div>
                    <div class="text-center">
                        <div class="card mt-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>Name</b> : {{$userdata->name}}</li>
                                <li class="list-group-item"><b>Email</b> : {{$userdata->email}}</li>
                                <li class="list-group-item"><b>Designation</b> : {{$userdata->getMeta('designation')}}</li>
                                <li class="list-group-item"><b>Job Type</b> : {{$userdata->getMeta('job_type')}}</li>
                                @if($userdata->getReportingAuthority == NULL)@else<li class="list-group-item"><b>Reporting Authority</b> :  {{$userdata->getReportingAuthority->name}}</li>@endif
                                @if($unithead == NULL)@else<li class="list-group-item"><b>Unit Head</b> : {{$unithead->name}}</li>@endif

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
            })
        </script>
 
     @endpush
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
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-3">Edit {{$userdata->name}}'s Profile</h6>
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
                                <div class="col-md-6 mb-3">
                                <input type="hidden" name="id" value="{{request()->route('id')}}"/>
                                    <input type="text" value="{{$userdata->name}}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" value="{{$userdata->email}}" name="email" class="form-control" placeholder="Email" aria-label="Email" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" value="{{$userdata->phone}}" name="phone" class="form-control" placeholder="Phone" aria-label="Phone" >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select" name="gender">
                                        <option selected disabled>Choose the Gender...</option>
                                        <option value="male"  {{ ($userdata->getMeta('gender', NULL) == 'male')? "selected":""  }} >Male</option>
                                        <option value="female" {{($userdata->getMeta('gender', NULL) == 'female')? "selected":""}}>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select class="form-select" name="shift">
                                        <option selected disabled>Choose the Shift Timings...</option>
                                        @foreach($allshifts as $thisshift)
                                        <option value="{{$thisshift->id}}" {{($userdata->getMeta('shift', NULL) == $thisshift->id)? "selected":""}}>{{$thisshift->name}}( {{$thisshift->timing}} )</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="date" value="{{$userdata->getMeta('joining', '')}}" name="joining" class="form-control" placeholder="Joining" aria-label="Joining">
                                </div>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="image" placeholder="Profile Picture" aria-label="Profile Picture">
                                </div>
                                <div class="col-md-6  form-switch form-check">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Probation Period</label>
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="probation" {{ ($userdata->getMeta('employment_status') == 'Probation')? "checked":""  }}>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <input type="text" value="{{$userdata->getMeta('salary', '')}}" name="salary" class="form-control" placeholder="Salary" aria-label="Salary">
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
                                <div class="col-md-12 mb-3">
                                    <input type="hidden" name="id" value="{{request()->route('id')}}"/>
                                    <input type="text" class="form-control" name="old_password" placeholder="Current Password" aria-label="Current Password">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="new_password" class="form-control" placeholder="New Password" aria-label="New Password">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password" aria-label="Confirm New Password">
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
                    <div class="mb-4 text-center">
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
                            <li class="list-group-item"><b>Email</b> :  {{$userdata->email}}</li>
                            <li class="list-group-item"><b>Role</b> :  {{ucwords(strtolower(str_replace('_',' ',$userdata->roles->pluck('name')[0] ?? '')), '\',. ')}}</li>
                            <li class="list-group-item"><b>Reporting Authority</b> :  @foreach($reportingauthority as $thisreportingauth)<a href="{{route('users.editUser',$thisreportingauth->id)}}">{{$thisreportingauth->name}}</a>@endforeach</li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

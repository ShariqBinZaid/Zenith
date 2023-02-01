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

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Add New User</h6>
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
                        <div class="col">
                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                        </div>
                        <div class="col">
                            <input type="text" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email" aria-label="Email">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ old('phone') }}" name="phone" class="form-control" placeholder="Phone" aria-label="Phone">
                        </div>
                        
                        <div class="col">
                            <select class="form-select" name="role">
                                <option selected disabled>Choose the Role...</option>
                                @foreach($allRoles as $thisRole)
                                <option value="{{$thisRole->id}}">{{ucwords(strtolower(str_replace('_',' ',$thisRole->name)), '\',. ')}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="date" value="{{ old('joining') }}" class="form-control" name="joining" placeholder="Joining" aria-label="Joining">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select" name="shift">
                                <option selected disabled>Choose the Shift Timings...</option>
                                @foreach($allshifts as $thisshift)
                                <option value="{{$thisshift->id}}">{{$thisshift->name}}( {{$thisshift->timing}} )</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select" name="gender">
                                <option selected disabled>Choose the Gender...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
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
                    <div class="d-flex mb-4">
                        <h6 class="card-title mb-0">Total {{$charaterstic}} Users</h6>
                        
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$totalusers}}</div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
   
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <button class="btn btn-outline-light" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @can('view inactive users')
                <div class="dropdown ms-auto">
                    <a href="#" data-bs-toggle="dropdown"
                       class="btn btn-primary dropdown-toggle"
                       aria-haspopup="true" aria-expanded="false">More</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{route('users.allUsers')}}" class="dropdown-item">Active Users</a>
                        <a href="{{route('users.inactiveUsers')}}" class="dropdown-item">In-Active Users</a>
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
                <th>Role</th>
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
                <td><a class="image-popup" href="{{asset('images/'.$thisuser->image)}}"><img src="{{asset('images/'.$thisuser->image)}}" height="50px" width="50px" class="showusersimage"/></a></td>
                <td><a href="{{route('users.editUser',$thisuser->id)}}">{{$thisuser->name}}</a></td>
                <td>{{$thisuser->email}}</td>
                <td>{{ucwords(strtolower(str_replace('_',' ',$thisuser->roles->pluck('name')[0] ?? '')), '\',. ')}}</td>
                @can('update users')
                <td class="text-end">
                    <div class="d-flex">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown"
                               class="btn btn-floating"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
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

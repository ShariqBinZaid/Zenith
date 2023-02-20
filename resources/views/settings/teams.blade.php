@extends('layouts.app')

@section('content')
<div class="content ">
        
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="bi bi-gear small me-2"></i> Settings
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Teams</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                <h6 class="card-title mb-5">Add New Team</h6>
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
                <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.addTeam')}}">
                    {{csrf_field()}}
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-control" name="leader">
                                <option selected disabled>--Select Team Leader--</option>
                                @foreach($leaders as $thisleader)
                                <option value="{{$thisleader->id}}">{{$thisleader->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" name="unit_id">
                                <option selected disabled>--Select Unit--</option>
                                @foreach($units as $thisunit)
                                <option value="{{$thisunit->id}}">{{$thisunit->name}}</option>
                                @endforeach
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
                        <h6 class="card-title mb-0">Total Teams</h6>
                        
                        <div class="text-center mt-5">
                        <div class="display-6">{{$totalteams}}</div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="allTeams">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Team Leader</th>
                <th>Unit</th>
                <th>Members</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teams as $thisteam)
            <tr>
                <td>
                    <a href="javascript:;">{{$loop->iteration}}</a>
                </td>
                <td><a href="{{route('users.thisTeam',$thisteam->id)}}">{{$thisteam->name}}</a></td>
                <td><a href="{{route('users.editUser',$thisteam->getLeader->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisteam->getLeader->name}}"><img src="{{asset('images/'.$thisteam->getLeader->image)}}" class="rounded" alt="image"></a></td>
                <td>{{$thisteam->getUnit->name}}</td>
                <td><div class="avatar-group me-2">@foreach($thisteam->users as $thisuser)
                    @if($thisuser->is_leader == 1)
                    @else
                        <a href="{{route('users.editUser',$thisuser->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisuser->name}}">
                            <img src="{{asset('images/'.$thisuser->image)}}" class="rounded-circle" alt="image">
                        </a>
                    @endif
                    @endforeach</div></td>

                <td class="text-end">
                    <div class="d-flex">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown"
                               class="btn btn-floating"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{route('admin.showMembers',$thisteam->id)}}" class="dropdown-item" rel="">Edit / Add Team Member</a>
                                <a href="{{route('admin.assignBrandToTeam',$thisteam->id)}}" class="dropdown-item" rel="">Assign Brand to Team</a>
                                <a href="javascript:;" class="dropdown-item deleteTeam" rel="{{$thisteam->id}}">Delete</a>
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

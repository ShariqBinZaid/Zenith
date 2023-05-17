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
                <!-- <li class="breadcrumb-item " aria-current="page">{{$userdata->name}}</li> -->
                <li class="breadcrumb-item " aria-current="page">
                    <a href="{{route('users.editUser',$userdata->id)}}">{{$userdata->name}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Assign Roles and Permissions</li>

            </ol>
        </nav>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-3">Assign Roles to {{$userdata->name}}</h6>

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
                            <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('users.assignRoletoUser')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <input type="hidden" name="id" value="{{request()->route('id')}}" />
                                        <select class="form-control select2-example" name="role">
                                            <option>--Select Role--</option>
                                            @foreach($allroles as $thisrole)
                                            <option value="{{$thisrole->id}}">{{$thisrole->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Assign Role</button>
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
                    <div class="d-flex mb-4">
                        <h6 class="card-title mb-0">{{ucwords(strtolower(str_replace('_',' ',$userdata->name)), '\',. ')}}'s Roles</h6>
                    </div>
                    <div class="text-center">
                        <div class="card mt-3" style="width: 18rem;">
                            <ul class="list-group list-group-flush text-capitalize">
                                @if($userdata->roles)
                                @foreach($userdata->roles as $thisrole)
                                <li class="list-group-item">{{ $thisrole->name}}
                                    <form class="mb-2 mt-2" action="{{route('users.unassignRoletoUser')}}" method="POST">{{csrf_field()}}<input type="hidden" name="id" value="{{request()->route('id')}}"><input type="hidden" name="role" value="{{ $thisrole->id}}"><input type="submit" name="submit" value="Unassign" class="btn btn-danger "></form>
                                </li>
                                @endforeach
                                @else
                                <li class="list-group-item">No Permission found!</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-3">Assign Permissions to {{$userdata->name}}</h6>

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
                            <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('users.assignPermtoUser')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <input type="hidden" name="id" value="{{request()->route('id')}}" />
                                        <select class="form-control select2-example" name="perm">
                                            <option>--Select Permission--</option>
                                            @foreach($allperms as $thisperm)
                                            <option value="{{$thisperm->id}}">{{$thisperm->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Assign Permission</button>
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
                    <div class="d-flex mb-4">
                        <h6 class="card-title mb-0">{{ucwords(strtolower(str_replace('_',' ',$userdata->name)), '\',. ')}}'s Permissions</h6>
                    </div>
                    <div class="text-center">
                        <div class="card mt-3" style="width: 18rem;">
                            <ul class="list-group list-group-flush text-capitalize">
                                @if($userdata->permissions)
                                @foreach($userdata->permissions as $thisperm)
                                <li class="list-group-item">{{ $thisperm->name}}
                                    <form class="mb-2 mt-2" action="{{route('users.unassignPermtoUser')}}" method="POST">{{csrf_field()}}<input type="hidden" name="id" value="{{request()->route('id')}}"><input type="hidden" name="perm" value="{{ $thisperm->id}}"><input type="submit" name="submit" value="Unassign" class="btn btn-danger "></form>
                                </li>
                                @endforeach
                                @else
                                <li class="list-group-item">No Permission found!</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
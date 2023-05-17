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
                <li class="breadcrumb-item " aria-current="page">
                    <a href="{{route('admin.allRoles')}}">Roles</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">
                    <a href="">Assign Permission</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ucwords(strtolower(str_replace('_',' ',$roledata->name)), '\',. ')}}</li>

            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Assign Permission to "{{ucwords(strtolower(str_replace('_',' ',$roledata->name)), '\',. ')}}"</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.assignPermission')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col">
                                <input type="hidden" name="id" value="{{request()->route('id')}}" />
                                <select class="form-control select2-example" name="permission">
                                    <option selected disabled>--Select the permission--</option>
                                    @foreach($allpermissions as $thispermission)
                                    <option value="{{$thispermission->id}}">{{$thispermission->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-4">
                        <h6 class="card-title mb-0">{{ucwords(strtolower(str_replace('_',' ',$roledata->name)), '\',. ')}}'s Permissions</h6>
                    </div>
                    <div class="text-center">
                        <div class="card mt-3" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                @if($roledata->permissions)
                                @foreach($roledata->permissions as $thispermission)
                                <li class="list-group-item">{{ $thispermission->name}}
                                    <form class="mb-2 mt-2" action="{{route('admin.unassignPermission')}}" method="POST">{{csrf_field()}}<input type="hidden" name="id" value="{{request()->route('id')}}"><input type="hidden" name="permission" value="{{ $thispermission->id}}"><input type="submit" name="submit" value="Unassign" class="btn btn-danger "></form>
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
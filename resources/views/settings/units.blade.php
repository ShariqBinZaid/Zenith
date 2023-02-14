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
                <li class="breadcrumb-item active" aria-current="page">Units</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                <h6 class="card-title mb-5">Add New Unit</h6>
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
                <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.addUnit')}}">
                    {{csrf_field()}}
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-control" name="company_id">
                                <option selected disabled>--Select Company--</option>
                                @foreach($companies as $thiscompanies)
                                <option value="{{$thiscompanies->id}}">{{$thiscompanies->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" name="unithead">
                                <option selected disabled>--Select Unit Head--</option>
                                @foreach($unitheads as $thisunithead)
                                <option value="{{$thisunithead->id}}">{{$thisunithead->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <textarea class="form-control" name="desc"></textarea>
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
                        <h6 class="card-title mb-0">Total Units</h6>
                        
                        <div class="text-center mt-5">
                        <div class="display-6">{{$totalunits}}</div>
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
                <th>Company</th>
                <th>Unit Head</th>
                <th>Description</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($units as $thisunit)
            <tr>
                <td>
                    <a href="javascript:;">{{$loop->iteration}}</a>
                </td>
                <td>{{$thisunit->name}}</td>
                <td><a href="javascript:;"  data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisunit->getCompany->name}}"><img src="{{asset('images/'.$thisunit->getCompany->logo)}}" class="imageintable"/></a></td>
                <td><a href="{{route('users.editUser',$thisunit->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisunit->getUnitHead->name}}">
                            <img src="{{asset('images/'.$thisunit->getUnitHead->image)}}" class="rounded-circle" alt="image">
                        </a></td>
                
                <td>{{$thisunit->desc}}</td>
                
                <td class="text-end">
                    <div class="d-flex">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown"
                               class="btn btn-floating"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;" class="dropdown-item" rel="{{$thisunit->id}}">Edit</a>
                                <a href="javascript:;" class="dropdown-item deleteTeam" rel="{{$thisunit->id}}">Delete</a>
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

@extends('layouts.app')

@section('content')
<div class="content ">
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('adminDashboard')}}">
                        <i class="bi bi-globe2 small me-2"></i> Setting
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Package Types</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Add New Package Types</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('packageTypes.addPackageTypes')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
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
                        <h6 class="card-title mb-0">Total Package Types</h6>
                        <div class="dropdown ms-auto">
                            <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a> -->
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- <a href="#" class="dropdown-item">View Detail</a> -->
                                <a href="#" class="dropdown-item">Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$totalpackagetypes}}</div>
                        <!-- <div class="d-flex justify-content-center gap-3 my-3">
                            <i class="bi bi-star-fill icon-lg text-warning"></i>
                            <i class="bi bi-star-fill icon-lg text-warning"></i>
                            <i class="bi bi-star-fill icon-lg text-warning"></i>
                            <i class="bi bi-star-fill icon-lg text-muted"></i>
                            <i class="bi bi-star-fill icon-lg text-muted"></i>
                            <span>(318)</span>
                        </div> -->
                    </div>
                    <div class="text-muted d-flex align-items-center justify-content-center">
                        <span class="text-success me-3 d-block">
                            <i class="bi bi-arrow-up me-1 small"></i>+35
                        </span> Point from last month
                    </div>
                    <div class="row my-4">
                        <div class="col-md-6 m-auto">
                            <div id="customer-rating"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-outline-primary btn-icon">
                            <i class="bi bi-download"></i> Download All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="allPackageTypes">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Packages Types</th>
                    <!-- <th>Created At</th> -->
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packagetypes as $thispackagetypes)
                <tr>
                    <td>
                        <a href="javascript:;">{{$loop->iteration}}</a>
                    </td>
                    <td>{{$thispackagetypes->name}}</td>
                    <!-- <td>{{$thispackagetypes->created_at}}</td> -->
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ShowPackageTypesModal" data-bs-id="{{$thispackagetypes->id}}" data-bs-name="{{$thispackagetypes->name}}" data-bs-created_at="{{$thispackagetypes->created_at}}">Show</a>
                                    <a href="{{route('packageTypes.editPackageTypes',$thispackagetypes->id)}}" class="dropdown-item">Edit</a>
                                    <a href="javascript:;" class="dropdown-item deletePackageTypes" rel="{{$thispackagetypes->id}}">Delete</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav class="mt-4" aria-label="Page navigation example">
        {!! $packagetypes->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>

</div>
@endsection
@push('scripts')
@endpush
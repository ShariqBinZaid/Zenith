@extends('layouts.app')

@section('content')
<div class="content ">
        
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('adminDashboard')}}">
                        <i class="bi bi-globe2 small me-2"></i> Marketing
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Packages</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Add New Package</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('packages.addPackage')}}">
                    {{csrf_field()}}
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select" name="package_type">
                                <option selected disabled>Choose Package Type...</option>
                                @foreach($packagetypes as $thispackagetype)
                                <option value="{{$thispackagetype->id}}">{{$thispackagetype->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                        <select class="form-select" name="brand_id">
                            <option selected disabled>Choose Brand...</option>
                            @foreach($allbrands as $thisbrand)
                            <option value="{{$thisbrand->id}}">{{$thisbrand->name}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col">
                            <input type="text" value="{{ old('discount') }}" name="discount" class="form-control" placeholder="Discount(Optional)" aria-label="Discount(Optional)">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ old('price') }}" class="form-control" name="price" placeholder="Price" aria-label="Price">
                        </div>
                        <div class="col">
                            <input type="text" value="{{ old('cut_price') }}" name="cut_price" class="form-control" placeholder="Cut Price" aria-label="Cut Price">
                        </div>
                        <div class="col">
                        <select class="form-select" name="currency">
                            <option selected disabled>Choose Currency...</option>
                            @foreach($currencies as $thiscurrency)
                            <option value="{{$thiscurrency->id}}">{{$thiscurrency->code}} ({{$thiscurrency->symbol}})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    </div>
                    <div class="row mb-3">
                        <textarea class="description" name="description" id="packagedetails"></textarea>
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
                        <h6 class="card-title mb-0">Total Packages</h6>
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- <a href="#" class="dropdown-item">View Detail</a> -->
                                <a href="#" class="dropdown-item">Download</a>
                            </div>
                        </div>
                    </div>
                     <div class="text-center">
                        <div class="display-6">{{$totalpackages}}</div>
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

    <!-- <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                         <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option>Sort by</option>
                                    <option value="desc">Desc</option>
                                    <option value="asc">Asc</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="col-md-6">
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
                <div class="dropdown ms-auto">
                    <a href="#" data-bs-toggle="dropdown"
                       class="btn btn-primary dropdown-toggle"
                       aria-haspopup="true" aria-expanded="false">Actions</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">Action</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item">Something else here</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="table-responsive" id="allPackages">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Package Type</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Created At</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($packages as $thispackage)
            <tr>
                <td>
                    <a href="javascript:;">{{$loop->iteration}}</a>
                </td>
                <td>{{$thispackage->name}}</td>
                <td>{{$thispackage->getPackageType->name}}</td>
                <td>
                    <span class="badge bg-success">{{$thispackage->getBrand->name}}</span>
                </td>
                <td>{{$thispackage->getCurrency->symbol}}{{$thispackage->price}}</td>
                <td>{{$thispackage->created_at}}</td>
                <td class="text-end">
                    <div class="d-flex">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown"
                               class="btn btn-floating"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;" class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#ShowPackageModal" data-bs-id="{{$thispackage->id}}" data-bs-name="{{$thispackage->name}}" data-bs-price="{{$thispackage->getCurrency->symbol}}{{$thispackage->price}}" data-bs-cut_price="{{$thispackage->getCurrency->symbol}}{{$thispackage->cut_price}}" data-bs-description="{!!$thispackage->description!!}" data-bs-currency="{{$thispackage->getCurrency->name}}" data-bs-brand_id="{{$thispackage->getBrand->name}}" data-bs-package_type="{{$thispackage->getPackageType->name}}" data-bs-created_at="{{$thispackage->created_at}}" data-bs-discount="{{$thispackage->discount}}" >Show</a>
                                <a href="{{route('packages.editPackage',$thispackage->id)}}" class="dropdown-item">Edit</a>
                                <a href="javascript:;" class="dropdown-item deletePackage" rel="{{$thispackage->id}}">Delete</a>
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
        
        {!! $packages->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>

    </div>
@endsection
@push('scripts')
@endpush
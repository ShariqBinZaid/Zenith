@extends('layouts.app')

@section('content')
<div class="content ">
        
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="bi bi-globe2 small me-2"></i> Marketing
                    </a>
                </li>
                <li class="breadcrumb-item " aria-current="page">
                    <a href="{{route('packages.allPackages')}}">Packages</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update Package</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Update Package</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('packages.updatePackage')}}">
                    {{csrf_field()}}
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ $packagedata->name }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                            <input type="hidden" value="{{$id}}" name="id"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select" name="package_type">
                                <option selected disabled>Choose Package Type...</option>
                                @foreach($packagetypes as $thispackagetype)
                                <option value="{{$thispackagetype->id}}" <?php if($packagedata->package_type == $thispackagetype->id) {echo 'selected';} ?>>{{$thispackagetype->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                        <select class="form-select" name="brand_id">
                            <option selected disabled>Choose Brand...</option>
                            @foreach($allbrands as $thisbrand)
                            <option value="{{$thisbrand->id}}" <?php if($packagedata->brand_id == $thisbrand->id) {echo 'selected';} ?>>{{$thisbrand->name}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col">
                            <input type="text" value="{{ $packagedata->discount }}" name="discount" class="form-control" placeholder="Discount(Optional)" aria-label="Discount(Optional)">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ $packagedata->price }}" class="form-control" name="price" placeholder="Price" aria-label="Price">
                        </div>
                        <div class="col">
                            <input type="text" value="{{ $packagedata->cut_price }}" name="cut_price" class="form-control" placeholder="Cut Price" aria-label="Cut Price">
                        </div>
                        <div class="col">
                        <select class="form-select" name="currency">
                            <option disabled>Choose Currency...</option>
                            @foreach($currencies as $thiscurrency)
                            <option value="{{$thiscurrency->id}}" <?php if($packagedata->currency == $thiscurrency->id) {echo 'selected';} ?> >{{$thiscurrency->code}} ({{$thiscurrency->symbol}})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    </div>
                    <div class="row mb-3">
                        <textarea class="description" name="description" id="packagedetails">{{ $packagedata->description }}</textarea>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Update</button>
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

</div>
@endsection
@push('scripts')
@endpush
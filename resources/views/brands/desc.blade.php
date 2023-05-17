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
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('brands.allBrands')}}">Brands</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Description</li>
                </ol>
            </nav>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col-lg-4 col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="display-7">
                                <i class="bi bi-telephone-inbound"></i>
                                <!-- <i class="bi bi-basket"></i> -->
                            </div>
                            <div class="dropdown ms-auto">
                                <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item">View Detail</a>
                                    <a href="#" class="dropdown-item">Download</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-3">Total Leads</h4>
                        <div class="d-flex mb-3">
                            <div class="display-7">{{$branddetails->leads->count()}}</div>
                            <div class="ms-auto" id="total-orders"></div>
                        </div>
                        <div class="text-success">
                            Over last month 1.4% <i class="small bi bi-arrow-up"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="display-7">
                                <i class="bi bi-briefcase"></i>
                                <!-- <i class="bi bi-credit-card-2-front"></i> -->
                            </div>
                            <div class="dropdown ms-auto">
                                <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item">View Detail</a>
                                    <a href="#" class="dropdown-item">Download</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-3">Total Opportunities</h4>
                        <div class="d-flex mb-3">
                            <div class="display-7">{{$branddetails->opportunities->count()}}</div>
                            <div class="ms-auto" id="total-orders"></div>
                        </div>
                        <div class="text-warning">
                            Over last month 2.4% <i class="small bi bi-arrow-down"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <div class="display-7">
                                <i class="bi bi-box"></i>
                                <!-- <i class="bi bi-credit-card-2-front"></i> -->
                            </div>
                            <div class="dropdown ms-auto">
                                <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                                aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item">View Detail</a>
                                    <a href="#" class="dropdown-item">Download</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-3">Total Packages</h4>
                        <div class="d-flex mb-3">
                            <div class="display-7">{{$branddetails->packages->count()}}</div>
                            <div class="ms-auto" id="total-orders"></div>
                        </div>
                        <div class="text-danger">
                            Over last month 2.4% <i class="small bi bi-arrow-down"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mt-5" style="margin:0px auto;">
                <div class="card">
                    <div class="card-body text-center">
                        <div class=" avatar-xl mb-3">
                            <img src="{{asset('images/'.$branddetails->image)}}" class="w-50" alt="...">
                        </div>
                        <div class="mb-4">
                            <h3>Name : {{$branddetails->name}}</h3>
                            <h6>Type : {{$branddetails->type}}</h6>
                            <h6>Initials : {{$branddetails->initials}}</h6>
                            <!--<h6>URL : {{$branddetails->url}}</h6>-->
                            <h6>URL : <a href="{{$branddetails->url}}" target="_blank">{{$branddetails->url}}</a></h6>
                            <h6>Unit : {{$branddetails->getUnit->name}}</h6>
                            <h6>Company : {{$branddetails->getCompany->name}}</h6>
                        </div>
                        
                    </div>
                </div>
            </div>            
        </div>    
    </div>        

@endsection         
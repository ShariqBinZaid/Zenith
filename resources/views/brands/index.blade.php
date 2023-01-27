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
                <li class="breadcrumb-item active" aria-current="page">Brands</li>
            </ol>
        </nav>
    </div>
    @can('add brands')
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Add New Brand</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('brands.addBrand')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                        </div>
                        <div class="col">
                            <input type="text" value="{{ old('url') }}" name="url" class="form-control" placeholder="URL" aria-label="URL">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ old('initials') }}" class="form-control" name="initials" placeholder="Initials" aria-label="Initials">
                        </div>
                        <div class="col">
                        <select class="form-select" name="type">
                            <option selected disabled>Choose the Brand Type...</option>
                            <option value="Design">Design</option>
                            <option value="E-Book">E-Book</option>
                            <option value="Mobile Apps">Mobile Apps</option>
                        </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="file" value="{{ old('image') }}" class="form-control" name="image" placeholder="Logo" aria-label="Logo">
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
                        <h6 class="card-title mb-0">Total Brands</h6>
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
                        <div class="display-6">{{$totalbrand}}</div>
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
    @endcan
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
    <div class="table-responsive" id="allBrands">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
            <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Type</th>
                <th>URL</th>
                <th>Initials</th>
                <!-- <th>Created At</th> -->
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($brands as $thisbrand)
            <tr>
                <td>
                    <a href="javascript:;">{{$loop->iteration}}</a>
                </td>
                <td><a class="image-popup" href="{{asset('images/'.$thisbrand->image)}}"><img src="{{asset('images/'.$thisbrand->image)}}" class="imageintable"/></a></td>
                <td>{{$thisbrand->name}}</td>
                <td>{{$thisbrand->type}}</td>
                <td>
                    <span class="badge bg-success">{{$thisbrand->url}}</span>
                </td>
                <td>{{$thisbrand->initials}}</td>
                <!-- <td>{{$thisbrand->created_at}}</td> -->
                <td class="text-end">
                    <div class="d-flex">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown"
                               class="btn btn-floating"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;" class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#ShowbrandModal" data-bs-id="{{$thisbrand->id}}" data-bs-name="{{$thisbrand->name}}" data-bs-image="{{asset('images/'.$thisbrand->image)}}" data-bs-type="{{$thisbrand->type}}" data-bs-url="{{$thisbrand->url}}" data-bs-initials="{{$thisbrand->initials}}" data-bs-created_at="{{$thisbrand->created_at}}">Show</a>
                                @can('update brands')
                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditbrandModal" data-bs-id="{{$thisbrand->id}}" data-bs-name="{{$thisbrand->name}}" data-bs-image="{{asset('images/'.$thisbrand->image)}}" data-bs-type="{{$thisbrand->type}}" data-bs-url="{{$thisbrand->url}}" data-bs-initials="{{$thisbrand->initials}}" data-bs-oldimagelink="{{$thisbrand->image}}">Edit</a>
                                @endcan
                                @can('delete brands')
                                <a href="javascript:;" class="dropdown-item deleteBrand" rel="{{$thisbrand->id}}">Delete</a>
                                @endcan
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
        
        {!! $brands->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>

    </div>
@endsection

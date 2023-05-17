@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('fleet.allFleet')}}">
                        <i class="bi bi-truck"></i> Fleet
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update Fleets</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Update Fleets</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('fleet.updateFleet')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->car_name }}" class="form-control" name="car_name" placeholder="Car Name" aria-label="Car Name">
                                <input type="hidden" value="{{$id}}" name="id" />
                                <label for="floatingInput">Name</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->model }}" class="form-control" id="floatingInput" name="model" placeholder="Car Model" aria-label="Car Model">
                                <label for="floatingInput">Car Model</label>
                            </div>
                            
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->vendor }}" class="form-control" id="floatingInput" name="vendor" placeholder="vendor" aria-label="Vendor">
                                <label for="floatingInput">Vendor</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->vendor_number }}" class="form-control" id="floatingInput" name="vendor_number" placeholder="Vendor Number" aria-label="Vendor Number">
                                <label for="floatingInput">Vendor Number</label>
                            </div>
                        </div>    
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->km }}" class="form-control" id="floatingInput" name="km" placeholder="Car Kilo Meter" aria-label="Car Kilo Meter">
                                <label for="floatingInput">Car Kilo Meter</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->car_number }}" class="form-control" id="floatingInput" name="car_number" placeholder="Car Number" aria-label="Car Number">
                                <label for="floatingInput">Car Number</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->chassis_number }}" class="form-control" id="floatingInput" name="chassis_number" placeholder="Chassis Number" aria-label="Chassis Number">
                                <label for="floatingInput">Chassis Number</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->engine_number }}" class="form-control" id="floatingInput" name="engine_number" placeholder="Engine Number" aria-label="Engine Number">
                                <label for="floatingInput">Engine Number</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->cc }}" class="form-control" id="floatingInput" name="cc" placeholder="Engine CC" aria-label="Engine CC">
                                <label for="floatingInput">Engine CC</label>
                            </div>
                            <div class="col form-floating">
                                <input type="number" value="{{ $fleet->rent }}" class="form-control" id="floatingInput" name="rent" placeholder="Car Rent" aria-label="Car Rent">
                                <label for="floatingInput">Car Rent</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-select select2-example" name="user_id">
                                    <option selected disabled>Select User...</option>
                                    @foreach($alluser as $thissuer)
                                        <option value="{{$thissuer->id}}" {{($thissuer->id == $fleet->user_id) ? 'selected' : ''}}>{{$thissuer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ $fleet->assign_date }}" class="form-control" id="floatingInput" name="assign_date" placeholder="Assign Date" aria-label="Assign Date">
                                <label for="floatingInput">Assign Date</label>
                            </div>
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
                    <div class="d-flex mb-4 masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-truck"></i>
                        </span>
                        <h6 class="card-title px-3">Total Fleet</h6>
                        <div class="dropdown ms-auto">
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$totalfleet}}</div>
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

<script>
    $(document).ready(function() {
        $('input[name="assign_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true
        });
    })
</script>
@endpush
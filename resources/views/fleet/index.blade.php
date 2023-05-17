@extends('layouts.app')
<style>
    span.notfound {
    color: red;
}
</style>
@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <!--<li class="breadcrumb-item">-->
                <!--    <a href="{{route('adminDashboard')}}">-->
                <!--        <i class="bi bi-globe2 small me-2"></i> Setting-->
                <!--    </a>-->
                <!--</li>-->
                <li class="breadcrumb-item">
                    <a href="{{route('fleet.allFleet')}}">
                        <i class="bi bi-truck"></i> Fleet
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add New Fleets</li>
            </ol>
        </nav>
    </div>
    @can('add fleet')
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                         <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-truck me-3"></i>
                        <h6 class="card-title mb-5">Add New Fleets</h6>
                    </div>
                    
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('fleet.addFleet')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('car_name') }}" class="form-control" id="floatingInput" name="car_name" placeholder="Car Name" aria-label="Car Name">
                                <label for="floatingInput">Car Name</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('model') }}" class="form-control" id="floatingInput" name="model" placeholder="Car Model" aria-label="Car Model">
                                <label for="floatingInput">Car Model</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('vendor') }}" class="form-control" id="floatingInput" name="vendor" placeholder="Vendor" aria-label="Vendor">
                                <label for="floatingInput">Vendor</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('vendor_number') }}" class="form-control" id="floatingInput" name="vendor_number" placeholder="Vendor Number" aria-label="Vendor Number">
                                <label for="floatingInput">Vendor Number</label>
                            </div>
                        </div>    
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('km') }}" class="form-control" id="floatingInput" name="km" placeholder="Car Kilo Meter" aria-label="Car Kilo Meter">
                                <label for="floatingInput">Car Kilo Meter</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('car_number') }}" class="form-control" id="floatingInput" name="car_number" placeholder="Car Number" aria-label="Car Number">
                                <label for="floatingInput">Car Number</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('chassis_number') }}" class="form-control" id="floatingInput" name="chassis_number" placeholder="Chassis Number" aria-label="Chassis Number">
                                <label for="floatingInput">Chassis Number</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('engine_number') }}" class="form-control" id="floatingInput" name="engine_number" placeholder="Engine Number" aria-label="Engine Number">
                                <label for="floatingInput">Engine Number</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('cc') }}" class="form-control" id="floatingInput" name="cc" placeholder="Engine CC" aria-label="Engine CC">
                                <label for="floatingInput">Engine CC</label>
                            </div>
                            <div class="col form-floating">
                                <input type="number" value="{{ old('rent') }}" class="form-control" id="floatingInput" name="rent" placeholder="Car Rent" aria-label="Car Rent">
                                <label for="floatingInput">Car Rent</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-select select2-example" name="user_id">
                                    <option selected disabled>Select User...</option>
                                    @foreach($alluser as $thissuer)
                                    <option value="{{$thissuer->id}}" {{ old('user_id') == $thissuer->id ? 'selected' : '' }}>{{$thissuer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('assign_date') }}" class="form-control" id="floatingInputGrid" name="assign_date" placeholder="Assign Date" aria-label="Assign Date">
                                <label for="floatingInputGrid">Assign Date</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="floatingInput">Car Video (Optional)</label>
                                <input type="file" class="form-control" name="video" placeholder="Video" aria-label="Video">
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
                    <div class="d-flex mb-4 masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-truck"></i>
                        </span>
                        <h6 class="card-title px-3">Total Fleets</h6>
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
    @endcan
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="fleet d-md-flex gap-4 align-items-center">
                    <form class="d-md-flex gap-4 align-items-center" action="{{ route('fleet.allFleet') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="input-group form-floating" style="border: 0.5px solid #ced4da; border-radius: 9px;">
                                    <input style="background: transparent;" type="text" class="form-control" id="floatingInputInvalid" placeholder="Search" name="search" value="{{ $search ?? '' }}">
                                    <label for="floatingInputInvalid">Search</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col form-floating">
                                <div class="col form-floating">
                                    <select class="form-select select2-example" name="vendor">
                                        <option selected disabled>Select Vendor</option>
                                        @foreach($vendor as $thisvendor)
                                        <option value="{{$thisvendor->vendor}}" {{($vendorsearch == $thisvendor->vendor) ? "selected" :"none"; }} >{{$thisvendor->vendor}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        </div> 
                        <input type="submit" name="submit" value="Filter" class="btn btn-primary ">
                    </form> 
                    <form class="d-md-flex gap-4 align-items-center" action="{{ route('fleet.fleetCSV') }}" method="GET">
                        <div class="row g-3 d-none">
                            <div class="col-md-12">
                                <div class="input-group form-floating" style="border: 0.5px solid #ced4da; border-radius: 9px;">
                                    <input style="background: transparent;" type="text" class="form-control" id="floatingInputInvalid" placeholder="Search" name="search" value="{{ $search ?? '' }}">
                                    <label for="floatingInputInvalid">Search</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 d-none">
                            <div class="col form-floating">
                                <div class="col form-floating">
                                    <select class="form-select select2-example" name="vendor">
                                        <option selected disabled>Select Vendor</option>
                                        @foreach($vendor as $thisvendor)
                                        <option value="{{$thisvendor->vendor}}" {{($vendorsearch == $thisvendor->vendor) ? "selected" :"none"; }} >{{$thisvendor->vendor}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        </div> 
                        <input type="submit" name="submit" value="Generate CSV" class="btn btn-primary ">
                    </form> 
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="allFleet">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Assigned To</th>
                    <th>Car Name</th>
                    <th>Vendor</th>
                    <th>Engine CC</th>
                    <th>Assign Date</th>
                    <th>Car Number</th>
                    <th>Car Model</th>
                    <th>Kilo Meter</th>
                    <th>Rent</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fleet as $thisfleet)
                <tr>
                    <td>
                        <a href="javascript:;">{{$loop->iteration}}</a>
                    </td>
                    <td>
                        <a href="{{route('users.editUser',$thisfleet->user->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisfleet->user->name}}">
                            <img src="{{asset('images/'.$thisfleet->user->image)}}" class="rounded-circle" alt="image">
                        </a>
                    </td>
                    <td>{{$thisfleet->car_name}}</td>
                    <td><a style="padding-right:15px; font-size:15px;" href="tel:{{$thisfleet->vendor_number}}" data-bs-toggle="tooltip" data-bs-original-title="{{$thisfleet->vendor_number}}"><i class="bi bi-telephone"></i></a>{{$thisfleet->vendor}}</td>
                    <td>{{$thisfleet->cc}} CC</td>
                    <td>{{date('d-M-Y',strtotime($thisfleet->assign_date))}}</td>
                    <td>{{$thisfleet->car_number}}</td>
                    <td>{{$thisfleet->model}}</td>
                    <td>{{number_format($thisfleet->km, 2, '.', ',')}}</td>
                    <td>RS {{number_format($thisfleet->rent, 2, '.', ',')}}</td>
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @if($thisfleet->user->hasMeta('drivinglicence_back'))
                                    <a href="javascript:;" class="dropdown-item showdrivinglicense" data-bs-original-title="Driving License" data-bs-toggle="modal" data-bs-target="#ShowDrivingLicenseModal" data-drivingback="{{asset('images/'.$thisfleet->user->getMeta('drivinglicence_back'))}}" data-drivingfront="{{asset('images/'.$thisfleet->user->getMeta('drivinglicence_front'))}}">Show Driving License</a>
                                    @else
                                    <a href="javascript:;" class="dropdown-item" data-bs-original-title="Driving License" data-bs-toggle="modal" data-bs-target="#ShowDrivingLicenseModalNotFound" >Show Driving License</a>
                                    @endif
                                    
                                    @can('update fleet')
                                    
                                    <a href="{{route('fleet.editFleet',$thisfleet->id)}}" class="dropdown-item">Edit</a>
                                    @endcan
                                    @can('delete fleet')
                                    <a href="javascript:;" class="dropdown-item deleteFleet" rel="{{$thisfleet->id}}">Delete</a>
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
        {!! $fleet->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>
</div>
@endsection


@push('scripts')


    <div class="modal fade" id="ShowDrivingLicenseModal" tabindex="-1" aria-labelledby="ShowDrivingLicenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="ShowDrivingLicenseModalLabel">Driving License</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="showdrivinglicense" id="showdrivinglicense">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <span></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="border col-md-12 mb-2 p-2 text-center">
                                <label for="recipient-name" class="col-form-label"><b style="font-size: 18px;">Driving License (Front):</b></label>
                                <img class="front" id="front" src="" width="90%">
                                <a href="" class="downloadfrontimg btn btn-primary mt-3" download>Download Front</a>
                            </div>
                            <div class="border col-md-12 mb-2 p-2 text-center">
                                <label for="recipient-name" class="col-form-label"><b style="font-size: 18px;">Driving License (Back):</b></label>
                                <img class="back" id="back" src="" width="90%">
                                <a href="" class="downloadbackimg btn btn-primary mt-3" download>Download Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ShowDrivingLicenseModalNotFound" tabindex="-1" aria-labelledby="ShowDrivingLicenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="ShowDrivingLicenseModalLabel">Driving License Not Found</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <span class="notfound">Driving Licence Not Uploaded by User</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>
    


    <script>
        $(document).ready(function() {
            $('.showdrivinglicense').click(function() {
                $('.showdrivinglicense').find('.front').attr("src",$(this).data('drivingfront'));
                $('.showdrivinglicense').find('.back').attr("src",$(this).data('drivingback'));
                $('.showdrivinglicense').find('.downloadfrontimg').attr('href',$(this).data('drivingfront'));
                $('.showdrivinglicense').find('.downloadbackimg').attr('href',$(this).data('drivingback'));
            })
            $('input[name="assign_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });
        })
    </script>

<!-- Delete Fleet Ajax Start -->

<script type="text/javascript">
$(document).on('click','.deleteFleet',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this Fleet?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('fleet.deleteFleet')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteFleet',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Fleet has been deleted successfully!',
			  'success'
			)
            setTimeout(function() {
                    location.reload();
                }, 2000);
        }
    })
  }})
    })
</script>

<!-- Delete Fleet Ajax End -->

@endpush
@extends('layouts.app')

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
                <li class="breadcrumb-item active" aria-current="page">My Fleet</li>
            </ol>
        </nav>
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
    <div class="table-responsive" id="allFleet">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Car Name</th>
                    <th>Car Model</th>
                    <th>Engine CC</th>
                    <th>Car Number</th>
                    <th>Kilo Meter</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($myfleet as $thisfleet)
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
                    <td>{{$thisfleet->model}}</td>
                    <td>{{$thisfleet->cc}} CC</td>
                    <td>{{$thisfleet->car_number}}</td>
                    <td>{{$thisfleet->km}}</td>
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;" class="dropdown-item updatekilometer" data-bs-original-title="Update Kilometer" data-bs-toggle="modal" data-bs-target="#UpdateKilometerModal" data-km="{{ $thisfleet['km'] }}" data-id="{{ $thisfleet['id'] }}">Update Kilometer</a>
                                    <a href="javascript:;" class="dropdown-item requestmaintainance" data-bs-original-title="Request Maintainance" data-bs-toggle="modal" data-bs-target="#RequestMaintainanceModal" data-id="{{ $thisfleet['id'] }}">Request Maintainance</a>
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


@push('scripts')

    <div class="modal fade" id="UpdateKilometerModal" tabindex="-1" aria-labelledby="UpdateKilometerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="UpdateKilometerModalLabel">Update Kilometer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="updatedkilometer" id="updatedkilometer" method="POST" action="{{route('fleet.updateKilometer')}}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <input type="hidden" name="id" class="id" id="id">
                                {{@csrf_field()}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="recipient-name" class="col-form-label">Kilometer:</label>
                                <input type="text" class="form-control kilometers" id="floatingInput km" name="km" placeholder="Car Kilo Meter" aria-label="Car Kilo Meter">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success updatetaxsubmit" id="submitBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="RequestMaintainanceModal" tabindex="-1" aria-labelledby="RequestMaintainanceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="RequestMaintainanceModalLabel">Request Maintainance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="requestmaintainanceform" id="requestmaintainance" method="POST" action="{{route('fleet.requestMaintainance')}}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <input type="hidden" name="id" class="id" id="id">
                                {{@csrf_field()}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="recipient-name" class="col-form-label">Request Message:</label>
                                <textarea class="form-control" name="reason" placeholder="Request Message (optional)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success requestmaintainancesubmit" id="submitBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.updatekilometer').click(function() {
                $('.updatedkilometer').find('#id').val($(this).data('id'));
                $('.updatedkilometer').find('.kilometers').val($(this).data('km'));
            })
            $('.requestmaintainance').click(function() {
                $('.requestmaintainanceform').find('#id').val($(this).data('id'));
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
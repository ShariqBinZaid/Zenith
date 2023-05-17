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
                <li class="breadcrumb-item active" aria-current="page">Shift Timings</li>
            </ol>
        </nav>
    </div>
    @can('add department')
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-clock me-3"></i>
                        <h6 class="card-title mb-5">Add New Shift</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST"
                        action="{{route('shifts.addShifts')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput"
                                    name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInput">Name</label>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col input-group clockpicker">
                                <input type="text" class="form-control" value="{{ old('starting_hours') }}" name="starting_hours" placeholder="Starting Hours" aria-label="Starting Hours"
                                    aria-describedby="button-addon1">
                                <button class="btn btn-light" type="button" id="button-addon1">
                                    <i class="bi bi-clock"></i>
                                </button>
                            </div>
                            <div class="col input-group clockpicker">
                                <input type="text" class="form-control" value="{{ old('ending_hours') }}" name="ending_hours" placeholder="Ending Hours" aria-label="Ending Hours"
                                    aria-describedby="button-addon1">
                                <button class="btn btn-light" type="button" id="button-addon1">
                                    <i class="bi bi-clock"></i>
                                </button>
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
                            <i class="bi bi-clock"></i>
                        </span>
                        <h6 class="card-title px-3">Total Shifts Timing</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$shifts->total()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <form action="{{ route('shifts.allShifts') }}" method="GET">
                                    <div class="input-group form-floating"
                                        style="border: 0.5px solid #ced4da; border-radius: 9px;">
                                        <input style="background: transparent;" type="text" class="form-control" id="floatingInputInvalid" placeholder="Search" name="search" value="{{ $search ?? '' }}">
                                        <label for="floatingInputInvalid">Search</label>
                                        <button class="btn btn-outline-light" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="allShiftsTiming">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Timing</th>
                    <th>Shifts Hours</th>
                    <th>Starting Hours</th>
                    <th>Ending Hours</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shifts as $thisshifts)
                <tr>
                    <td><a href="javascript:;">{{$loop->iteration}}</a></td>
                    <td>{{$thisshifts->name}}</td>
                    <td>{{$thisshifts->timing}}</td>
                    <td>{{$thisshifts->shift_hours}}</td>
                    <td>{{$thisshifts->starting_hours}}</td>
                    <td>{{$thisshifts->ending_hours}}</td>
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;" class="dropdown-item editshift" data-bs-toggle="modal" data-bs-target="#EditShiftsModal" data-shiftsid="{{$thisshifts->id}}" data-shiftsname="{{$thisshifts->name}}" data-shiftstiming="{{$thisshifts->timing}}" data-shiftsstarting_hours="{{$thisshifts->starting_hours}}" data-shiftsending_hours="{{$thisshifts->ending_hours}}" data-shiftshift_hours="{{$thisshifts->shift_hours}}">Edit</a>
                                    <a href="javascript:;" class="dropdown-item deleteShifts" rel="{{$thisshifts->id}}">Delete</a>
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
        {!! $shifts->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>
</div>
@endsection


@push('scripts')

<div class="modal fade" id="EditShiftsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <h5 class="modal-title" id="EditShiftsModalLabel">Update Shift Timing's</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateshiftsform">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" name="name" id="name" class="form-control name"/>
                            <input type="hidden" name="id" id="id" class="id" />
                            {{@csrf_field()}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12 input-group clockpicker">
                            <label for="recipient-name" class="col-form-label">Shifts Hours:</label>
                            <input type="text" class="form-control starting_hours" name="shift_hours" id="shift_hours" placeholder="Shift Hours" aria-label="Shift Hours" aria-describedby="button-addon1">
                            <button class="btn btn-light" type="button" id="button-addon1">
                                <i class="bi bi-clock"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12 input-group clockpicker">
                            <label for="recipient-name" class="col-form-label">Timing:</label>
                            <input type="text" class="form-control timing" name="timing" id="timing" placeholder="Timing" aria-label="Timing" aria-describedby="button-addon1">
                            <button class="btn btn-light" type="button" id="button-addon1">
                                <i class="bi bi-clock"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12 input-group clockpicker">
                            <label for="recipient-name" class="col-form-label">Starting Hours:</label>
                            <input type="text" class="form-control starting_hours" name="starting_hours" id="starting_hours" placeholder="Starting Hours" aria-label="Starting Hours" aria-describedby="button-addon1">
                            <button class="btn btn-light" type="button" id="button-addon1">
                                <i class="bi bi-clock"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12 input-group clockpicker">
                            <label for="recipient-name" class="col-form-label">Ending Hours:</label>
                            <input type="text" class="form-control ending_hours" name="ending_hours" id="ending_hours" placeholder="Ending Hours" aria-label="Ending Hours" aria-describedby="button-addon1">
                            <button class="btn btn-light" type="button" id="button-addon1">
                                <i class="bi bi-clock"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary updateshiftssubmit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        $('.editshift').click(function () {
            // alert($(this).data('name'))
            $('#updateshiftsform').find('#id').val($(this).data('id'))
            $('#updateshiftsform').find('.name').val($(this).data('shiftsname'))
            $('#updateshiftsform').find('.timing').val($(this).data('shiftstiming'))
            $('#updateshiftsform').find('.starting_hours').val($(this).data('shiftsstarting_hours'))
            $('#updateshiftsform').find('.ending_hours').val($(this).data('shiftsending_hours'))
            $('#updateshiftsform').find('.shift_hours').val($(this).data('shift_hours'))
        })
        $('.clockpicker').clockpicker({
            autoclose: true
        });
    })



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#updateshiftsform').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{route('shifts.updateShifts')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                Swal.fire(
                    'Thank You!',
                    'Shifts has been updated successfully!',
                    'success'
                )
                setTimeout(function () {
                    location.reload();
                }, 2000);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                var errors = XMLHttpRequest['responseJSON']['errors'];
                var response = JSON.parse(XMLHttpRequest.responseText);
                var errorString = '<ul>';
                $.each(response.errors, function (key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                errorString += '</ul>';
                //errorThrown.='\n'+
                Swal.fire(
                    'Request Failed!',
                    errorString,
                    'error'
                )
            }
        });
    });
</script>


<!--Delete -->
<script type="text/javascript">
    $(document).on('click', '.deleteShifts', function (e) {
        e.preventDefault();
        var id = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure you want to delete this Shifts?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('shifts.deleteShifts')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: { type: 'deleteShifts', id: id },
                    success: function (res) {
                        Swal.fire(
                            'Deleted!',
                            'Shifts has been deleted successfully!',
                            'success'
                        )
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                })
            }
        })
    })
</script>
<!--Delete -->


@endpush
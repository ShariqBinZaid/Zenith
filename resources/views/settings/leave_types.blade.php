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
                <li class="breadcrumb-item active" aria-current="page">Leave Types</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-calendar-event me-3"></i>
                        <h6 class="card-title mb-5">Add New Leave Type</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.addLeaveType')}}">
                        {{csrf_field()}}
                        <div class="row mb-2">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInput">Name</label>
                            </div>
                            <div class="col form-floating">
                                <input type="number" name="days" class="form-control" id="floatingInput" />
                                <label for="floatingInput">Days</label>
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
                            <i class="bi bi-calendar-event"></i>
                        </span>
                        <h6 class="card-title px-3">Total Leave Types</h6>
                    </div>    
                    <div class="text-center">
                        <div class="display-6">{{$totalleavetypes}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive" id="allleavetypess">
            <table class="table table-custom table-lg mb-0" id="customers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Days</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leavetypes as $thisleavetype)
                    <tr>
                        <td>
                            <a href="javascript:;">{{$loop->iteration}}</a>
                        </td>
                        <td>{{$thisleavetype->name}}</td>
                        <td>{{$thisleavetype->days}}</td>
                        <td class="text-end">
                            <div class="d-flex">
                                <div class="dropdown ms-auto">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditLeaveTypes" data-bs-id="{{$thisleavetype->id}}" data-bs-name="{{$thisleavetype->name}}" data-bs-days="{{$thisleavetype->days}}">Edit</a>
                                        <a href="javascript:;" class="dropdown-item deleteLeaveType" rel="{{$thisleavetype->id}}">Delete</a>
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

    <!--Edit-->

    <div class="modal fade" id="EditLeaveTypes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditLeaveTypesLabel">Update Leave Types</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateleavetypesform">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">Name:</label>
                                <input type="text" name="name" class="form-control name" />
                                <input type="hidden" name="id" id="id" class="id" />
                                {{@csrf_field()}}
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">Days:</label>
                                <input type="number" name="days" id="days" class="days form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary updateleavetypessubmit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var EditLeaveTypes = document.getElementById('EditLeaveTypes')
        EditLeaveTypes.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var idval = button.getAttribute('data-bs-id')
            var nameval = button.getAttribute('data-bs-name')
            var daysval = button.getAttribute('data-bs-days')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var id = EditLeaveTypes.querySelector('.id')
            var name = EditLeaveTypes.querySelector('.name')
            var days = EditLeaveTypes.querySelector('.days')
            id.value = idval
            name.value = nameval
            days.value = daysval
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#updateleavetypesform').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{route('admin.editLeaveType')}}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    Swal.fire(
                        'Thank You!',
                        'Leave Type has been updated successfully!',
                        'success'
                    )
                    setTimeout(function() {
                            location.reload();
                        }, 2000);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var errors = XMLHttpRequest['responseJSON']['errors'];
                    var response = JSON.parse(XMLHttpRequest.responseText);
                    var errorString = '<ul>';
                    $.each(response.errors, function(key, value) {
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
    <script type="text/javascript">
        $(document).on('click', '.deleteLeaveType', function(e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            Swal.fire({
                title: 'Are you sure you want to delete this leave type?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.deleteLeaveType')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'deleteLeaveType',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Deleted!',
                                'Leave Type has been deleted successfully!',
                                'success'
                            )
                            setTimeout(function() {
                            location.reload();
                        }, 2000);
                        }
                    })
                }
            })
        })
    </script>

    <!--Edit-->

    @endpush
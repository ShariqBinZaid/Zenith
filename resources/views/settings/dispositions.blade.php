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
                <li class="breadcrumb-item active" aria-current="page">Dispositions Types</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Add New Dispositions Types</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('dispositions.addDispositions')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInput">Name</label>
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
                        <h6 class="card-title mb-0">Total Dispositions Types</h6>
                        <div class="dropdown ms-auto">
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$totaldispositionstypes}}</div>
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

    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <form action="{{ route('dispositions.allDispositions') }}" method="GET">
                                    <div class="input-group form-floating" style="border: 0.5px solid #ced4da; border-radius: 9px;">
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

    <div class="table-responsive" id="allDispositionsTypes">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <!-- <th>Created At</th> -->
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dispositionstypes as $thisdispositions)
                <tr>
                    <td><a href="javascript:;">{{$loop->iteration}}</a></td>
                    <td>{{$thisdispositions->name}}</td>
                    <!-- <td>{{$thisdispositions->created_at}}</td> -->
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditDispositionsTypesModal" data-bs-dispositionsid="{{$thisdispositions->id}}" data-bs-dispositionsname="{{$thisdispositions->name}}">Edit</a>
                                    <a href="javascript:;" class="dropdown-item deleteDispositions" rel="{{$thisdispositions->id}}">Delete</a>
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
        {!! $dispositionstypes->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>
</div>
@endsection

@push('scripts')

<!-- Edit -->
<div class="modal fade" id="EditDispositionsTypesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <h5 class="modal-title" id="EditDispositionsTypesModalLabel">Update Dispositions Types</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="updatedispositionsform">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control dispositionsname" id="dispositionsname" name="name">
                        <input type="hidden" name="id" id="dispositionsid" class="dispositionsid" />
                        {{@csrf_field()}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary updatedispositionssubmit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var EditDispositionsTypesModal = document.getElementById('EditDispositionsTypesModal')
    EditDispositionsTypesModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var dispositionsidval = button.getAttribute('data-bs-dispositionsid')
        var dispositionsnameval = button.getAttribute('data-bs-dispositionsname')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.

        // Update the modal's content.
        var dispositionsid = EditDispositionsTypesModal.querySelector('.dispositionsid')
        var dispositionsname = EditDispositionsTypesModal.querySelector('.dispositionsname')

        dispositionsid.value = dispositionsidval
        dispositionsname.value = dispositionsnameval
    })
    $('.updatedispositionssubmit').on('click', function(e) {
        e.preventDefault();
        var form = $('.updatedispositionsform').serialize();
        var formdata = 'updatedispositionsform';
        $.ajax({
            url: "{{route('dispositions.updateDispositions')}}",
            type: 'POST',
            data: form + "&type=" + formdata,
            success: function(res) {
                Swal.fire(
                    'Thank You!',
                    'Dispositions has been updated successfully!',
                    'success'
                )
                $('#allDispositionsTypes').load(document.URL + '#allDispositionsTypes');
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
        })
    })
</script>
<!-- Edit -->


<!-- Delete Disposotions Ajax Start -->

<script type="text/javascript">
    $(document).on('click', '.deleteDispositions', function(e) {
        e.preventDefault();
        var id = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure you want to delete this Dispositions?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('dispositions.deleteDispositions')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        type: 'deleteDispositions',
                        id: id
                    },
                    success: function(res) {
                        Swal.fire(
                            'Deleted!',
                            'Disposotions has been deleted successfully!',
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

<!-- Delete Disposotions Ajax End -->

@endpush
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
                <li class="breadcrumb-item active" aria-current="page">Units</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-bezier me-3"></i>
                        <h6 class="card-title mb-5">Add New Unit</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.addUnit')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInput">Name</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-control select2-example" name="unithead">
                                    <option selected disabled>--Select Unit Head--</option>
                                    @foreach($unitheads as $thisunithead)
                                    <option value="{{$thisunithead->id}}">{{$thisunithead->name}} - ({{$thisunithead->getCompany->name}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <textarea style="height: auto;" class="form-control" id="floatingTextarea2" rows="10" cols="10" name="desc" placeholder="Unit Description"></textarea>
                                <label for="floatingTextarea2">Unit Description</label>
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
                            <i class="bi bi-bezier"></i>
                        </span>
                        <h6 class="card-title px-3">Total Units</h6>
                    </div>    
                    <div class="text-center mt-5">
                        <div class="display-6">{{$units->total()}}</div>
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
                                    <form action="{{ route('admin.allUnits') }}" method="GET">
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

        <div class="table-responsive" id="allUnit">
            <table class="table table-custom table-lg mb-0" id="customers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Unit Head</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $thisunit)
                    <tr>
                        <td>
                            <a href="javascript:;">{{$loop->iteration}}</a>
                        </td>
                        <td>{{$thisunit->name}}</td>
                        <td><a href="javascript:;" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisunit->getCompany->name}}"><img src="{{asset('images/'.$thisunit->getCompany->logo)}}" class="imageintable" /></a></td>
                        <td><a href="{{route('users.editUser',$thisunit->getUnitHead->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisunit->getUnitHead->name}}">
                                <img src="{{asset('images/'.$thisunit->getUnitHead->image)}}" class="rounded-circle" alt="image">
                            </a></td>
                        <td>{{$thisunit->desc}}</td>
                        <td class="text-end">
                            <div class="d-flex">
                                <div class="dropdown ms-auto">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ShowUnitModal" data-bs-unitname="{{$thisunit->name}}" data-bs-company_id="{{$thisunit->company_id}}" data-bs-unithead="{{$thisunit->getUnitHead->name}}" data-bs-unitdesc="{{$thisunit->desc}}">Show</a>
                                        <a href="javascript:;" class="dropdown-item" rel="{{$thisunit->id}}" data-bs-toggle="modal" data-bs-target="#EditUnitModal" data-bs-unitname="{{$thisunit->name}}" data-bs-company_id="{{$thisunit->company_id}}" data-bs-unithead="{{$thisunit->unithead}}" data-bs-id="{{$thisunit->id}}" data-bs-unitdesc="{{$thisunit->desc}}">Edit</a>
                                        <a href="javascript:;" class="dropdown-item deleteUnit" rel="{{$thisunit->id}}">Delete</a>
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
    <!-- Edit -->
    <div class="modal fade" id="EditUnitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditUnitModalLabel">Update Units</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="updateunitform">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="message-text" class="col-form-label">Name:</label>
                                <input type="text" class="form-control unitname" name="name">
                                <input type="hidden" class="unitid" name="id" id="unitid" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="message-text" class="col-form-label">Unit Head:</label>
                                <select class="form-control unithead" name="unithead">
                                    <option selected disabled>--Select Unit Head--</option>
                                    @foreach($unitheads as $thisunithead)
                                    <option value="{{$thisunithead->id}}">{{$thisunithead->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="message-text" class="col-form-label">Description:</label>
                                <textarea class="form-control unitdesc" value="" name="desc"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary updateunitsubmit" value="Submit" />
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        var EditUnitModal = document.getElementById('EditUnitModal')
        EditUnitModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var unitidval = button.getAttribute('data-bs-id')
            var unitnameval = button.getAttribute('data-bs-unitname')
            var unitheadval = button.getAttribute('data-bs-unithead')
            var unitdescval = button.getAttribute('data-bs-unitdesc')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var unitid = EditUnitModal.querySelector('.unitid')
            var unitname = EditUnitModal.querySelector('.unitname')
            var unithead = EditUnitModal.querySelector('.unithead')
            var unitdesc = EditUnitModal.querySelector('.unitdesc')
            unitid.value = unitidval
            unitname.value = unitnameval
            unithead.value = unitheadval
            unitdesc.value = unitdescval
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.updateunitsubmit').on('click', function(e) {
            e.preventDefault();
            var form = $('.updateunitform').serialize();
            var formdata = 'updateunitform';
            $.ajax({
                url: "{{route('admin.updateUnit')}}",
                type: 'POST',
                data: form + "&type=" + formdata,
                success: function(res) {
                    Swal.fire(
                        'Thank You!',
                        'Unit has been updated successfully!',
                        'success'
                    )
                    $('#allUnit').load(document.URL + ' #allUnit');
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

    <!-- Show -->
    <div class="modal fade" id="ShowUnitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="ShowUnitModalLabel">Details of Units</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body showbranddetails">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name:</label><span class="unitname"></span>
                    </div>
                    <!-- <div class="mb-3">
          <label for="message-text" class="col-form-label">Company:</label><span class="unitcompany_id"></span>
        </div> -->
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Unit Head:</label><span class="unithead"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Description:</label><span class="unitdesc"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var ShowUnitModal = document.getElementById('ShowUnitModal')
        ShowUnitModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var unitnameval = button.getAttribute('data-bs-unitname')
            var unitheadval = button.getAttribute('data-bs-unithead')
            var unitdescval = button.getAttribute('data-bs-unitdesc')
            var unitcreated_at = button.getAttribute('data-bs-created_at')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var unitname = ShowUnitModal.querySelector('.unitname')
            var unithead = ShowUnitModal.querySelector('.unithead')
            var unitdesc = ShowUnitModal.querySelector('.unitdesc')
            var created_at = ShowUnitModal.querySelector('.created_at')
            unitname.textContent = unitnameval
            unithead.textContent = unitheadval
            unitdesc.textContent = unitdescval
            created_at.textContent = unitcreated_at
        })
    </script>

    <!-- Show -->


    <!-- Delete Unit Ajax Start -->

    <script type="text/javascript">
        $(document).on('click', '.deleteUnit', function(e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            Swal.fire({
                title: 'Are you sure you want to delete this Unit?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.deleteUnit')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'deleteUnit',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Deleted!',
                                'Unit has been deleted successfully!',
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
    
    <!-- Delete Unit Ajax End -->

    @endpush
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
                <li class="breadcrumb-item active" aria-current="page">Companies</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Add New Company</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.addCompany')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInput">Name</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="file" class="form-control" name="logo" placeholder="Company Logo" aria-label="Company Logo">
                            </div>
                            <div class="col">
                                <select class="form-control select2-example" name="owner">
                                    <option selected disabled>--Select Company Owner-</option>
                                    @foreach($admins as $thisadmin)
                                    <option value="{{$thisadmin->id}}">{{$thisadmin->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <textarea style="height: auto;" name="desc" rows="10" cols="10" class="form-control" id="floatingTextarea2" placeholder="Company Description"></textarea>
                                <label for="floatingTextarea2">Company Description</label>
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
                        <h6 class="card-title mb-0">Total Companies</h6>

                        <div class="text-center mt-5">
                            <div class="display-6">{{$totalcompanies}}</div>
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
                                    <form action="{{ route('admin.allCompanies') }}" method="GET">
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


        <div class="table-responsive" id="allCompanies">
            <table class="table table-custom table-lg mb-0" id="customers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>Company Owner</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $thiscompany)
                    <tr>
                        <td><a href="javascript:;">{{$loop->iteration}}</a></td>
                        <td>{{$thiscompany->name}}</td>
                        <td><a class="image-popup" href="{{asset('images/'.$thiscompany->logo)}}"><img src="{{asset('images/'.$thiscompany->logo)}}" class="imageintable" /></a></td>
                        <td><a href="{{route('users.editUser',$thiscompany->owner)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thiscompany->CompanyOwner->name}}">
                                <img src="{{asset('images/'.$thiscompany->CompanyOwner->image)}}" class="rounded-circle" alt="image">
                            </a></td>

                        <td>{{$thiscompany->desc}}</td>

                        <td class="text-end">
                            <div class="d-flex">
                                <div class="dropdown ms-auto">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ShowCompanyModal" data-bs-companyname="{{$thiscompany->name}}" data-bs-companyowner="{{$thiscompany->CompanyOwner->name}}" data-bs-companydesc="{{$thiscompany->desc}}">Show</a>
                                        <a href="javascript:;" class="dropdown-item" rel="{{$thiscompany->id}}" data-bs-toggle="modal" data-bs-target="#EditCompanyModal" data-bs-id="{{$thiscompany->id}}" data-bs-companyname="{{$thiscompany->name}}" data-bs-companyowner="{{$thiscompany->owner}}" data-bs-companydesc="{{$thiscompany->desc}}">Edit</a>
                                        <a href="javascript:;" class="dropdown-item deleteCompany" rel="{{$thiscompany->id}}">Delete</a>
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
    <div class="modal fade" id="EditCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditCompanyModalLabel">Update Companies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="updatecompanyform">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="message-text" class="col-form-label">Name:</label>
                                <input type="text" class="form-control companyname" name="name">
                                <input type="hidden" class="companyid" name="id" id="companyid" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="message-text" class="col-form-label">Company Owner:</label>
                                <select class="form-control companyowner" name="owner">
                                    <option selected disabled>--Select Company Owner--</option>
                                    @foreach($companies as $thiscompanies)
                                    <option value="{{$thiscompanies->id}}">{{$thiscompany->CompanyOwner->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="message-text" class="col-form-label">Description:</label>
                                <textarea class="form-control companydesc" value="{{$thiscompanies->desc}}" name="desc"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary updatecompanysubmit" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var EditCompanyModal = document.getElementById('EditCompanyModal')
        EditCompanyModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var companyidval = button.getAttribute('data-bs-id')
            var companynameval = button.getAttribute('data-bs-companyname')
            var companyownerval = button.getAttribute('data-bs-companyowner')
            var companydescval = button.getAttribute('data-bs-companydesc')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var companyid = EditCompanyModal.querySelector('.companyid')
            var companyname = EditCompanyModal.querySelector('.companyname')
            var companyowner = EditCompanyModal.querySelector('.companyowner')
            var companydesc = EditCompanyModal.querySelector('.companydesc')
            companyid.value = companyidval
            companyname.value = companynameval
            companyowner.value = companyownerval
            companydesc.value = companydescval
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.updatecompanysubmit').on('click', function(e) {
            e.preventDefault();
            var form = $('.updatecompanyform').serialize();
            var formdata = 'updatecompanyform';
            $.ajax({
                url: "{{route('admin.updateCompany')}}",
                type: 'POST',
                data: form + "&type=" + formdata,
                success: function(res) {
                    Swal.fire(
                        'Thank You!',
                        'Company has been updated successfully!',
                        'success'
                    )
                    $('#allCompanies').load(document.URL + ' #allCompanies');
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
    <div class="modal fade" id="ShowCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ShowCompanyModalLabel">Details of Companies</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body showbranddetails">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name:</label><span class="companyname"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Company Owner:</label><span class="companyowner"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Description:</label><span class="companydesc"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var ShowCompanyModal = document.getElementById('ShowCompanyModal')
        ShowCompanyModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            // var companyidval = button.getAttribute('data-bs-id')
            var companynameval = button.getAttribute('data-bs-companyname')
            var companyownerval = button.getAttribute('data-bs-companyowner')
            var companydescval = button.getAttribute('data-bs-companydesc')
            var companycreated_at = button.getAttribute('data-bs-created_at')

            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            // var companyid = ShowCompanyModal.querySelector('.companyid')
            var companyname = ShowCompanyModal.querySelector('.companyname')
            var companyowner = ShowCompanyModal.querySelector('.companyowner')
            var companydesc = ShowCompanyModal.querySelector('.companydesc')
            var created_at = ShowUnitModal.querySelector('.created_at')
            // companyid.textContent = companyidval 
            companyname.textContent = companynameval
            companyowner.textContent = companyownerval
            companydesc.textContent = companydescval
        })
    </script>


    <!-- Show -->


    <!-- Delete Company Ajax Start -->

    <script type="text/javascript">
        $(document).on('click', '.deleteCompany', function(e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            Swal.fire({
                title: 'Are you sure you want to delete this Company?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.deleteCompany')}}",
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
                                'Company has been deleted successfully!',
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

    <!-- Delete Company Ajax End -->

    @endpush
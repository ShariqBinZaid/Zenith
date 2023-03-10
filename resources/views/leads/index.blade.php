@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('lead.allLeads')}}">
                        <i class="bi bi-globe2 small me-2"></i> Sales Force
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Leads</li>
            </ol>
        </nav>
    </div>
    @can('add leads')
    <div class="row g-4 mb-4">


        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Add New Lead</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('lead.addLead')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                            </div>
                            <div class="col">
                                <input type="text" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email" aria-label="Email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" value="{{ old('phone') }}" class="form-control" name="phone" placeholder="Phone" aria-label="Phone">
                            </div>
                            <div class="col">
                                <select class="form-select" name="brand_id">
                                    <option selected disabled>Choose the Brand...</option>
                                    @foreach($allbrands as $thisbrand)
                                    <option value="{{$thisbrand->id}}">{{$thisbrand->name}}</option>
                                    @endforeach
                                </select>
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
                        <h6 class="card-title mb-0">Total Leads</h6>
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
                        <div class="display-6">{{$leads->total()}}</div>
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
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                        <!-- <div class="row g-3">
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
                            </div> -->
                        <div class="col-md-12">
                            <form action="{{ route('lead.allLeads') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $search ?? '' }}">
                                    <button class="btn btn-outline-light" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
            <!-- <div class="dropdown ms-auto">
                    <a href="#" data-bs-toggle="dropdown"
                       class="btn btn-primary dropdown-toggle"
                       aria-haspopup="true" aria-expanded="false">Actions</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">Action</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item">Something else here</a>
                    </div>
                </div> -->
        </div>
    </div>
</div>
<div class="table-responsive" id="allleads">
    <table class="table table-custom table-lg mb-0" id="customers">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Fullname</th>
                <th>Brand</th>
                <th>Assigned to</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leads as $thislead)
            <tr>
                <td>
                    <a href="javascript:;">{{$loop->iteration}}</a>
                </td>
                @php
                $explodedname = explode(' ',$thislead->name);
                $initial = $explodedname[0][0];
                @endphp
                <td>
                    <div class="avatar avatar-info">
                        <span class="avatar-text rounded-circle">{{$initial}}</span>
                    </div>
                </td>
                <td>{{$thislead->name}}</td>
                <td><a href="{{route('brands.theBrandDesc',$thislead->brand_id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thislead->getBrand->name}}">
                        <img src="{{asset('images/'.$thislead->getBrand->image)}}" class="rounded" alt="image">
                    </a></td>

                <td>
                    <div class="avatar-group me-2">
                        @foreach($thislead->users()->get() as $thisuser)
                        <a href="{{route('users.editUser',$thisuser->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisuser->name}}">
                            <img src="{{asset('images/'.$thisuser->image)}}" class="rounded-circle" alt="image">
                        </a>
                        @endforeach
                    </div>
                </td>
                <td class="text-end">
                    <div class="d-flex">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ShowLeadModal" data-bs-leadid="{{$thislead->id}}" data-bs-leadphone="{{$thislead->phone}}" data-bs-leadusername="{{$thislead->name}}" data-bs-email="{{$thislead->email}}" data-bs-brand_id="{{$thislead->getBrand->name}}" data-bs-url="{{$thislead->url}}" data-bs-created_at="{{$thislead->created_at}}">Show</a>
                                @can('update leads')
                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditLeadModal" data-bs-leadid="{{$thislead->id}}" data-bs-leadphone="{{$thislead->phone}}" data-bs-leadusername="{{$thislead->name}}" data-bs-email="{{$thislead->email}}" data-bs-brand_id="{{$thislead->brand_id}}">Edit</a>
                                @endcan
                                @can('delete leads')
                                <a href="javascript:;" class="dropdown-item deleteLead" rel="{{$thislead->id}}">Delete</a>
                                @endcan
                                @can('assign leads')
                                <a href="{{route('lead.assignLead',$thislead->id)}}" class="dropdown-item">Assign Leads</a>
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

    {!! $leads->withQueryString()->links('pagination::bootstrap-5') !!}
</nav>

</div>
@endsection
@push('scripts')
<div class="modal fade" id="EditLeadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditLeadModalLabel">Update Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="updateleadform">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Username:</label>
                        <input type="text" class="form-control leadusername" id="leadusername" name="name">
                        <input type="hidden" name="id" id="leadid" class="leadid" />
                        {{@csrf_field()}}
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Email:</label>
                        <input type="text" class="form-control leademail" id="leademail" name="email" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Phone:</label>
                        <input type="text" class="form-control leadphone" id="leadphone" name="phone" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Brand:</label>
                        <select class="form-control brand_id" name="brand_id" id="brand_id">
                            @foreach($allbrands as $thisbrand)
                            <option value="{{$thisbrand->id}}">{{$thisbrand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary updateleadsubmit">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    var EditLeadModal = document.getElementById('EditLeadModal')
    EditLeadModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var leadidval = button.getAttribute('data-bs-leadid')
        var leademailval = button.getAttribute('data-bs-email')
        var leadusernameval = button.getAttribute('data-bs-leadusername')
        var brand_idval = button.getAttribute('data-bs-brand_id')
        var leadphoneval = button.getAttribute('data-bs-leadphone')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var leademail = EditLeadModal.querySelector('.leademail')
        var leadid = EditLeadModal.querySelector('.leadid')
        var leadusername = EditLeadModal.querySelector('.leadusername')
        var brand_id = EditLeadModal.querySelector('.brand_id')
        var leadphone = EditLeadModal.querySelector('.leadphone')

        leademail.value = leademailval
        leadid.value = leadidval
        leadusername.value = leadusernameval
        brand_id.value = brand_idval
        leadphone.value = leadphoneval
    })
    $('.updateleadsubmit').on('click', function(e) {
        e.preventDefault();
        var form = $('.updateleadform').serialize();
        var formdata = 'updateleadform';
        $.ajax({
            url: "{{route('lead.updatelead')}}",
            type: 'POST',
            data: form + "&type=" + formdata,
            success: function(res) {
                Swal.fire(
                    'Thank You!',
                    'Lead has been updated successfully!',
                    'success'
                )
                $('#allleads').load(document.URL + ' #allleads');
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
@endpush
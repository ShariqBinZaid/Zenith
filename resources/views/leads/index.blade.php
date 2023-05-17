@extends('layouts.app')

@section('content')
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
                    <div class="d-flex">
                            <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-telephone-inbound me-3"></i>
                        <h6 class="card-title mb-5">Add New Lead</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('lead.addLead')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInput">Name</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('email') }}" name="email" class="form-control" id="floatingInput" placeholder="Email" aria-label="Email">
                                <label for="floatingInput">Email</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="tel" value="{{ old('phone') }}" class="form-control" id="floatingInput" name="phone" placeholder="Phone" aria-label="Phone">
                                <label for="floatingInput">Phone</label>
                            </div>
                            <div class="col">
                                <select class="form-select select2-example" name="brand_id">
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
                    <div class="d-flex mb-4 masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-telephone-inbound"></i>
                        </span>
                        <h6 class="card-title mb-0">Total Leads</h6>
                        <!--<div class="dropdown ms-auto">-->
                        <!--    <div class="dropdown-menu dropdown-menu-end">-->
                        <!--        <a href="#" class="dropdown-item">Download</a>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$leads->total()}}</div>
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
                                <div class="input-group form-floating" style="border: 0.5px solid #ced4da; border-radius: 9px;">
                                    <input style="background: transparent;"type="text" class="form-control" id="floatingInputInvalid" placeholder="Search" name="search" value="{{ $search ?? '' }}">
                                    <label for="floatingInputInvalid">Search</label>
                                    <button class="btn btn-outline-light" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </form>
                </div>
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
                <th>Your Latest Disposition</th>
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
                        <img src="{{asset('images/'.$thislead->getBrand->image)}}" class="rounded w-auto" alt="image">
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
                <td>
                    <div class="avatar-group me-2">
                        @if(count($thislead->my_latest_disposition) == 0)
                            <b class="blink">Pending</b>
                        @else
                            @foreach($thislead->my_latest_disposition as $thisdisposition)
                                <span><b>{{$thisdisposition->disposition_details->name}}</b> : {{$thisdisposition->feedback}}</span>
                            @endforeach
                        @endif

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
                                @can('convert leads')
                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ConvertProjectModal" data-bs-leadid="{{$thislead->id}}">Convert Into Project</a>
                                @endcan
                                @can('update leads')
                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditLeadModal" data-bs-leadid="{{$thislead->id}}" data-bs-leadphone="{{$thislead->phone}}" data-bs-leadusername="{{$thislead->name}}" data-bs-email="{{$thislead->email}}" data-bs-brand_id="{{$thislead->brand_id}}">Edit</a>
                                @endcan
                                @can('add disposition')
                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ShowDispositionModal" data-bs-leadid="{{$thislead->id}}" data-bs-disname="{{$thislead->name}}" data-bs-disfeedback="{{$thislead->feedback}}">Add Dispositions</a>
                                @endcan
                                @can('view dispositions')
                                <a href="{{route('lead.dispositions',$thislead->id)}}" class="dropdown-item">View Dispositions</a>
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
@endsection
@push('scripts')


<!-- Add Dispositions -->
<div class="modal fade" id="ShowDispositionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content dropzone">
      <div class="modal-header">
        <h5 class="modal-title" id="ShowDispositionModalLabel">Details of Dispositions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
          <form action="{{route('lead.addDisposition')}}" method="POST">
            <div class="modal-body showleaddetails">
                <div class="mb-3">
                    
                </div>
                <div class="mb-3">
                    <div class="col">
                        <input type="hidden" name="lead_id" class="lead_id"/>
                        {{csrf_field()}}
                        <select class="form-select select2-example" name="disposition_id">
                            <option selected disabled>Choose the Dispositions...</option>
                                @foreach($dispositions as $thisdisposition)
                                    <option value="{{$thisdisposition->id}}">{{$thisdisposition->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col form-floating">
                        <textarea style="height: auto;" name="feedback" class="form-control" placeholder="Feedback" id="floatingTextarea" cols="10" rows="10"></textarea>
                        <label for="floatingTextarea">Feedback</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var ShowDispositionModal = document.getElementById('ShowDispositionModal')
  ShowDispositionModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var leadid = button.getAttribute('data-bs-leadid')
    
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var lead_id = ShowDispositionModal.querySelector('.lead_id')
    
    lead_id.value = leadid
  })
</script>
<!-- Add Dispositions -->


<!-- Show -->
<div class="modal fade" id="ShowLeadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content dropzone">
      <div class="modal-header">
        <h5 class="modal-title" id="ShowLeadModalLabel">Details of this Lead</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body showleaddetails">
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Username:</label><span class="leadusername"></span>
        </div>
        <div class="mb-3">
          <label for="message-text" class="col-form-label">Email:</label><span class="leademail"></span>
        </div>
        <div class="mb-3">
          <label for="message-text" class="col-form-label">Phone:</label><span class="leadphone"></span>
        </div>
        <div class="mb-3">
          <label for="message-text" class="col-form-label">Brand:</label><span class="brand_id"></span>
        </div>
        <div class="mb-3">
          <label for="message-text" class="col-form-label">URL:</label><span class="url"></span>
        </div>
        <div class="mb-3">
          <label for="message-text" class="col-form-label">Created at:</label><span class="created_at"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var ShowLeadModal = document.getElementById('ShowLeadModal')
  ShowLeadModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var leademailval = button.getAttribute('data-bs-email')
    var leadusernameval = button.getAttribute('data-bs-leadusername')
    var brand_idval = button.getAttribute('data-bs-brand_id')
    var leadphoneval = button.getAttribute('data-bs-leadphone')
    var leadurl = button.getAttribute('data-bs-url')
    var leadcreated_at = button.getAttribute('data-bs-created_at')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var leademail = ShowLeadModal.querySelector('.leademail')
    var leadusername = ShowLeadModal.querySelector('.leadusername')
    var brand_id = ShowLeadModal.querySelector('.brand_id')
    var leadphone = ShowLeadModal.querySelector('.leadphone')
    var url = ShowLeadModal.querySelector('.url')
    var created_at = ShowLeadModal.querySelector('.created_at')
    leademail.textContent = leademailval
    leadusername.textContent = leadusernameval
    brand_id.textContent = brand_idval
    leadphone.textContent = leadphoneval
    url.textContent = leadurl
    created_at.textContent = leadcreated_at
  })
</script>
<!-- Show -->


<!-- Edit -->
<div class="modal fade" id="EditLeadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
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
<!-- Edit -->



<!-- Delete Lead Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deleteLead',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this Lead?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('lead.deleteLead')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteLead',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Lead has been deleted successfully!',
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
<!-- Delete Lead Ajax End -->
@endpush
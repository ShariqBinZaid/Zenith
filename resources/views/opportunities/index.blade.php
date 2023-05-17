@extends('layouts.app')

@section('content')
<div class="content ">
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('adminDashboard')}}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{route('opportunity.allOpportunities')}}">Opportunities</a>
                </li>
            </ol>
        </nav>
    </div>
    @can('add opportunities')
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                            <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-briefcase me-3"></i>
                        <h6 class="card-title mb-5">Add New Opportunity</h6>
                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST"
                        action="{{route('opportunity.addOpportunity')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput"
                                    name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInput">Name</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('email') }}" name="email" class="form-control"
                                    id="floatingInput" placeholder="Email" aria-label="Email">
                                <label for="floatingInput">Email</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('phone') }}" class="form-control" id="floatingInput"
                                    name="phone" placeholder="Phone" aria-label="Phone">
                                <label for="floatingInput">Phone</label>
                            </div>
                            
                            <div class="col">
                                <select class="form-select select2-example" name="package_id">
                                    <option selected disabled>Choose the Package...</option>
                                    @foreach($brandspackages as $brand)
                                    <optgroup label="{{ $brand->name }}">
                                        @foreach($brand->packages as $thepackage)
                                        <option value="{{ $thepackage->id }}">{{ $thepackage->name }} ({{
                                            $thepackage->getCurrency->symbol.$thepackage->price }})</option>
                                        @endforeach
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
                            <i class="bi bi-briefcase"></i>
                        </span>
                        <h6 class="card-title mb-0">Total Opportunities</h6>
                        <!--<div class="dropdown ms-auto">-->
                        <!--    <div class="dropdown-menu dropdown-menu-end">-->
                        <!--        <a href="#" class="dropdown-item">View Detail</a>-->
                        <!--        <a href="#" class="dropdown-item">Download</a>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$opportunities->total()}}</div>
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
                            <i class="bi bi-download"></i> Download Report
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
                        <div class="row g-3">
                            <div class="col-md-12">
                                <form action="{{ route('opportunity.allOpportunities') }}" method="GET">
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

    <div class="table-responsive">
        <table class="table table-custom table-lg mb-0" id="allOpportunity">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Fullname</th>
                    <th>Brand</th>
                    <th>Package</th>
                    <th>Assigned to</th>
                    <th>Your Latest Disposition</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($opportunities as $thisopportunity)
                <tr>
                    <td>
                        <a href="javascript:;">{{$loop->iteration}}</a>
                    </td>
                    @php
                    $explodedname = explode(' ',$thisopportunity->name);
                    $initial = $explodedname[0][0];
                    @endphp
                    <td>
                        <div class="avatar avatar-info">
                            <span class="avatar-text rounded-circle">{{$initial}}</span>
                        </div>
                    </td>
                    <td>{{$thisopportunity->name}}</td>
                    <td><a href="javascript:;" class="avatar custom-avatar" data-bs-toggle="tooltip" title=""
                            data-bs-original-title="{{$thisopportunity->getBrand->name}}">
                            <img src="{{asset('images/'.$thisopportunity->getBrand->image)}}" class="rounded"
                                alt="image">
                        </a></td>
                    <td>{{$thisopportunity->getpackage->name}}</td>
                    <td>
                        <div class="avatar-group me-2">
                            @foreach($thisopportunity->users()->get() as $thisuser)
                            <a href="{{route('users.editUser',$thisuser->id)}}" class="avatar" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="{{$thisuser->name}}">
                                <img src="{{asset('images/'.$thisuser->image)}}" class="rounded-circle" alt="image">
                            </a>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="avatar-group me-2">
                            @if(count($thisopportunity->my_latest_disposition) == 0)
                            <b class="blink">Pending</b>
                            @else
                                @foreach($thisopportunity->my_latest_disposition as $thisdisposition)
                                    <span><b>{{$thisdisposition->disposition_details->name}}</b> : {{$thisdisposition->feedback}}</span>
                                @endforeach
                            @endif
                        </div>
                    </td>
                </td> 
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('assign opportunities')
                                    <a href="{{route('opportunity.assignOpportunity',$thisopportunity->id)}}"
                                        class="dropdown-item">Assign Opportunity</a>
                                    @endcan
                                    @can('convert opportunity to project')
                                    <a href="{{route('projects.opportunity_to_project',$thisopportunity->id)}}"
                                        class="dropdown-item">Convert into Project</a>
                                    @endcan
                                    <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#ShowOpportunityModal"
                                        data-bs-opportunityid="{{$thisopportunity->id}}"
                                        data-bs-opportunityphone="{{$thisopportunity->phone}}"
                                        data-bs-opportunityusername="{{$thisopportunity->name}}"
                                        data-bs-email="{{$thisopportunity->email}}"
                                        data-bs-brand_id="{{$thisopportunity->getbrand->name}}"
                                        data-bs-package_id="{{$thisopportunity->getpackage->name}}"
                                        data-bs-url="{{$thisopportunity->url}}"
                                        data-bs-created_at="{{$thisopportunity->created_at}}">Show</a>
                                    @can('edit opportunities')
                                    <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#EditOpportunityModal"
                                        data-bs-opportunityid="{{$thisopportunity->id}}"
                                        data-bs-opportunityphone="{{$thisopportunity->phone}}"
                                        data-bs-opportunityusername="{{$thisopportunity->name}}"
                                        data-bs-email="{{$thisopportunity->email}}"
                                        data-bs-brand_id="{{$thisopportunity->brand_id}}"
                                        data-bs-package_id="{{$thisopportunity->package_id}}">Edit</a>
                                    @endcan
                                    @can('add disposition')
                                    <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ShowDispositionModal" data-bs-opportunity_id="{{$thisopportunity->id}}">Add Dispositions</a>
                                    @endcan
                                    @can('view dispositions')
                                    <a href="{{route('opportunity.oppdispositions',['id'=>$thisopportunity->id])}}" class="dropdown-item">View Dispositions</a>
                                    @endcan
                                    @can('delete opportunities')
                                    <a href="javascript:;" class="dropdown-item deleteOpportunity"
                                        rel="{{$thisopportunity->id}}">Delete</a>
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
        {!! $opportunities->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>

</div>
@endsection
@push('scripts')
<div class="modal fade" id="ShowDispositionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content dropzone">
      <div class="modal-header">
        <h5 class="modal-title" id="ShowDispositionModalLabel">Details of Dispositions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
          <form action="{{route('opportunity.addDisposition')}}" method="POST">
            <div class="modal-body showleaddetails">
                <div class="mb-3">
                    
                </div>
                <div class="mb-3">
                    <div class="col">
                        <input type="hidden" name="opportunity_id" class="opportunity_id"/>
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
    var opportunity_id = button.getAttribute('data-bs-opportunity_id')
    
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var opportunityid = ShowDispositionModal.querySelector('.opportunity_id')
    
    opportunityid.value = opportunity_id
  })
</script>
<!-- Add Dispositions -->
<!-- Edit Opportunity Modal Start -->
<div class="modal fade" id="EditOpportunityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <h5 class="modal-title" id="EditOpportunityModalLabel">Update Opportunity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="updateOpportunityform">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Username:</label>
                        <input type="text" class="form-control opportunityusername" id="opportunityusername"
                            name="name">
                        <input type="hidden" name="id" id="opportunityid" class="opportunityid" />
                        {{@csrf_field()}}
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Email:</label>
                        <input type="text" class="form-control opportunityemail" id="opportunityemail" name="email"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Phone:</label>
                        <input type="text" class="form-control opportunityphone" id="opportunityphone" name="phone"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Package:</label>
                        <select class="form-control brand_id" name="package_id" id="package_id">
                            <option seelcted disabled>--Select Brand--</option>
                            @foreach($brandspackages as $brand)
                            <optgroup label="{{ $brand->name }}">
                                @foreach($brand->packages as $thepackage)
                                <option value="{{ $thepackage->id }}">{{ $thepackage->name }} ({{
                                    $thepackage->getCurrency->symbol.$thepackage->price }})</option>
                                @endforeach
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary updateOpportunitysubmit">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    var EditOpportunityModal = document.getElementById('EditOpportunityModal')
    EditOpportunityModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var opportunityidval = button.getAttribute('data-bs-opportunityid')
        var opportunityemailval = button.getAttribute('data-bs-email')
        var opportunityusernameval = button.getAttribute('data-bs-opportunityusername')
        var brand_idval = button.getAttribute('data-bs-brand_id')
        var package_idval = button.getAttribute('data-bs-package_id')
        var opportunityphoneval = button.getAttribute('data-bs-opportunityphone')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var opportunityemail = EditOpportunityModal.querySelector('.opportunityemail')
        var opportunityid = EditOpportunityModal.querySelector('.opportunityid')
        var opportunityusername = EditOpportunityModal.querySelector('.opportunityusername')
        var brand_id = EditOpportunityModal.querySelector('.brand_id')
        var package_id = EditOpportunityModal.querySelector('.package_id')
        var opportunityphone = EditOpportunityModal.querySelector('.opportunityphone')

        opportunityemail.value = opportunityemailval
        opportunityid.value = opportunityidval
        opportunityusername.value = opportunityusernameval
        brand_id.value = brand_idval
        opportunityphone.value = opportunityphoneval
    })
    $('.updateOpportunitysubmit').on('click', function (e) {
        e.preventDefault();
        var form = $('.updateOpportunityform').serialize();
        var formdata = 'updateOpportunityform';
        $.ajax({
            url: "{{route('opportunity.updateOpportunity')}}",
            type: 'POST',
            data: form + "&type=" + formdata,
            success: function (res) {
                Swal.fire(
                    'Thank You!',
                    'Opportunity has been updated successfully!',
                    'success'
                )
                $('#allOpportunity').load(document.URL + ' #allOpportunity');
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
        })
    })

</script>
<!-- Edit Opportunity Modal End -->

<!-- Show Opportunity Modal Start -->
<div class="modal fade" id="ShowOpportunityModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <h5 class="modal-title" id="ShowOpportunityModalLabel">Details of this Opportunity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body showopportunitydetails">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Username:</label><span
                        class="opportunityusername"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Email:</label><span
                        class="opportunityemail"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Phone:</label><span
                        class="opportunityphone"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Brand:</label><span class="brand_id"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Package:</label><span class="package_id"></span>
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
    var ShowOpportunityModal = document.getElementById('ShowOpportunityModal')
    ShowOpportunityModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var opportunityemailval = button.getAttribute('data-bs-email')
        var opportunityusernameval = button.getAttribute('data-bs-opportunityusername')
        var brand_idval = button.getAttribute('data-bs-brand_id')
        var package_idval = button.getAttribute('data-bs-package_id')
        var opportunityphoneval = button.getAttribute('data-bs-opportunityphone')
        var opportunityurl = button.getAttribute('data-bs-url')
        var opportunitycreated_at = button.getAttribute('data-bs-created_at')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var opportunityemail = ShowOpportunityModal.querySelector('.opportunityemail')
        var opportunityusername = ShowOpportunityModal.querySelector('.opportunityusername')
        var brand_id = ShowOpportunityModal.querySelector('.brand_id')
        var package_id = ShowOpportunityModal.querySelector('.package_id')
        var opportunityphone = ShowOpportunityModal.querySelector('.opportunityphone')
        var url = ShowOpportunityModal.querySelector('.url')
        var created_at = ShowOpportunityModal.querySelector('.created_at')
        opportunityemail.textContent = opportunityemailval
        opportunityusername.textContent = opportunityusernameval
        brand_id.textContent = brand_idval
        package_id.textContent = package_idval
        opportunityphone.textContent = opportunityphoneval
        url.textContent = opportunityurl
        created_at.textContent = opportunitycreated_at
    })
</script>
<!-- Show Opportunity Modal End -->

<!-- Delete Opportunity Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deleteOpportunity',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this Opportunity?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('opportunity.deleteOpportunity')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteOpportunity',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Opportunity has been deleted successfully!',
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
<!-- Delete Opportunity Ajax End -->

@endpush
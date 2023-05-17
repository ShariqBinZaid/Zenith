@extends('layouts.app')

@section('content')
<div class="content ">

  <div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">
            <i class="bi bi-globe2 small me-2"></i> Marketing
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Brands</li>
      </ol>
    </nav>
  </div>
  @can('add brands')
  <div class="row g-4 mb-4">
    <div class="col-md-8">
      <div class="card h-100">
        <div class="card-body">
            <div class="d-flex">
                <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-building me-3"></i>
                <h6 class="card-title mb-5">Add New Brand</h6>
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
          <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('brands.addBrand')}}"
            enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row mb-3">
              <div class="col form-floating">
                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name"
                  placeholder="Name" aria-label="Name">
                <label for="floatingInput">Name</label>
              </div>
              <div class="col form-floating">
                <input type="text" value="{{ old('url') }}" name="url" class="form-control" id="floatingInput"
                  placeholder="URL" aria-label="URL">
                <label for="floatingInput">URL</label>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col form-floating">
                <input type="text" value="{{ old('initials') }}" class="form-control" id="floatingInput" name="initials"
                  placeholder="Initials" aria-label="Initials">
                <label for="floatingInput">Initials</label>
              </div>
              <div class="col">
                <input type="file" value="{{ old('image') }}" class="form-control" name="image" placeholder="Logo"
                  aria-label="Logo">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col">
                <select class="form-select select2-example" name="unit_id">
                  <option selected disabled>Choose the Unit...</option>
                  @foreach($units as $thisunit)
                  <option value="{{$thisunit->id}}">{{$thisunit->name}} ({{$thisunit->getCompany->name}})</option>
                  @endforeach
                </select>
              </div>
              <div class="col">
                <select class="form-select select2-example" name="type">
                  <option selected disabled>Choose the Brand Type...</option>
                  <option value="Design">Design</option>
                  <option value="E-Book">E-Book</option>
                  <option value="Mobile Apps">Mobile Apps</option>
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
                    <i class="bi bi-building"></i>
                </span>
            <h6 class="card-title mb-0">Total Brands</h6>
            <!--<div class="dropdown ms-auto">-->
            <!--  <div class="dropdown-menu dropdown-menu-end">-->
            <!--    <a href="#" class="dropdown-item">Download</a>-->
            <!--  </div>-->
            <!--</div>-->
          </div>
          <div class="text-center">
            <div class="display-6">{{$brands->total()}}</div>
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
            <div class="row g-3">
              <div class="col-md-12">
                <form action="{{ route('brands.allBrands') }}" method="GET">
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
  <div class="table-responsive" id="allBrands">
    <table class="table table-custom table-lg mb-0" id="customers">
      <thead>
        <tr>
          <th>ID</th>
          <th>Logo</th>
          <th>Name</th>
          <th>Type</th>
          <th>URL</th>
          <th>Initials</th>
          <th>Assigned To</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($brands as $thisbrand)
        <tr>
          <td>
            <a href="javascript:;">{{$loop->iteration}}</a>
          </td>
          <td><a class="image-popup" href="{{asset('images/'.$thisbrand->image)}}"><img
                src="{{asset('images/'.$thisbrand->image)}}" class="imageintable" /></a></td>
          <td><a href="{{route('brands.theBrandDesc',$thisbrand->id)}}">{{$thisbrand->name}}</a></td>
          <td>{{$thisbrand->type}}</td>
          <td><a href="{{$thisbrand->url}}" target="_blank"><span class="badge bg-success">{{$thisbrand->url}}</span></a></td>
          <td>{{$thisbrand->initials}}</td>
          <td>{{$thisbrand->getUnit->name}}</td>
          <td class="text-end">
            <div class="d-flex">
              <div class="dropdown ms-auto">
                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true"
                  aria-expanded="false">
                  <i class="bi bi-three-dots"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a href="{{route('brands.theBrandDesc',$thisbrand->id)}}" class="dropdown-item">Show</a>
                  <a href="{{route('brands.Packages',$thisbrand->id)}}" class="dropdown-item">Packages</a>
                  @can('update brands')
                  <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditbrandModal"
                    data-bs-id="{{$thisbrand->id}}" data-bs-name="{{$thisbrand->name}}"
                    data-bs-image="{{asset('images/'.$thisbrand->image)}}" data-bs-type="{{$thisbrand->type}}"
                    data-bs-url="{{$thisbrand->url}}" data-bs-initials="{{$thisbrand->initials}}"
                    data-bs-oldimagelink="{{$thisbrand->image}}">Edit</a>
                  @endcan
                  @can('delete brands')
                  <a href="javascript:;" class="dropdown-item deleteBrand" rel="{{$thisbrand->id}}">Delete</a>
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

    {!! $brands->withQueryString()->links('pagination::bootstrap-5') !!}
  </nav>

</div>
@endsection


@push('scripts')

<!-- Edit -->
<div class="modal fade" id="EditbrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content dropzone">
      <div class="modal-header">
        <h5 class="modal-title" id="EditbrandModalLabel">Update Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updatebrandform" enctype="multipart/form-data" action="{{route('brands.updateBrand')}}" method="POST">
        <div class="modal-body">
          <img src="" class="brandimage">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="recipient-name" class="col-form-label">Brand Name:</label>
              <input type="text" class="form-control brandname" id="brandname" name="name">
              <input type="hidden" name="id" id="brandid" class="brandid" />
              <input type="hidden" name="oldlinkimage" id="oldlinkimage" class="oldlinkimage" />

              {{@csrf_field()}}
            </div>

            <div class="mb-3 col-md-6">
              <label for="message-text" class="col-form-label">Brand Type:</label>
              <select class="form-control brandtype" name="type" id="brandtype">
                <option selected disabled>Choose the Brand Type...</option>
                <option value="Design">Design</option>
                <option value="E-Book">E-Book</option>
                <option value="Mobile Apps">Mobile Apps</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="message-text" class="col-form-label">Brand URL:</label>
              <input type="text" class="form-control brandurl" id="brandurl" name="url">
            </div>
            <div class="mb-3 col-md-6">
              <label for="message-text" class="col-form-label">Brand Initials:</label>
              <input type="text" class="form-control brandinitials" id="brandinitials" name="initials">
            </div>
          </div>
          <div class="mb-3 ">
            <label for="message-text" class="col-form-label">Brand Image:</label>
            <input type="file" class="form-control" id="brandimage" name="image">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary updatebrandsubmit">Update</button>
        </div>

      </form>
    </div>
  </div>
</div>
<script>
  var EditbrandModal = document.getElementById('EditbrandModal')
  EditbrandModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var brandidval = button.getAttribute('data-bs-id')
    var brandnameval = button.getAttribute('data-bs-name')
    var brandimageval = button.getAttribute('data-bs-image')
    var brandurlval = button.getAttribute('data-bs-url')
    var initialsval = button.getAttribute('data-bs-initials')
    var brandtypeval = button.getAttribute('data-bs-type')
    var oldimagelinkval = button.getAttribute('data-bs-oldimagelink')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var brandid = EditbrandModal.querySelector('.brandid')
    var brandname = EditbrandModal.querySelector('.brandname')
    var brandimage = EditbrandModal.querySelector('.brandimage')
    var brandurl = EditbrandModal.querySelector('.brandurl')
    var brandinitials = EditbrandModal.querySelector('.brandinitials')
    var brandtype = EditbrandModal.querySelector('.brandtype')
    var oldlinkimage = EditbrandModal.querySelector('.oldlinkimage')

    brandid.value = brandidval
    brandname.value = brandnameval
    brandimage.src = brandimageval
    oldlinkimage.value = oldimagelinkval
    brandurl.value = brandurlval
    brandinitials.value = initialsval
    brandtype.value = brandtypeval
  })

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#updatebrandform').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);


    $.ajax({
      type: 'POST',
      url: "{{route('brands.updateBrand')}}",
      data: formData,
      contentType: false,
      processData: false,
      success: (response) => {
        Swal.fire(
          'Thank You!',
          'Brand has been updated successfully!',
          'success'
        )
        $('#allBrands').load(document.URL + ' #allBrands');
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
<!-- Edit-->

<!-- Show-->
<div class="modal fade" id="ShowbrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content dropzone">
      <div class="modal-header">
        <h5 class="modal-title" id="ShowbrandModalLabel">Details of this Brand</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body showbranddetails">
        <div class="mb-3">
          <image class="brandimage" />
        </div>
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Name:</label><span class="brandname"></span>
        </div>
        <div class="mb-3">
          <label for="message-text" class="col-form-label">URL:</label><span class="brandurl"></span>
        </div>
        <div class="mb-3">
          <label for="message-text" class="col-form-label">Type:</label><span class="brandtype"></span>
        </div>
        <div class="mb-3">
          <label for="message-text" class="col-form-label">Initials:</label><span class="brandinitials"></span>
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
  var ShowbrandModal = document.getElementById('ShowbrandModal')
  ShowbrandModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var brandnameval = button.getAttribute('data-bs-name')
    var brandtypeval = button.getAttribute('data-bs-type')
    var brandurlval = button.getAttribute('data-bs-url')
    var brandinitialsval = button.getAttribute('data-bs-initials')
    var brandimageval = button.getAttribute('data-bs-image')
    var brandcreated_at = button.getAttribute('data-bs-created_at')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var brandname = ShowbrandModal.querySelector('.brandname')
    var brandurl = ShowbrandModal.querySelector('.brandurl')
    var brandimage = ShowbrandModal.querySelector('.brandimage')
    var brandinitials = ShowbrandModal.querySelector('.brandinitials')
    var brandtype = ShowbrandModal.querySelector('.brandtype')
    var created_at = ShowbrandModal.querySelector('.created_at')
    brandname.textContent = brandnameval
    brandtype.textContent = brandtypeval
    brandurl.textContent = brandurlval
    brandinitials.textContent = brandinitialsval
    brandimage.src = brandimageval
    created_at.textContent = brandcreated_at
  })
</script>
<!-- Show-->

<!-- Delete Brand Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deleteBrand',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this Brand?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('brands.deleteBrand')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteBrand',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Brand has been deleted successfully!',
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
<!-- Delete Brand Ajax End -->


@endpush
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
        <li class="breadcrumb-item active" aria-current="page">Roles</li>
      </ol>
    </nav>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-md-8">
      <div class="card h-100">
        <div class="card-body">
            <div class="d-flex">
                <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-vinyl me-3"></i>
                <h6 class="card-title mb-5">Add New Role</h6>
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
          <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.addRole')}}">
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
          <div class="d-flex mb-4 masthead-followup-icon">
            <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
              <i class="bi bi-vinyl"></i>
            </span>
            <h6 class="card-title px-3">Total Roles</h6>
          </div>
          <div class="text-center ">
            <div class="display-6">{{$totalroles}}</div>
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
                <form action="{{ route('admin.allRoles') }}" method="GET">
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


  <div class="table-responsive" id="allRoles">
    <table class="table table-custom table-lg mb-0" id="customers">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($allroles as $thisrole)
        <tr>
          <td>
            <a href="javascript:;">{{$loop->iteration}}</a>
          </td>
          <td>{{ucwords(strtolower(str_replace('_',' ',$thisrole->name)), '\',. ')}}</td>
          <td class="text-end">
            <div class="d-flex">
              <div class="dropdown ms-auto">
                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                  <i class="bi bi-three-dots"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditRolesModal" data-bs-id="{{$thisrole->id}}" data-bs-name="{{$thisrole->name}}">Edit</a>
                  <a href="{{route('admin.showPermissions',$thisrole->id)}}" class="dropdown-item" rel="">Assign Permission</a>
                  <a href="javascript:;" class="dropdown-item deleteRole" rel="{{$thisrole->id}}">Delete</a>
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
<div class="modal fade" id="EditRolesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content dropzone">
      <div class="modal-header">
        <h5 class="modal-title" id="EditRoleModalLabel">Update Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateroleform">
        <div class="modal-body">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="recipient-name" class="col-form-label">Role Name:</label>
              <input type="text" class="form-control rolename" id="rolename" name="name">
              <input type="hidden" name="id" id="roleid" class="roleid" />
              {{@csrf_field()}}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary updaterolesubmit">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  var EditRolesModal = document.getElementById('EditRolesModal')
  EditRolesModal.addEventListener('show.bs.modal', function(event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var roleidval = button.getAttribute('data-bs-id')
    var rolenameval = button.getAttribute('data-bs-name')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var roleid = EditRolesModal.querySelector('.roleid')
    var rolename = EditRolesModal.querySelector('.rolename')

    roleid.value = roleidval
    rolename.value = rolenameval
  })

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#updateroleform').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
      type: 'POST',
      url: "{{route('admin.updateRole')}}",
      data: formData,
      contentType: false,
      processData: false,
      success: (response) => {
        Swal.fire(
          'Thank You!',
          'Role has been updated successfully!',
          'success'
        )
        $('#allRoles').load(document.URL + ' #allRoles');
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
<!-- Edit -->

@endpush
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
                <li class="breadcrumb-item active" aria-current="page">Holidays</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                <h6 class="card-title mb-5">Add New Holiday</h6>
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
                <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.addHoliday')}}">
                    {{csrf_field()}}
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ old('name') }}" class="form-control" name="name" placeholder="Name" aria-label="Name">
                        </div>
                        <div class="col">
                            <input type="date" name="holiday_date" class="form-control" />
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
                        <h6 class="card-title mb-0">Total Holidays</h6>
                        
                        <div class="text-center mt-5">
                        <div class="display-6">{{$totalholidays}}</div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="allHolidays">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($holidays as $thisholiday)
            <tr>
                <td>
                    <a href="javascript:;">{{$loop->iteration}}</a>
                </td>
                <td>{{$thisholiday->name}}</td>
                <td>{{date('d-M-Y',$thisholiday->holiday_date)}}</td>
                <td class="text-end">
                    <div class="d-flex">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown"
                               class="btn btn-floating"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditHolidayModal" data-bs-id="{{$thisholiday->id}}" data-bs-name="{{$thisholiday->name}}" data-bs-holiday_date="{{date('y-m-d',$thisholiday->holiday_date)}}" >Edit</a>
                                <a href="javascript:;" class="dropdown-item deleteHoliday" rel="{{$thisholiday->id}}">Delete</a>
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
<div class="modal fade" id="EditHolidayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditHolidayModalLabel">Update Holiday</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateholidayform">
      <div class="modal-body">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="recipient-name" class="col-form-label">Holiday Name:</label>
            <input type="text" name="name" class="form-control name"/>
            <input type="hidden" name="id" id="id" class="id"/>
            {{@csrf_field()}}
          </div>
          <div class="mb-3 col-md-6">
            <label for="recipient-name" class="col-form-label">Holiday Date <span class="holidaydatespan"></span>:</label>
            <input type="date" name="holiday_date" id="holiday_date" class="holiday_date form-control"/>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary updateholidaysubmit">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
    var EditHolidayModal = document.getElementById('EditHolidayModal')
    EditHolidayModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var idval = button.getAttribute('data-bs-id')
    var nameval = button.getAttribute('data-bs-name')
    var holidaydateval = button.getAttribute('data-bs-holiday_date')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var holidayid = EditHolidayModal.querySelector('.id')
    var holidayname = EditHolidayModal.querySelector('.name')
    var holidaydate = EditHolidayModal.querySelector('.holiday_date')
    var holidaydatespan = EditHolidayModal.querySelector('.holidaydatespan')
    holidayid.value = idval
    holidayname.value = nameval
    holidaydate.value = holidaydateval
    })
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $('#updateholidayform').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{route('admin.editHoliday')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
              Swal.fire(
                'Thank You!',
                'Holiday has been updated successfully!',
                'success'
              )
            $('#allHolidays').load(document.URL +  ' #allHolidays');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
              var errors = XMLHttpRequest['responseJSON']['errors'];
              var response = JSON.parse(XMLHttpRequest.responseText);
              var errorString = '<ul>';
              $.each( response.errors, function( key, value) {
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
$(document).on('click','.deleteHoliday',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this holiday?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('admin.deleteHoliday')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteHoliday',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Holiday has been deleted successfully!',
			  'success'
			)
            $('#allHolidays').load(document.URL +  ' #allHolidays');
        }
    })
  }})
    })


</script>
@endpush
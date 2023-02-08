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
                <li class="breadcrumb-item " aria-current="page">Request Leaves</li>
                <li class="breadcrumb-item active" aria-current="page">{{$username}}</li>
            </ol>
        </nav>
    </div>
    @if($personal != NULL)
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Request Leaves</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('leaves.requestLeave')}}">
                        {{csrf_field()}}
                        
                        <div class="row mb-3">
                            <div class="col">
                                <input type="date" value="{{ old('start_date') }}" class="form-control" name="start_date" placeholder="Start Date" aria-label="start_date">
                            </div>

                            <div class="col">
                                <input type="date" value="{{ old('end_date') }}" class="form-control" name="end_date" placeholder="End Date" aria-label="end_date">
                            </div>
                        </div>    

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Half Day</label>
                                    <input class="form-check-input" type="checkbox" id="half_day" name="half_day"> 
                                </div>
                            </div>
                            <div class="col">
                                <select class="form-select" name="type">
                                    <option selected disabled>Choose Leaves Types...</option>
                                    @foreach($leavetypes as $leavetype)
                                    <option value="{{$leavetype->id}}">{{$leavetype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <textarea name="reason" class="form-control" placeholder="Reasons" id="" cols="30" rows="10"></textarea>
                                </textarea>
                            </div>
                        </div>    

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Apply Leaves</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-4">
                        <h6 class="card-title mb-0">Total Leaves</h6>
                        <div class="dropdown ms-auto">
                            <!-- <a href="#" data-bs-toggle="dropdown" class="btn btn-sm" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a> -->
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">View Detail</a>
                                <a href="#" class="dropdown-item">Download</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$totalleave}}</div>
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
    @else
    @endif
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <button class="btn btn-outline-light" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @can('view inactive users')
                <div class="dropdown ms-auto">
                    <a href="#" data-bs-toggle="dropdown"
                       class="btn btn-primary dropdown-toggle"
                       aria-haspopup="true" aria-expanded="false">More</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{route('users.allUsers')}}" class="dropdown-item">Active Users</a>
                        <a href="{{route('users.inactiveUsers')}}" class="dropdown-item">In-Active Users</a>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom table-lg mb-0" id="allLeaves">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Leave Date</th>
                    <th>Leave Type</th>
                    <th>Reason</th>
                    <th>Status</th>
                    @can('handle leave requests')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $thisleave)
                    <tr class="@if($thisleave->status == 'pending') table-warning @elseif($thisleave->status == 'rejected') table-danger @else table-success @endif ")>
                        <td>{{$loop->iteration}}</td>
                        <td>{{date('d-M-Y',$thisleave->date)}}</td>
                        <td>{{$thisleave->leavetype->name}} @if($thisleave->half_day == 1) (Half Day) @else @endif </td>
                        <td>{{$thisleave->reason}}</td>
                        <td class="text-uppercase">{{$thisleave->status}}</td>
                        @can('handle leave requests')
                        <td>
                        <div class="d-flex">
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown"
                                class="btn btn-floating"
                                aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;" class="dropdown-item approveleave" rel="{{$thisleave->id}}">Approve</a>
                                <a href="javascript:;" class="dropdown-item rejectleave" rel="{{$thisleave->id}}">Reject</a>
                                </div>
                            </div>
                        </div>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav class="mt-4" aria-label="Page navigation example">
    {!! $leaves->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>

    </div>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).on('click','.approveleave',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to approve this leave?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, approve it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('leaves.approveLeave')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'approveLeave',id:id},
        success: function(res){
           	Swal.fire(
			  'Approved!',
			  'Leave has been approved successfully!',
			  'success'
			)
            $('#allLeaves').load(document.URL +  ' #allLeaves');
        }
    })
  }})
    })

    $(document).on('click','.rejectleave',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to reject this leave?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, reject it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('leaves.rejectLeave')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'rejectLeave',id:id},
        success: function(res){
           	Swal.fire(
			  'Approved!',
			  'Leave has been rejected successfully!',
			  'success'
			)
            $('#allLeaves').load(document.URL +  ' #allLeaves');
        }
    })
  }})
    })
</script>
@endpush
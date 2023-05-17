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
                <li class="breadcrumb-item " aria-current="page">Company Leaves</li>
            </ol>
        </nav>
    </div>
    
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex justify-content-between align-items-center">
                    <div class="d-md-flex gap-4 align-items-center">
                        <form class="mb-3 mb-md-0">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <form action="{{ route('leaves.showLeaves') }}" method="GET">
                                        <div class="input-group form-floating" style="border: 0.5px solid #ced4da; border-radius: 9px;">
                                            <input style="background: transparent;"type="text" class="form-control" id="floatingInputInvalid" placeholder="Search" name="search" value="{{ $search ?? '' }}">
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
                    <div class="d-flex align-items-center masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-calendar-plus px-3"></i>
                        </span>
                        <h6 class="card-title mb-0">Total Lead Leaves</h6>
                        <h4 class="mb-0 px-3">{{$leadleaves->total()}}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom table-lg mb-0" id="allLeaves">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Leave Date</th>
                        <th>Reason</th>
                        <th>Lead Leave Status</th>
                        <th>HR Leave Status</th>
                        <th>Final Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leadleaves as $thisleadleaves)
                    <tr class="@if($thisleadleaves->final_status== 'pending') table-warning @elseif($thisleadleaves->final_status== 'rejected') table-danger @else table-success @endif " )>
                        <td>{{$loop->iteration}}</td>
                        <td><a href="{{route('users.editUser',$thisleadleaves->userid)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisleadleaves->name}}">
                                <img src="{{asset('images/'.$thisleadleaves->image)}}" class="rounded-circle" alt="image"></a></td>
                        <td>{{$thisleadleaves->name}}</td>
                        <td>{{date('d-M-Y',$thisleadleaves->date)}}</td>
                        <td class="text-uppercase showreason" style="cursor: pointer;" id="reason" name="reason" data-bs-toggle="modal" data-bs-target="#DiscrepancyModal" rel="{{$thisleadleaves->reason}}"><span class="badge bg-success rounded-pill">View Reason</span></td>
                        <td class="text-uppercase"><span class="badge rounded-pill bg-warning text-dark">{{$thisleadleaves->lead_status}}</span></td>
                        <td class="text-uppercase"><span class="badge rounded-pill bg-warning text-dark">{{$thisleadleaves->hr_status}}</span></td>
                        <td class="text-uppercase"><span class="badge rounded-pill bg-warning text-dark">{{$thisleadleaves->final_status}}</span></td>
                        <td class="text-end">
                            <div class="d-flex">
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" class="dropdown-item approvelead" rel="{{$thisleadleaves->id}}">Approve</a>
                                        <a href="javascript:;" class="dropdown-item rejectlead" rel="{{$thisleadleaves->id}}">Reject</a>
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
    
    
    <div class="modal fade" id="DiscrepancyModal" tabindex="-1" aria-labelledby="ReasonModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content dropzone">
          <div class="modal-header">
            <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-calendar-plus me-3"></i>
            <h5 class="modal-title" id="reasonModalLabel">Leave's Reason</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="leavereason"></p>
          </div>
        </div>
      </div>
    </div>
    
    <script>
        $(document).ready(function() {
            
        $('.showreason').on('click',function(){
           var reason = $(this).attr('rel');
           $('.leavereason').text(reason);
        })
        })
    </script>
    
    
    
    <script>
        $(document).ready(function() {
            $('input[name="start_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });
            $('input[name="end_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true
            });
        })
    </script>
    
    <script type="text/javascript">
        $(document).on('click', '.approvelead', function(e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            Swal.fire({
                title: 'Are you sure you want to Approve This Leave?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('leaves.approvelead')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'approvelead',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Approved!',
                                'Leave has been Approved successfully!',
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

        $(document).on('click', '.rejectlead', function(e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            Swal.fire({
                title: 'Are you sure you want to Reject This Leave?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('leaves.rejectlead')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'rejectlead',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Rejected!',
                                'Leave has been Rejected successfully!',
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
    
    @endpush
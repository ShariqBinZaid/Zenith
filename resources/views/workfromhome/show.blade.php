@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('lead.allLeads')}}">
                        <i class="bi bi-globe2 small me-2"></i> User
                    </a>
                </li>
                <li class="breadcrumb-item " aria-current="page"><a href="{{route('workfromhome.allWorkFromHome')}}">Work From Home</a></li>

                <li class="breadcrumb-item active" aria-current="page">Todays Work From Home</li>
            </ol>
        </nav>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex justify-content-between align-items-center">
                <div class="leaves d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                        <div class="row g-3">
                            <div class="col form-floating">
                                <form action="{{ route('workfromhome.allWorkFromHome') }}" method="GET">
                                    <div class="input-group form-floating" style="border-right: 1px solid #ced4da; border-radius: 9px;flex-wrap: nowrap;">
                                        <select class="form-select select2-example" aria-label="Floating label select example" name="status">
                                            <option selected disabled>Select Work From Home</option>
                                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
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
                        <i class="bi bi-house-door px-3"></i>
                    </span>
                    <h6 class="card-title mb-0">Total Work From Home</h6>
                    <h4 class="mb-0 px-3">{{$workformhome->total()}}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="attendance">
        <table class="table table-custom table-lg mb-0" id="attendance">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    @can('approve reject work')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($workformhome as $thiswork)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><a href="{{route('users.editUser',$thiswork->user_id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thiswork->user->getMeta('designation')}} ({{$thiswork->user->getDepart->name}})">
                            <img src="{{asset('images/'.$thiswork->user->image)}}" class="rounded-circle" alt="image"></a></td>
                    <td>{{$thiswork->user->name}}</td>
                    <td>{{date('d-M-Y', $thiswork->date)}}</td>
                    <td class="text-uppercase showreason" style="cursor: pointer;" id="reason" name="reason" data-bs-toggle="modal" data-bs-target="#WorkFromHomeModal" rel="{{$thiswork->desc}}"><span class="badge bg-success rounded-pill">View Reason</span></td>
                    <td class="text-uppercase showreason"><span class="badge @if($thiswork->status == 'approved') bg-success @elseif($thiswork->status == 'pending') bg-warning @else bg-danger @endif rounded-pill">{{$thiswork->status}}</span></td>
                    @can('approve reject work')
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;" class="dropdown-item approveWorkFromHome" rel="{{$thiswork->id}}">Approve</a>
                                    <a href="javascript:;" class="dropdown-item rejectWorkFromHome" rel="{{$thiswork->id}}">Reject</a>
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
</div>

<nav class="mt-4" aria-label="Page navigation example">
    {!! $workformhome->withQueryString()->links('pagination::bootstrap-5') !!}
</nav>
@endsection

@push('scripts')

    <div class="modal fade" id="WorkFromHomeModal" tabindex="-1" aria-labelledby="WorkFromHomeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content dropzone">
          <div class="modal-header">
            <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-house-door me-3"></i>
            <h5 class="modal-title" id="reasonModalLabel">Work From Home Reason</h5>
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
    
    
    <script type="text/javascript">
        $(document).on('click', '.approveWorkFromHome', function(e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            Swal.fire({
                title: 'Are you sure you want to Approve This Work From Home?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('workfromhome.approveWorkFromHome')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'approveWorkFromHome',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Approved!',
                                'Work From Home has been Approved successfully!',
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

        $(document).on('click', '.rejectWorkFromHome', function(e) {
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
                        url: "{{route('workfromhome.rejectWorkFromHome')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'rejectWorkFromHome',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Rejected!',
                                'Work From Home has been Rejected successfully!',
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
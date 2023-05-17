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
    
    <div class="row g-4 mb-4">
        @if($personal != NULL && auth()->user()->getMeta('employment_status') == 'Permanent')
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-calendar-plus me-3"></i>
                        <h6 class="card-title mb-5">Request Leaves</h6>
                    </div>
                    
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @elseif($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @else
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
                            <div class="col form-floating">
                                <input type="text" value="{{ old('start_date') }}" class="form-control" id="floatingInputGrid" name="start_date" placeholder="Start Date" aria-label="start_date">
                                <label for="floatingInputGrid">Start Date</label>
                            </div>

                            <div class="col form-floating">
                                <input type="text" value="{{ old('end_date') }}" class="form-control" name="end_date" placeholder="End Date" aria-label="end_date">
                                <label for="floatingInputGrid">End Date</label>
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
                                <select class="form-select select2-example" name="type">
                                    <option selected disabled>Choose Leaves Types...</option>
                                    @foreach($leavetypes as $leavetype)
                                    <option value="{{$leavetype->id}}">{{$leavetype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col form-floating">
                                <textarea style="height: auto;" name="reason" class="form-control" placeholder="Reasons" id="floatingTextarea" cols="10" rows="10"></textarea>
                                <label for="floatingTextarea">Reasons</label>
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
                    <div class="d-flex mb-4 masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-calendar-plus"></i>
                        </span>
                        <h6 class="card-title px-3">Total Leaves</h6>
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$leaves->total()}}</div>
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
                    <tr class="@if($thisleave->final_status == 'pending') table-warning @elseif($thisleave->final_status == 'rejected') table-danger @else table-success @endif " )>
                        <td>{{$loop->iteration}}</td>
                        <td>{{date('d-M-Y',$thisleave->date)}}</td>
                        <td>{{$thisleave->leavetype->name}} @if($thisleave->half_day == 1) (Half Day) @else @endif </td>
                        <td>{{$thisleave->reason}}</td>
                        <td class="text-uppercase">{{$thisleave->final_status}}</td>
                        @can('handle leave requests')
                        <td>
                            <div class="d-flex">
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
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
        $(document).on('click', '.approveleave', function(e) {
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
                        data: {
                            type: 'approveLeave',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Approved!',
                                'Leave has been approved successfully!',
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

        $(document).on('click', '.rejectleave', function(e) {
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
                        data: {
                            type: 'rejectLeave',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Approved!',
                                'Leave has been rejected successfully!',
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
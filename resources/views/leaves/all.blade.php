@extends('layouts.app')

@section('content')
<div class="content ">
    <div class="row g-4 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('leaves.allLeaves') }}" method="GET">
                <div class="row">
                    
                        <div class="col-lg-12">
                            <div class="form-fields">
                                <div>
                                    <select class="select2-example " name="user[]" multiple>
                                      <option>Filter Users</option>
                                      @foreach($users as $thisuser)
                                      <option value="{{$thisuser->id}}" {{ in_array($thisuser->id, request()->input('user', [])) ? 'selected' : '' }}>{{$thisuser->name}}</option>
                                      @endforeach
                                    </select>
                                </div>
                                <div class=" form-floating input-group">
                                    <input type="date" value="{{ request()->input('start_date') }}" class="form-control" name="start_date" placeholder="Start Date" id="floatingInputInvalid" aria-label="start_date">
                                    <label for="floatingInputInvalid">Start Date</label>
                                </div>
                                <div class=" form-floating input-group">
                                    <input type="date" value="{{ request()->input('end_date')  }}" class="form-control" name="end_date" placeholder="End Date" id="floatingInputInvalid" aria-label="end_date">
                                    <label for="floatingInputInvalid">End Date</label>
                                </div>
                                <div class=" ">
                                    <select class="select2-example" name="final_status">
                                      <option selected disabled>Filter Leave Status</option>
                                      <option value="approved" {{'approved' == request()->input('final_status') ? 'selected' : ''}}>Approved</option>
                                      <option value="pending" {{'pending' == request()->input('final_status') ? 'selected' : ''}}>Pending</option>
                                      <option value="rejected" {{'rejected' == request()->input('final_status') ? 'selected' : ''}}>Rejected</option>
                                    </select>
                                </div>
                                <div class="">
                                    <button class="btn btn-outline-light" type="submit">
                                            Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    
                </div></form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom table-lg mb-0" id="allLeaves">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
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
                    @foreach($allleaves as $thisleaves)
                    <tr class="@if($thisleaves->final_status == 'pending') table-warning @elseif($thisleaves->final_status == 'rejected') table-danger @else table-success @endif " )>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$thisleaves->user->name}}</td>
                        <td>{{date('d-M-Y',$thisleaves->date)}}</td>
                        <td>{{$thisleaves->leavetype->name}} @if($thisleaves->half_day == 1) (Half Day) @else @endif </td>
                        <td>{{$thisleaves->reason}}</td>
                        <td class="text-uppercase">{{$thisleaves->final_status}}</td>
                        @can('handle leave requests')
                        <td>
                            <div class="d-flex">
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" class="dropdown-item approveleave" rel="{{$thisleaves->id}}">Approve</a>
                                        <a href="javascript:;" class="dropdown-item rejectleave" rel="{{$thisleaves->id}}">Reject</a>
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
            {!! $allleaves->withQueryString()->links('pagination::bootstrap-5') !!}
        </nav>
    </div>
</div>
@endsection
@extends('layouts.app')
<style>
    span.notfound {
    color: red;
}
</style>
@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <!--<li class="breadcrumb-item">-->
                <!--    <a href="{{route('adminDashboard')}}">-->
                <!--        <i class="bi bi-globe2 small me-2"></i> Setting-->
                <!--    </a>-->
                <!--</li>-->
                <li class="breadcrumb-item">
                    <a href="{{route('fleet.allFleet')}}">
                        <i class="bi bi-truck"></i> Fleet
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Fleet Maintainance Requests</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="fleet d-md-flex gap-4 align-items-center">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="allFleet">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reason</th>
                    <th>Request Date</th>
                    <th>User Name</th>
                    <th>Car Name</th>
                    <th>Vendor</th>
                    <th>Engine CC</th>
                    <th>Car Number</th>
                    <th>Car Model</th>
                    <th>Kilo Meter</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fleetmaintainances as $fleetmaintainance)
                <tr>
                    <td>
                        <a href="javascript:;">{{$loop->iteration}}</a>
                    </td>
                    <td class="text-uppercase showreason" style="cursor: pointer;" id="reason" name="reason" data-bs-toggle="modal" data-bs-target="#ReasonModal" rel="{{$fleetmaintainance->reason}}"><span class="badge bg-success rounded-pill">View Reason</span></td>
                    <td>{{date('d-M-Y',strtotime($fleetmaintainance->created_at))}}</td>
                    <td>
                        <a href="{{route('users.editUser',$fleetmaintainance->user->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$fleetmaintainance->user->name}}">
                            <img src="{{asset('images/'.$fleetmaintainance->user->image)}}" class="rounded-circle" alt="image">
                        </a>
                    </td>
                    <td>{{$fleetmaintainance->fleet->car_name}}</td>
                    <td><a style="padding-right:15px; font-size:15px;" href="tel:{{$fleetmaintainance->fleet->vendor_number}}" data-bs-toggle="tooltip" data-bs-original-title="{{$fleetmaintainance->fleet->vendor_number}}"><i class="bi bi-telephone"></i></a>{{$fleetmaintainance->fleet->vendor}}</td>
                    <td>{{$fleetmaintainance->fleet->cc}} CC</td>
                    
                    <td>{{$fleetmaintainance->fleet->car_number}}</td>
                    <td>{{$fleetmaintainance->fleet->model}}</td>
                    <td>{{number_format($fleetmaintainance->fleet->km, 2, '.', ',')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav class="mt-4" aria-label="Page navigation example">
        {!! $fleetmaintainances->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>
</div>
@endsection
@push('scripts')


<div class="modal fade" id="ReasonModal" tabindex="-1" aria-labelledby="ReasonModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content dropzone">
          <div class="modal-header">
            <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-arrow-repeat me-3"></i>
            <h5 class="modal-title" id="reasonModalLabel">Specific Reason (its optional)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="reason"></p>
          </div>
        </div>
      </div>
    </div>
    
    <script>
        $(document).ready(function() {
            
        $('.showreason').on('click',function(){
           var reason = $(this).attr('rel');
           $('.reason').text(reason);
        })
        })
    </script>
@endpush
@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="bi bi-globe2 small me-2"></i> Sales Force
                    </a>
                </li>
                <li class="breadcrumb-item " aria-current="page">
                    <a href="{{route('lead.allLeads')}}">
                        Leads
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Lead Details</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <h6 class="card-title mb-0">Lead Details</h6>
                    </div>
                    <div class="text-center">
                        <div class="avatar avatar-xl">
                            <img src="{{asset('images/'.$lead->getBrand->image)}}" class="rounded-circle" alt="image">
                            <b>{{$lead->getBrand->name}}</b>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="card mt-3" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>Name</b> : {{$lead->name}}</li>
                                <li class="list-group-item"><b>Email</b> : {{$lead->email}}</li>
                                <li class="list-group-item"><b>Phone</b> : {{$lead->phone}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
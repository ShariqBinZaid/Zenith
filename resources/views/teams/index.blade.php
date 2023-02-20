@extends('layouts.app')

@section('content')
<div class="content ">
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:;">
                        <i class="bi bi-gear small me-2"></i> Settings
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page"><a href="javascript:;">Teams</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$teamdetails->name}}</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4">
        <div class="col-lg-6 col-md-6 col-sm-12 ">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <h3>Team Name : {{$teamdetails->name}}</h3>
                        <h6>Leader : {{$teamdetails->getLeader->name}}</h6>
                        <h6>Unit : {{$teamdetails->getUnit->name}}</h6>
                        <h6>Created At : {{$teamdetails->created_at}}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                <div class="card-badge">Team Leader</div>
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/'.$teamdetails->getLeader->image)}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h6><a href="{{route('users.editUser',$teamdetails->getLeader->id)}}">{{$teamdetails->getLeader->name}}</a></h6>
                        <div class="text-muted">{{ucwords(strtolower(str_replace('_',' ',$teamdetails->getLeader->roles[0]->name)))}}</div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
    <div class="row align-items-center mb-4 g-3 mt-4">
        <div class="col-md-9">
            <h4 class="mb-0">Team Members</h4>
        </div>
        <div class="col-md-3 ms-auto">
            
        </div>
    </div>

    <div class="row g-4">
        @foreach($teamdetails->users as $thisteammember)
        @if($thisteammember->id == $teamdetails->leader)
        @else
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/'.$thisteammember->image)}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h6><a href="{{route('users.editUser',$thisteammember->id)}}">{{$thisteammember->name}}</a></h6>
                        <div class="text-muted">{{ucwords(strtolower(str_replace('_',' ',$thisteammember->roles[0]->name)))}}</div>
                    </div>
                    
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    <div class="row align-items-center mb-4 g-3 mt-4">
        <div class="col-md-9">
            <h4 class="mb-0">Brands</h4>
        </div>
        <div class="col-md-3 ms-auto">
            
        </div>
    </div>
    <div class="row g-4">
        @foreach($teamdetails->brands as $thisbrand)
        
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/'.$thisbrand->image)}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h6><a href="javascript:;">{{$thisbrand->name}}</a></h6>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    </div>
    @endsection
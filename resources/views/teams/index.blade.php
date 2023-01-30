@extends('layouts.app')

@section('content')
<div class="content ">
    <div class="row g-4">
        <div class="col-lg-4 col-md-6 col-sm-12" style="margin:0px auto;">
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
            <h6 class="mb-0">Team Members</h6>
        </div>
        <div class="col-md-3 ms-auto">
            
        </div>
    </div>

    <div class="row g-4">
        @foreach($teamdetails->users as $thisteammember)
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
        @endforeach
    </div>

    

    </div>
    @endsection
@extends('layouts.app')
<style>
    .strip {
    background: #f5b94a;
    color: white;
    font-size: 16px;
    padding: 5px;
    border-radius: 20px;
}
p.nobirthday {
    color: grey;
    padding: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
@section('content')
<div class="content ">
    
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <i class="bi bi-globe2 small me-2"></i> Celebrations
                </li>
                <li class="breadcrumb-item active" aria-current="page">Work Anniversaries</li>
            </ol>
        </nav>
    </div>
    <h2>Today's Work Anniversaries ({{date('d-M-Y')}})</h2>
    <div class="row g-4">
        @if(empty($todaysanniversary))
            <p class="nobirthday">No Work Anniversaries for today.</p>
        @else
        @foreach($todaysanniversary as $thisanniversary)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4 strip">
                        <span>{{date('d-M',strtotime($thisanniversary['joining']))}}</span>
                    </div>
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/'.$thisanniversary['image'])}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-1">{{$thisanniversary['name']}}</h5>
                        <div class="text-muted">{{$thisanniversary['designation']}}</div>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{route('users.editUser',$thisanniversary['id'])}}" class="btn btn-outline-primary btn-icon">
                            <i class="bi bi-person-plus"></i> View Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <h2>Work Anniversaries in {{$monthname}}</h2>
    <div class="row g-4">
        @foreach($thismonthanniversary as $thisanniversary)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4 strip">
                        <span>{{date('d-M',strtotime($thisanniversary['joining']))}}</span>
                    </div>
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/'.$thisanniversary['image'])}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-1">{{$thisanniversary['name']}}</h5>
                        <div class="text-muted">{{$thisanniversary['designation']}}</div>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{route('users.editUser',$thisanniversary['id'])}}" class="btn btn-outline-primary btn-icon">
                            <i class="bi bi-person-plus"></i> View Profile
                        </a>
                        <!-- <div class="dropup">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-outline-primary" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Message</a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
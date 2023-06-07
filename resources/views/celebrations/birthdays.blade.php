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
                <li class="breadcrumb-item active" aria-current="page">Birthdays</li>
            </ol>
        </nav>
    </div>
    <h2>Today's Birthdays ({{date('d-M-Y')}})</h2>
    <div class="row g-4">
        @if(empty($todaysbirthdays))
            <p class="nobirthday">No Birthdays for today.</p>
        @else
        @foreach($todaysbirthdays as $thisbirthday)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4 strip">
                        <span>{{date('d-M',strtotime($thisbirthday['dob']))}}</span>
                    </div>
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/'.$thisbirthday['image'])}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-1">{{$thisbirthday['name']}}</h5>
                        <div class="text-muted">{{$thisbirthday['designation']}}</div>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{route('users.editUser',$thisbirthday['id'])}}" class="btn btn-outline-primary btn-icon">
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
        @endif
    </div>
    <h2>Birthdays in {{$monthname}}</h2>
    <div class="row g-4">
        @foreach($thismonthbirthdays as $thismonthbirthday)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4 strip">
                        <span>{{date('d-M',strtotime($thismonthbirthday['dob']))}}</span>
                    </div>
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/'.$thismonthbirthday['image'])}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-1">{{$thismonthbirthday['name']}}</h5>
                        <div class="text-muted">{{$thismonthbirthday['designation']}}</div>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{route('users.editUser',$thismonthbirthday['id'])}}" class="btn btn-outline-primary btn-icon">
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
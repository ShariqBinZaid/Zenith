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
                    <a href="{{route('opportunity.allOpportunities')}}">
                        Opportunities
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Dispositions</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Opportunity Dispositions</h6>
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            @foreach($opportunity->disposition as $thisdisposition)
                            <li class="list-group-item p-4">
                                <h5>
                                    <a href="#">{{$thisdisposition->disposition_details->name}}</a>
                                </h5>
                                <p class="text-muted">{{$thisdisposition->feedback}} </p>
                                <div class="text-muted d-flex align-items-center">
                                    <span class="badge bg-secondary"></span>
                                    <a href="{{route('users.editUser',$thisdisposition->disposition_user->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisdisposition->disposition_user->name}}">
                                        <img src="{{asset('images/'.$thisdisposition->disposition_user->image)}}" class="rounded-circle" alt="image">
                                    </a>
                                    <div class="ms-3">{{date('d-M-Y h:i:s A',strtotime($thisdisposition->created_at))}}</div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            @foreach($opportunity->users()->get() as $thisuser)
                            <li class="list-group-item p-4">
                                <a href="{{route('users.editUser',$thisuser->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisuser->name}}">
                                        <img src="{{asset('images/'.$thisuser->image)}}" class="rounded-circle" alt="image">
                                    </a>
                                <h5>
                                    <a href="#">{{$thisuser->name}}</a>
                                </h5>
                                <form action="{{route('opportunity.pinguser',['userid'=>$thisuser->id,'opportunity_id'=>$opportunity->id])}}" method="POST">
                                {{csrf_field()}}
                                <input type="submit" class="btn btn-primary pinguser" name="Ping" value="Ping {{$thisuser->name}}"/>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <h6 class="card-title mb-0">Lead Details</h6>
                    </div>
                    <div class="text-center">
                        <div class="avatar avatar-xl">
                            <img src="{{asset('images/'.$opportunity->getBrand->image)}}" class="rounded-circle" alt="image">
                            <b>{{$opportunity->getBrand->name}}</b>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="card mt-3" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>Name</b> : {{$opportunity->name}}</li>
                                <li class="list-group-item"><b>Email</b> : {{$opportunity->email}}</li>
                                <li class="list-group-item"><b>Phone</b> : {{$opportunity->phone}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
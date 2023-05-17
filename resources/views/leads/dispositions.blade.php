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
                <li class="breadcrumb-item active" aria-current="page">Dispositions</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card"> 
                <div class="card-body">
                    <h6 class="card-title mb-5">Lead Dispositions</h6>
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            @foreach($lead->disposition as $thisdisposition)
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
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-5">Lead Assigned To</h6>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if ($message = Session::get('errordb'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
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
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            @foreach($lead->users()->get() as $thisuser)
                            <li class="list-group-item p-4">
                                <a href="{{route('users.editUser',$thisuser->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisuser->name}}">
                                        <img src="{{asset('images/'.$thisuser->image)}}" class="rounded-circle" alt="image">
                                    </a>
                                <h5>
                                    <a href="#">{{$thisuser->name}}</a>
                                </h5>
                                <form action="{{route('lead.pinguser',['userid'=>$thisuser->id,'lead_id'=>$lead->id])}}" method="POST">
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
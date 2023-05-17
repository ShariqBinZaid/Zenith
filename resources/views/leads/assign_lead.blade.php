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
                <li class="breadcrumb-item active" aria-current="page">Assign Lead</li>
            </ol>
        </nav>
    </div>
    @can('assign leads')
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-5">Assign Lead</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('lead.assignLeadSubmit')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-control select2-example" name="user_id">
                                    <option selected disabled>--Select Sales Agent--</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} ({{ucwords(strtolower(str_replace('_',' ',$user->roles->pluck('name')[0] ?? '')), '\',. ')}})</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="leads_id" value="{{request()->route('id');}}" />
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
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
                        <div class="text-center">
                            <div class="card mt-3">
                                <b>Assigned To:</b>
                                <ul class="list-group list-group-flush list-assign">
                                    @foreach($lead->users as $thisuser)
                                    <li class="list-group-item"><b>Name</b> : <a href="{{route('users.editUser',$thisuser->id)}}">{{$thisuser->name}}</a>
                                        @if( (auth()->user()->roles()->pluck('name')[0] == 'superadmin') ||(auth()->user()->roles()->pluck('name')[0] == 'admin') || (auth()->user()->roles()->pluck('name')[0] == 'business_unit_head') || (auth()->user()->roles()->pluck('name')[0] == 'sales_head')) )
                                        <form action="{{route('lead.unassignLeadSubmit')}}" method="POST">
                                            {{csrf_field()}}
                                            <input type="hidden" name="user_id" value="{{$thisuser->id}}" />
                                            <input type="hidden" name="leads_id" value="{{$lead->id}}" />
                                            <input type="submit" name="Submit" value="Unassign" class="unassignleadbtn" />
                                        </form>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
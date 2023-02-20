@extends('layouts.app')

@section('content')
<div class="content ">
        
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                        <i class="bi bi-gear small me-2"></i> Settings
                </li>
                <li class="breadcrumb-item " aria-current="page">
                    <a href="{{route('admin.allTeams')}}">Teams</a>
                </li>    
                <li class="breadcrumb-item active" aria-current="page">{{ucwords(strtolower(str_replace('_',' ',$teamdata->name)), '\',. ')}}</li>
                
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                <h6 class="card-title mb-5">Assign Members to "{{ucwords(strtolower(str_replace('_',' ',$teamdata->name)), '\',. ')}}"</h6>
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
                <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.assignTeamMember')}}">
                    {{csrf_field()}}
                    <div class="row mb-3">
                        <div class="col">
                            <input type="hidden" name="team_id" value="{{request()->route('id')}}"/>
                            <select class="form-control" name="user_id">
                                <option selected disabled>--Select the Member--</option>
                                @foreach($allmembers as $thismember)
                                <option value="{{$thismember->id}}">{{$thismember->name}} ({{ucwords(strtolower(str_replace('_',' ',$thismember->roles->pluck('name')[0] ?? '')), '\',. ')}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                <div class="text-center">
                            <h6 class="card-title mb-0"> {{$teamdata->name}}</h6>
                </div>
                <div class="text-center">
                    <div class="card mt-3" style="width: 18rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Name</b> : {{$teamdata->name}}</li>
                            <li class="list-group-item"><b>Team Leader</b> : <a href="{{route('users.editUser',$teamdata->getLeader->id)}}">{{$teamdata->getLeader->name}}</a></li>
                        </ul>
                    </div>
                    <div class="mb-3 mt-3 text-center">
                        <h6 class="card-title mb-0"> Members</h6>
                    </div>
                </div>
                    <div class="text-center">
                        <div class="card mt-3" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                            @foreach($teamdata->users as $thisuser)
                            @if($thisuser->is_leader == 1)
                            @else
                            <li class="list-group-item"><b>Name</b> : <a href="{{route('users.editUser',$thisuser->id)}}">{{$thisuser->name}}</a>
                            <form action="{{route('admin.unassignTeamMember')}}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="user_id" value="{{$thisuser->id}}"/>
                                <input type="hidden" name="team_id" value="{{$teamdata->id}}"/>
                                <input type="submit" name="Submit" value="Unassign" class="unassignleadbtn"/>
                            </form></li>
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
@endsection

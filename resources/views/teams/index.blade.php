@extends('layouts.app')

@section('content')
<div class="content ">
        
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-9">
            <h6 class="mb-0">Team Members</h6>
        </div>
        <div class="col-md-3 ms-auto">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search">
                    <button class="btn btn-outline-light" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mb-3">
                        <img src="{{asset('images/user/man_avatar3.jpg')}}" class="rounded-circle" alt="...">
                    </div>
                    <div class="mb-4">
                        <h6>Cahra Smiz</h6>
                        <div class="text-muted">Agent</div>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="btn btn-outline-primary btn-icon">
                            <i class="bi bi-person-plus"></i> Follow
                        </a>
                        <div class="dropup">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-outline-primary" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Message</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    </div>
    @endsection
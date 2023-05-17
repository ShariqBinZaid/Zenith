@extends('layouts.app')
<style>

    .list-group1 li{
            position: relative;
    display: block;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.125);
    }
    ul.list-group1.list-group-flush {
    height: 300px;
    overflow-y: scroll;
}
.chat-block .chat-content .messages .message-item.message-item-divider span, .demo-code-preview:before, .text-muted {
    color: yellow!important;
    text-decoration: line-through;
}
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #f5b94a; 
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #b30000; 
}
</style>
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
                <li class="breadcrumb-item active" aria-current="page">Opportunity Details</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <h6 class="card-title mb-0">Opportunity Details</h6>
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
                                <li class="list-group-item"><b>Package Name</b> : {{$opportunity->getPackage->name}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-selected">
                <div class="py-4">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <span class="display-8 me-3">{{$opportunity->getPackage->name}}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <span class="display-6 me-3" data-price1-text="">{{$opportunity->getPackage->getCurrency->symbol}} {{$opportunity->getPackage->price}}</span>
                        <span class="text-muted" data-price1-label="">{{$opportunity->getPackage->cut_price}}</span>
                    </div>
                    <div class="mb-4">
                        <ul class="list-group1 list-group-flush">
                            {!!$opportunity->getPackage->description!!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
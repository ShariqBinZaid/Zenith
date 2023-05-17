@extends('layouts.app')
<style>

    .list-group li{
            position: relative;
    display: block;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.125);
    }
    ul.list-group.list-group-flush {
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
            <i class="bi bi-globe2 small me-2"></i> Marketing
          </a>
        </li>
        <li class="breadcrumb-item " aria-current="page">Brands</li>
        <li class="breadcrumb-item active" aria-current="page">{{$brand->name}}</li>
      </ol>
    </nav>
  </div>
  <div class="row g-4">
        @foreach($brand->packages as $thispackage)
        <div class="col-md-4">
            <div class="card card-selected">
                <div class="py-4">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <span class="display-8 me-3">{{$thispackage->name}}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <span class="display-6 me-3" data-price1-text="">{{$thispackage->getCurrency->symbol}} {{$thispackage->price}}</span>
                        <span class="text-muted" data-price1-label="">{{$thispackage->cut_price}}</span>
                    </div>
                    <div class="mb-4">
                        <ul class="list-group list-group-flush">
                            {!!$thispackage->description!!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
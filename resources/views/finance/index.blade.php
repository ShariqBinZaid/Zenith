@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <i class="bi bi-globe2 small me-2"></i> Finance
                </li>
                @if($unit == NULL)
                <li class="breadcrumb-item active" aria-current="page">Expenses</li>
                @else
                <li class="breadcrumb-item " aria-current="page"><a href="{{route('finance.expenses',['month'=>$month,'year'=>$year])}}">Expenses</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$unitdetail->name}}</li>
                @endif
            </ol>
        </nav>
    </div>
    <div class="row g-4 mb-4">


        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-wallet2 me-3"></i>
                        <h6 class="card-title mb-5">Add New Expense</h6>
                    </div>

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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('finance.addExpense')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-select select2-example" name="month">
                                    <option selected disabled>--Select Month--</option>
                                    @for($i=01;$i<=12;$i++) <option value="{{sprintf("%02d", $i)}}" {{($month == $i) ? "selected" :"none"; }}>{{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select select2-example" name="year">
                                    <option selected disabled>--Select Year--</option>
                                    @for($i=2023;$i<=2026;$i++) <option value="{{$i}}" {{($year == $i) ? "selected" :"none"; }}>{{$i}}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-select select2-example" name="currencyid">
                                    <option selected disabled>Choose the Currency...</option>
                                    @foreach($currencies as $thiscurrencies)
                                    <option value="{{$thiscurrencies->id}}">{{$thiscurrencies->name}}( {{$thiscurrencies->symbol}} )</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select select2-example" name="unitid">
                                    <option selected disabled>Choose the Unit...</option>
                                    @foreach($units as $thisunit)
                                    <option value="{{$thisunit->id}}">{{$thisunit->name}} ({{$thisunit->getCompany->name}})</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('amount') }}" class="form-control" id="floatingInput" name="amount" placeholder="Amount" aria-label="Amount">
                                <label for="floatingInput">Amount</label>
                            </div>
                            <div class="col">
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <textarea style="height: auto;" value="{{ old('desc') }}" class="form-control" id="floatingTextarea" name="desc" placeholder="Description..." cols="10" rows="10" aria-label="Description..."></textarea>
                                <label for="floatingTextarea">Description</label>
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
                    <div class="d-flex mb-4 masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-wallet2"></i>
                        </span>
                        <h6 class="card-title px-3">Total February's Expenses @if($unit == NULL) @else for <b> {{ $unitdetail->name}} </b> @endif</h6>
                        <!--<div class="dropdown ms-auto">-->
                        <!--    <div class="dropdown-menu dropdown-menu-end">-->
                        <!--        <a href="#" class="dropdown-item">Download</a>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <div class="text-center">
                        <ul class="nav nav-pills flex-column gap-2">
                            @foreach($totalofexpenses as $thistotalexpense)
                            <li class="nav-item">
                                <a class="nav-link  d-flex align-items-center" href="javascript:;">
                                    {{$thistotalexpense['name']}} - {{$thistotalexpense['symbol'].$thistotalexpense['amount']}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-md-flex gap-4 align-items-center">
                <div class="d-none d-md-flex">Sort By</div>
                <div class="d-md-flex gap-3 align-items-center">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="hidden" value="{{$unit}}" class="unitid" />
                            <select class="form-select month">
                                <option selected disabled>Month</option>
                                @for($i=01;$i<=12;$i++) <option value="{{$i}}" {{($month == $i) ? "selected" :"none"; }}>{{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select year">
                                <option selected disabled>Year</option>
                                @for($i=2023;$i<=2030;$i++) <option value="{{$i}}" {{($year == $i) ? "selected" :"none"; }}>{{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select unit">
                                <option selected disabled>Select Unit</option>
                                @foreach($units as $thisunit)
                                <option value="{{$thisunit->id}}" {{($thisunit->id == $unit) ? "selected" :"none"; }}>{{$thisunit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <button class="btn btn-primary filterfinance my-3">Search</button>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="allleads">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Month - Year</th>
                    <th>Amount</th>
                    <th>Added By</th>
                    <th>Finance of</th>
                    <th>Description</th>
                    <!-- <th class="text-end">Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $thisexpense)
                <tr>
                    <td>
                        <a href="javascript:;">{{$loop->iteration}}</a>
                    </td>
                    <td>{{date('F', mktime(0, 0, 0, $thisexpense->month, 10))}} - {{$thisexpense->year}}</td>
                    <td>{{$thisexpense->getCurrency->symbol}}{{$thisexpense->amount}}</td>
                    <td>{{$thisexpense->AddedBy->name}}</td>
                    <td>{{$thisexpense->getUnit->name}} {{$thisexpense->getCompany->name}}</td>
                    <td>{{$thisexpense->desc}}</td>
                    <!-- <td class="text-end">
                    <div class="d-flex">
                        <div class="dropdown ms-auto">
                            <a href="#" data-bs-toggle="dropdown"
                               class="btn btn-floating"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;" class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#ShowLeadModal">Show</a>
                                <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditLeadModal">Edit</a>
                                <a href="javascript:;" class="dropdown-item deleteLead" >Delete</a>
                            </div>
                        </div>
                    </div>
                </td> -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <nav class="mt-4" aria-label="Page navigation example">

    </nav>
</div>
@endsection



@push('scripts')
<script>
    $('.filterfinance').on('click', function(e) {
        e.preventDefault();
        var unit = $('.unit').val();
        var month = $('.month').val();
        var year = $('.year').val();
        var url = "{{ route('finance.expenses',['unit'=>':unit','month'=>':month','year'=>':year']) }}";
        url = url.replace(':unit', unit);
        url = url.replace(':month', month);
        url = url.replace(':year', year);
        location.href = url;
    })
</script>
@endpush
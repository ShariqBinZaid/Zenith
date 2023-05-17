@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('lead.allLeads')}}">
                        <i class="bi bi-globe2 small me-2"></i> User
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Company's Payroll</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row row-vertical-border text-center">
                    <div class="col-6 text-success">
                        <h3>{{date('F', mktime(0, 0, 0, $month, 10))}}</h3>
                        <span>Month</span>
                    </div>
                    <div class="col-6 text-warning">
                        <h3>{{$year}}</h3>
                        <span>Year</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex gap-4 align-items-center">
                <div class="d-none d-md-flex">Sort By</div>
                <div class="payroll d-md-flex gap-4 align-items-center">
                    <form class="d-md-flex gap-4 align-items-center" method="GET" action="{{route('payroll.allPayrolls')}}">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4 form-floating">
                                <select class="select2-example p-2"  name="departments[]" multiple>
                                  <option disabled>Filter Department</option>
                                  @foreach($departments as $department)
                                  <option value="{{$department->id}}" {{ in_array($department->id, $filterdepart) ? 'selected' : '' }}>{{$department->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="select2-example form-select month" name="month">
                                    <option selected disabled>Month</option>
                                    @for($i=01;$i<=12;$i++) <option value="{{$i}}" {{($month == $i) ? "selected" :"none"; }}>{{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="select2-example form-select year" name="year">
                                    <option selected disabled>Year</option>
                                    @for($i=2023;$i<=2026;$i++) <option value="{{$i}}" {{($year == $i) ? "selected" :"none"; }}>{{$i}}</option>@endfor
                                </select>
                            </div>
                        </div>
                        <div class=" ms-auto">
                            <input type="submit" name="submit" value="Filter" class="btn btn-primary ">
                        </div>
                    </form>
                    <form class="d-md-flex gap-4 align-items-center" method="GET" action="{{route('payroll.payrollCSV')}}">
                        <div class="row g-3 d-none">
                            <div class="col-md-4 form-floating">
                                <select class="select2-example" name="departments[]" multiple>
                                  <option disabled>Filter Department</option>
                                  @foreach($departments as $department)
                                  <option value="{{$department->id}}"} {{ in_array($department->id, $filterdepart) ? 'selected' : '' }}>{{$department->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="select2-example form-select month">
                                    <option selected disabled>Month</option>
                                    @for($i=01;$i<=12;$i++) <option value="{{$i}}" {{($month == $i) ? "selected" :"none"; }}>{{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="select2-example form-select year">
                                    <option selected disabled>Year</option>
                                    @for($i=2023;$i<=2026;$i++) <option value="{{$i}}" {{($year == $i) ? "selected" :"none"; }}>{{$i}}</option>@endfor
                                </select>
                            </div>
                        </div>
                        <div class=" ms-auto">
                            <input type="submit" name="submit" value="Download CSV" class="btn btn-primary ">
                        </div>
                    </form>
                    <form class="d-md-flex gap-4 align-items-center" method="GET" action="{{route('payroll.generatePayroll')}}">
                        <div class="row g-3 d-none">
                            <div class="col-md-4 form-floating">
                                <select class="select2-example" name="departments[]" multiple>
                                  <option disabled>Filter Department</option>
                                  @foreach($departments as $department)
                                  <option value="{{$department->id}}"} {{ in_array($department->id, $filterdepart) ? 'selected' : '' }}>{{$department->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="select2-example form-select month">
                                    <option selected disabled>Month</option>
                                    @for($i=01;$i<=12;$i++) <option value="{{$i}}" {{($month == $i) ? "selected" :"none"; }}>{{date('F', mktime(0, 0, 0, $i, 10))}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="select2-example form-select year">
                                    <option selected disabled>Year</option>
                                    @for($i=2023;$i<=2026;$i++) <option value="{{$i}}" {{($year == $i) ? "selected" :"none"; }}>{{$i}}</option>@endfor
                                </select>
                            </div>
                        </div>
                        <div class=" ms-auto">
                            <input type="submit" name="submit" value="Generate Payroll" class="btn btn-primary ">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="attendance">
        <table class="table table-custom table-lg mb-0" id="attendance">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Actual Salary</th>
                    <th>Deduction</th>
                    <th>Tax</th>
                    <th>Amount Earned</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allusers as $user)
                <tr>
                    <td><a href="{{route('users.editUser',$user['userid'])}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$user['designation']}} ({{$user['department']}})">
                            <img src="{{asset('images/'.$user['image'])}}" class="rounded-circle" alt="image">
                    <td>{{$user['username']}}</td>
                    <td>RS {{$user['salary']}}</td>
                    <td>RS {{$user['deduction']}}</td>
                    <td>RS {{$user['tax_deduction']}}</td>
                    <th>RS {{$user['earned']}}</th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection


@push('scripts')
<script>
    $('.filterattendance').on('click', function (e) {
        e.preventDefault();
        var depart = $('.departments').val();
        var url = "{{ url('payroll/depart=:depart') }}";
        url = url.replace(':depart', depart);
        location.href = url;
    })
</script>
@endpush
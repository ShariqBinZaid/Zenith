@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="bi bi-gear small me-2"></i> Settings
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tax</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-calendar3 me-3"></i>
                        <h6 class="card-title mb-5">Add New Tax Range</h6>
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
                    <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('admin.addTax')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6 form-floating mb-3">
                                <input type="number" value="{{ old('from') }}" class="form-control" id="floatingInput" name="from" placeholder="From" aria-label="From">
                                <label for="floatingInput">Salary From</label>
                            </div>
                            <div class="col-md-6 form-floating mb-3">
                                <input type="number" value="{{ old('to') }}" class="form-control" id="floatingInput" name="to" placeholder="To" aria-label="To">
                                <label for="floatingInput">Salary To</label>
                            </div>
                            <div class="col-md-6 form-floating mb-3">
                                <input type="number" value="{{ old('tax_percent') }}"  step="0.01" class="form-control" id="floatingInput" name="tax_percent" placeholder="Tax Percentage" aria-label="Tax Percentage">
                                <label for="floatingInput">Tax Percentage</label>
                            </div>
                            <div class="col-md-6 form-floating mb-3">
                                <input type="number" value="{{ old('amount') }}" class="form-control" id="floatingInput" name="amount" placeholder="Amount" aria-label="Amount">
                                <label for="floatingInput">Tax Amount</label>
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
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <h6 class="card-title px-3">Total Ranges</h6>
                    </div>    
                    <div class="text-center">
                        <div class="display-6">{{$tax->count()}}</div>
                    </div>
                </div>
            </div>
        </div>

        <!--<div class="card">-->
        <!--    <div class="card-body">-->
        <!--        <div class="d-md-flex">-->
        <!--            <div class="d-md-flex gap-4 align-items-center">-->
        <!--                <form class="mb-3 mb-md-0">-->
        <!--                    <div class="row g-3">-->
        <!--                        <div class="col-md-12">-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </form>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <div class="table-responsive" id="allTax">
            <table class="table table-custom table-lg mb-0" id="customers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>Percentage</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tax as $thistax)
                    <tr>
                        <td>
                            <a href="javascript:;">{{$loop->iteration}}</a>
                        </td>
                        <td>RS {{number_format($thistax->from)}}</td>
                        <td>RS {{number_format($thistax->to)}}</td>
                        <td>RS {{number_format($thistax->amount)}}</td>
                        <td>{{$thistax->tax_percent}}%</td>
                        <td class="text-end">
                            <div class="d-flex">
                                <div class="dropdown ms-auto">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" class="dropdown-item editTax" data-bs-toggle="modal" data-bs-target="#EditTaxModal" data-id="{{$thistax->id}}" data-from="{{$thistax->from}}" data-to="{{$thistax->to}}" data-amount="{{$thistax->amount}}" data-percentage="{{$thistax->tax_percent}}">Edit</a>
                                        <a href="javascript:;" class="dropdown-item deleteTax" rel="{{$thistax->id}}">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @endsection
    @push('scripts')

    <!--Edit-->

    <div class="modal fade show" id="EditTaxModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content dropzone">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditTaxModalLabel">Update Tax</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updatetaxform">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">From</label>
                                <input type="text" name="from" id="from" class="form-control from" />
                                <input type="hidden" name="id" class="id" id="id">
                                {{@csrf_field()}}
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">To</label>
                                <input type="text" name="to" id="to" class="to form-control" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">Amount</label>
                                <input type="text" name="amount" id="amount" class="amount form-control" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="recipient-name" class="col-form-label">Tax Percent</label>
                                <input type="text" name="tax_percent" id="tax_percent" class="tax_percent form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary updatediscrepencysubmit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // $('input[name="holiday_date"]').daterangepicker({
            //     singleDatePicker: true,
            //     showDropdowns: true
            // });
            $('.editTax').click(function() {
                // alert($(this).data('name'))
                $('#updatetaxform').find('#id').val($(this).data('id'))
                $('#updatetaxform').find('#from').val($(this).data('from'))
                $('#updatetaxform').find('#to').val($(this).data('to'))
                $('#updatetaxform').find('#amount').val($(this).data('amount'))
                $('#updatetaxform').find('#tax_percent').val($(this).data('percentage'))
            })
        })


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#updatetaxform').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{route('admin.editTax')}}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    Swal.fire(
                        'Thank You!',
                        'Tax has been updated successfully!',
                        'success'
                    )
                    setTimeout(function() {
                                location.reload();
                            }, 2000);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var errors = XMLHttpRequest['responseJSON']['errors'];
                    var response = JSON.parse(XMLHttpRequest.responseText);
                    var errorString = '<ul>';
                    $.each(response.errors, function(key, value) {
                        errorString += '<li>' + value + '</li>';
                    });
                    errorString += '</ul>';
                    //errorThrown.='\n'+
                    Swal.fire(
                        'Request Failed!',
                        errorString,
                        'error'
                    )
                }
            });
        });
    </script>


    <!--Edit-->


    <!-- Delete Holiday Ajax Start -->

    <script type="text/javascript">
        $(document).on('click', '.deleteTax', function(e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            Swal.fire({
                title: 'Are you sure you want to delete this Tax?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.deleteTax')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'deleteTax',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Deleted!',
                                'Tax has been deleted successfully!',
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    })
                }
            })
        })
    </script>

    <!-- Delete Holiday Ajax End -->

    @endpush
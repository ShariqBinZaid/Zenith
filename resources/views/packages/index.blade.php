@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('adminDashboard')}}">
                        <i class="bi bi-globe2 small me-2"></i> Marketing
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Packages</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-box me-3"></i>
                        <h6 class="card-title mb-5">Add New Package</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('packages.addPackage')}}">
                        {{csrf_field()}}
                        <div class="row mb-3 p-0">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                <label for="floatingInput">Name</label>
                            </div>
                        </div>
                        <div class="row mb-3 p-0">
                            <div class="col">
                                <select class="form-select select2-example" name="package_type">
                                    <option selected disabled>Choose Package Type...</option>
                                    @foreach($packagetypes as $thispackagetype)
                                    <option value="{{$thispackagetype->id}}">{{$thispackagetype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select select2-example" name="brand_id">
                                    <option selected disabled>Choose Brand...</option>
                                    @foreach($allbrands as $thisbrand)
                                    <option value="{{$thisbrand->id}}">{{$thisbrand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select select2-example" name="currency">
                                    <option selected disabled>Choose Currency...</option>
                                    @foreach($currencies as $thiscurrency)
                                    <option value="{{$thiscurrency->id}}">{{$thiscurrency->code}} ({{$thiscurrency->symbol}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 p-0">
                            <div class="col form-floating">
                                <input type="text" value="{{ old('price') }}" class="form-control" id="floatingInput" name="price" placeholder="Price" aria-label="Price">
                                <label for="floatingInput">Price</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('cut_price') }}" name="cut_price" class="form-control" id="floatingInput" placeholder="Cut Price" aria-label="Cut Price">
                                <label for="floatingInput">Cut Price</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" value="{{ old('discount') }}" name="discount" class="form-control" id="floatingInput" placeholder="Discount(Optional)" aria-label="Discount(Optional)">
                                <label for="floatingInput">Discount(Optional)</label>
                            </div>
                            

                        </div>
                        <div class="row mb-3">
                            <textarea style="height: auto;" class="description" name="description" cols="10" rows="10" id="packagedetails"></textarea>
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
                            <i class="bi bi-box"></i>
                        </span>
                        <h6 class="card-title mb-0">Total Packages</h6>
                        <!--<div class="dropdown ms-auto">-->
                        <!--    <div class="dropdown-menu dropdown-menu-end">-->
                                <!-- <a href="#" class="dropdown-item">View Detail</a> -->
                        <!--        <a href="#" class="dropdown-item">Download</a>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <div class="text-center">
                        <div class="display-6">{{$totalpackages}}</div>
                    </div>
                    <div class="text-muted d-flex align-items-center justify-content-center">
                        <span class="text-success me-3 d-block">
                            <i class="bi bi-arrow-up me-1 small"></i>+35
                        </span> Point from last month
                    </div>
                    <div class="row my-4">
                        <div class="col-md-6 m-auto">
                            <div id="customer-rating"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-outline-primary btn-icon">
                            <i class="bi bi-download"></i> Download All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-md-flex">
                <div class="d-md-flex gap-4 align-items-center">
                    <form class="mb-3 mb-md-0">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <form action="{{ route('packages.allPackages') }}" method="GET">
                                    <div class="input-group form-floating" style="border: 0.5px solid #ced4da; border-radius: 9px;">
                                        <input style="background: transparent;" type="text" class="form-control" id="floatingInputInvalid" placeholder="Search" name="search" value="{{ $search ?? '' }}">
                                        <label for="floatingInputInvalid">Search</label>
                                        <button class="btn btn-outline-light" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" id="allPackages">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Package Type</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <!-- <th>Created At</th> -->
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $thispackage)
                <tr>
                    <td>
                        <a href="javascript:;">{{$loop->iteration}}</a>
                    </td>
                    <td>{{$thispackage->name}}</td>
                    <td>{{$thispackage->getPackageType->name}}</td>
                    <!--<td><span class="badge bg-success">{{$thispackage->getBrand->name}}</span></td>-->
                    <td><a href="{{route('brands.allBrands',$thispackage->getBrand->id)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thispackage->getBrand->name}}">
                            <img src="{{asset('images/'.$thispackage->getBrand->image)}}" class="w-auto" alt="image">
                        </a></td>
                    <td>{{$thispackage->getCurrency->symbol}}{{$thispackage->price}}</td>
                    <!-- <td>{{$thispackage->created_at}}</td> -->
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ShowPackageModal" data-bs-id="{{$thispackage->id}}" data-bs-name="{{$thispackage->name}}" data-bs-price="{{$thispackage->getCurrency->symbol}}{{$thispackage->price}}" data-bs-cut_price="{{$thispackage->getCurrency->symbol}}{{$thispackage->cut_price}}" data-bs-description="{{$thispackage->description}}" data-bs-currency="{{$thispackage->getCurrency->name}}" data-bs-brand_id="{{$thispackage->getBrand->name}}" data-bs-package_type="{{$thispackage->getPackageType->name}}" data-bs-created_at="{{$thispackage->created_at}}" data-bs-discount="{{$thispackage->discount}}">Show</a>
                                    <a href="{{route('packages.editPackage',$thispackage->id)}}" class="dropdown-item">Edit</a>
                                    <a href="javascript:;" class="dropdown-item deletePackage" rel="{{$thispackage->id}}">Delete</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <nav class="mt-4" aria-label="Page navigation example">

        {!! $packages->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>

</div>
@endsection

@push('scripts')

<!-- Show -->
<div class="modal fade" id="ShowPackageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <h5 class="modal-title" id="ShowPackageModalLabel">Details of this Package</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body showbranddetails">
                <div class="mb-3">
                    <image class="brandimage" />
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Name:</label><span class="pkgname"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Brand:</label><span class="pkgbrand"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Package Type:</label><span class="pkgtype"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Price:</label><span class="price"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Cut Price:</label><span class="cutprice"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Currency:</label><span class="currency"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Discount:</label><span class="discount"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Description:</label><span class="desc"></span>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Created at:</label><span class="created_at"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var ShowPackageModal = document.getElementById('ShowPackageModal')
    ShowPackageModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var nameval = button.getAttribute('data-bs-name')
        var priceval = button.getAttribute('data-bs-price')
        var cutpriceval = button.getAttribute('data-bs-cut_price')
        var descval = button.getAttribute('data-bs-description')
        var currencyval = button.getAttribute('data-bs-currency')
        var brandidval = button.getAttribute('data-bs-brand_id')
        var pkgtypeval = button.getAttribute('data-bs-package_type')
        var pkgcreated_at = button.getAttribute('data-bs-created_at')
        var pkgdiscount = button.getAttribute('data-bs-discount')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var pkgname = ShowPackageModal.querySelector('.pkgname')
        var pkgbrand = ShowPackageModal.querySelector('.pkgbrand')
        var pkgtype = ShowPackageModal.querySelector('.pkgtype')
        var price = ShowPackageModal.querySelector('.price')
        var cutprice = ShowPackageModal.querySelector('.cutprice')
        var currency = ShowPackageModal.querySelector('.currency')
        var desc = ShowPackageModal.querySelector('.desc')
        var created_at = ShowPackageModal.querySelector('.created_at')
        var discount = ShowPackageModal.querySelector('.discount')

        pkgname.textContent = nameval
        pkgbrand.textContent = brandidval
        pkgtype.textContent = pkgtypeval
        price.textContent = priceval
        cutprice.textContent = cutpriceval
        currency.textContent = currencyval
        desc.textContent = descval
        discount.textContent = pkgdiscount
        created_at.textContent = pkgcreated_at
    })
</script>

<!-- Show -->


<!-- Delete Package Ajax Start -->

<script type="text/javascript">
$(document).on('click','.deletePackage',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this Package?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('packages.deletePackage')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deletePackage',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Package has been deleted successfully!',
			  'success'
			)
            setTimeout(function() {
                    location.reload();
                }, 2000);
        }
    })
  }})
    })
</script>

<!-- Delete Package Ajax End -->
<script type="text/javascript">
      ClassicEditor.create(document.querySelector('#packagedetails'), {
    toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList'],
    heading: {
        options: [
            {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'}
        ]
    }
})
</script>
@endpush
@extends('layouts.app')

@section('content')
<div class="content ">

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('adminDashboard')}}">
                        <i class="bi bi-globe2 small me-2"></i> Setting
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Company Announcements</li>
            </ol>
        </nav>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-megaphone me-3"></i>
                        <h6 class="card-title mb-5">Add New Announcements</h6>
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
                    <form class="row gx-3 gy-2 align-items-center " method="POST" action="{{route('announcements.addCompanyAnnouncement')}}">
                        {{csrf_field()}}
                        <div class="row mb-3">
                            <div class="col form-floating">
                                <textarea style="height: auto;" class="form-control" id="floatingTextarea2 text" rows="10" cols="10" name="text" placeholder="Announcements Description"></textarea>
                                <label for="floatingTextarea2">Announcements Description</label>
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
                            <i class="bi bi-megaphone"></i>
                        </span>
                        <h6 class="card-title px-3">Total Announcements</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">Download</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="display-6"></div>
                    </div>
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
    <!--                            <form action="{{ route('admin.allDeparts') }}" method="GET">-->
    <!--                                <div class="input-group form-floating" style="border: 0.5px solid #ced4da; border-radius: 9px;">-->
    <!--                                    <input style="background: transparent;" type="text" class="form-control" id="floatingInputInvalid" placeholder="Search" name="search" value="{{ $search ?? '' }}">-->
    <!--                                    <label for="floatingInputInvalid">Search</label>-->
    <!--                                    <button class="btn btn-outline-light" type="submit">-->
    <!--                                        <i class="bi bi-search"></i>-->
    <!--                                    </button>-->
    <!--                                </div>-->
    <!--                            </form>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </form>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    <div class="table-responsive" id="allAnnouncements">
        <table class="table table-custom table-lg mb-0" id="customers">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Added By</th>
                    <th>Announcement</th>
                    <th>Company</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $thisannouncements)
                <tr>
                    <td><a href="javascript:;">{{$loop->iteration}}</a></td>
                    <td><a href="{{route('users.editUser',$thisannouncements->userid)}}" class="avatar" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisannouncements->username}}">
                            <img src="{{asset('images/'.$thisannouncements->image)}}" class="rounded-circle" alt="image">
                        </a></td>
                    <td class="text-uppercase showreason" style="cursor: pointer;" id="reason" name="reason" data-bs-toggle="modal" data-bs-target="#AnnouncementModal" rel="{{$thisannouncements->announcement}}"><span class="badge bg-success rounded-pill">View Announcement</span></td>
                    <td><a class="image-popup" href="{{asset('images/'.$thisannouncements->company_image)}}"><img src="{{asset('images/'.$thisannouncements->company_image)}}" class="imageintable" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$thisannouncements->company_name}}" /></a></td>
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false"><i class="bi bi-three-dots"></i></a>

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


<div class="modal fade" id="AnnouncementModal" tabindex="-1" aria-labelledby="ReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content dropzone">
            <div class="modal-header">
                <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-arrow-repeat me-3"></i>
                <h5 class="modal-title" id="reasonModalLabel">Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="reason"></p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.showreason').on('click', function() {
            var reason = $(this).attr('rel');
            $('.reason').text(reason);
        })
    })
</script>
@endpush
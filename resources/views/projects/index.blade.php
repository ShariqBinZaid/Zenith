@extends('layouts.app')

@section('content')
<div class="content ">
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('adminDashboard')}}">
                        <i class="bi bi-globe2 small me-2"></i> Collateral
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Projects</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-4">
                        <i style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="bi bi-kanban-fill me-3"></i>
                        <h6 class="card-title mb-3">Add New Project</h6>
                    </div>
                    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Add Project</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Add Client</a>
                        </li>
                    </ul>
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
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('projects.addProject')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row mb-3">
                                    <div class="col-md-12 mb-3 form-floating">
                                        <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                        <input type="hidden" value="Manually Added" name="created_from" />
                                        <input type="hidden" value="{{auth()->user()->id}}" name="converted_by" />
                                        <label for="floatingInput">Name</label>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="package_id">
                                            <option selected disabled>--Select Package--</option>
                                            @foreach($brandspackages as $brand)
                                            <optgroup label="{{ $brand->name }}">
                                                @foreach($brand->packages as $thepackage)
                                                <option value="{{ $thepackage->id }}">{{ $thepackage->name }}</option>
                                                @endforeach
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="priority">
                                            <option selected disabled>Choose the Priority...</option>
                                            <option value="normal">Normal</option>
                                            <option value="medium">Medium</option>
                                            <option value="urgent">Urgent</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="project_type">
                                            <option selected disabled>Choose the Project Type...</option>
                                            @foreach($projecttype as $thisprojecttype)
                                            <option value="{{$thisprojecttype->id}}">{{$thisprojecttype->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select select2-example" name="customer_id">
                                            <option selected disabled>Choose the Client...</option>
                                            @foreach($clients as $thiclient)
                                            <option value="{{$thiclient->id}}">{{$thiclient->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 form-floating">
                                        <textarea style="height: auto;" name="desc" rows="10" cols="10" class="form-control" id="floatingTextarea2" placeholder="Project Description"></textarea>
                                        <label for="floatingTextarea2">Comments</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <form class="row gx-3 gy-2 align-items-center" method="POST" action="{{route('users.addClient')}}">
                                {{csrf_field()}}
                                <div class="row mb-3">
                                    <div class="col form-floating">
                                        <input type="text" value="{{ old('name') }}" class="form-control" id="floatingInput" name="name" placeholder="Name" aria-label="Name">
                                        <label for="floatingInput">Name</label>
                                    </div>
                                    <div class="col form-floating">
                                        <input type="text" value="{{ old('email') }}" name="email" class="form-control" id="floatingInput" placeholder="Email" aria-label="Email">
                                        <label for="floatingInput">Email</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 form-floating">
                                        <input type="tel" value="{{ old('phone') }}" name="phone" class="form-control" id="floatingInput" placeholder="Phone" aria-label="Phone">
                                        <label for="floatingInput">Phone</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex mb-4 masthead-followup-icon">
                        <span style="font-size: 26px;line-height: 18px;color: #f3a81d;" class="me-lg-auto">
                            <i class="bi bi-kanban-fill"></i>
                        </span>
                        <h6 class="card-title mb-0">Projects</h6>
                        
                    </div>
                    <div class="text-center">
                        <div class="display-6">3.0</div>
                        <div class="d-flex justify-content-center gap-3 my-3">
                            <i class="bi bi-star-fill icon-lg text-warning"></i>
                            <i class="bi bi-star-fill icon-lg text-warning"></i>
                            <i class="bi bi-star-fill icon-lg text-warning"></i>
                            <i class="bi bi-star-fill icon-lg text-muted"></i>
                            <i class="bi bi-star-fill icon-lg text-muted"></i>
                            <span>(318)</span>
                        </div>
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
                            <i class="bi bi-download"></i> Download Report
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
                                <form action="{{ route('projects.allProjects') }}" method="GET">
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

    <div class="table-responsive">
        <table class="table table-custom table-lg mb-0" id="allProjects">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Project Name</th>
                    <th>Customer Name</th>
                    <th>Sales Agent</th>
                    <th>Project Type</th>
                    <th>Brand Name</th>
                    <th>Package Name</th>
                    <th>Project Priority</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $thisproject)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$thisproject->name}}</td>
                    <td><a href="{{route('users.editUser',$thisproject->getCustomer->id)}}">{{$thisproject->getCustomer->name}}</a></td>
                    <td><a href="{{route('users.editUser',$thisproject->getConverter->id)}}">{{$thisproject->getConverter->name}}</a></td>
                    <td>{{$thisproject->getProjectType->name}}</td>
                    <td>{{$thisproject->getBrand->name}}</td>
                    <td>{{$thisproject->getPackage->name}}</td>
                    <td>
                        @if($thisproject->priority == 'normal')
                        <span class="badge bg-success">{{$thisproject->priority}}</span>
                        @elseif($thisproject->priority == 'medium')
                        <span class="badge bg-warning">{{$thisproject->priority}}</span>
                        @else
                        <span class="badge bg-danger">{{$thisproject->priority}}</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" class="btn btn-floating" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ShowProjectModal" data-bs-id="{{$thisproject->id}}" data-bs-name="{{$thisproject->name}}" data-bs-customer="{{$thisproject->getCustomer->name}}" data-bs-sales_agent="{{$thisproject->getConverter->name}}" data-bs-brand="{{$thisproject->getBrand->name}}" data-bs-package="{{$thisproject->getPackage->name}}" data-bs-priority="{{$thisproject->priority}}" data-bs-projecttype="{{$thisproject->getProjectType->name}}" data-bs-desc="{{$thisproject->desc}}" data-bs-created_at="{{$thisproject->created_at}}">Show</a>
                                    <a href="javascript:;" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditProjectsModal" data-bs-id="{{$thisproject->id}}" data-bs-name="{{$thisproject->name}}" data-bs-customer="{{$thisproject->getCustomer->name}}" data-bs-sales_agent="{{$thisproject->getConverter->name}}" data-bs-brand="{{$thisproject->getBrand->name}}" data-bs-package="{{$thisproject->getPackage->name}}" data-bs-priority="{{$thisproject->priority}}" data-bs-projecttype="{{$thisproject->getProjectType->id}}" data-bs-desc="{{$thisproject->desc}}" data-bs-created_at="{{$thisproject->created_at}}">Edit</a>
                                    <a href="javascript:;" class="dropdown-item deleteProject" rel="{{$thisproject->id}}">Archive</a>
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
        {!! $projects->withQueryString()->links('pagination::bootstrap-5') !!}
    </nav>

</div>
@endsection


@push('scripts')

<!-- ------------------------------------------Projects------------------------------------- -->
<!-- Edit Projects Modal Start -->

<div class="modal fade" id="EditProjectsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditProjectModalLabel">Update Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateprojectform">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control name" name="name" placeholder="Name" aria-label="Name">
                            <input type="hidden" class="id" name="id" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <select class="form-select priority" name="priority">
                                <option selected disabled>Choose the Priority...</option>
                                <option value="normal">Normal</option>
                                <option value="medium">Medium</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select class="form-select project_type" name="project_type">
                                <option selected disabled>Choose the Project Type...</option>
                                @foreach($projecttype as $thisprojecttype)
                                <option value="{{$thisprojecttype->id}}">{{$thisprojecttype->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <textarea name="desc" rows="4" cols="50" class="form-control desc" placeholder="Project Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary updateprojectsubmit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var EditProjectsModal = document.getElementById('EditProjectsModal')
    EditProjectsModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var projid = button.getAttribute('data-bs-id')
        var projname = button.getAttribute('data-bs-name')
        var priority = button.getAttribute('data-bs-priority')
        var projecttype = button.getAttribute('data-bs-projecttype')
        var desc = button.getAttribute('data-bs-desc')
        var created_at = button.getAttribute('data-bs-created_at')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        var idval = EditProjectsModal.querySelector('.id')
        var nameval = EditProjectsModal.querySelector('.name')
        var priorityval = EditProjectsModal.querySelector('.priority')
        var descval = EditProjectsModal.querySelector('.desc')
        var project_typeval = EditProjectsModal.querySelector('.project_type')
        idval.value = projid
        nameval.value = projname
        priorityval.value = priority
        descval.value = desc
        project_typeval.value = projecttype
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#updateprojectform').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{route('projects.updateProject')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                Swal.fire(
                    'Thank You!',
                    'Project has been updated successfully!',
                    'success'
                )
                $('#allProjects').load(document.URL + ' #allProjects');
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

<!-- Edit Permissions Modal End -->

<!-- Show Projects Modal Start -->

<div class="modal fade" id="ShowProjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ShowProjectModalLabel">Details of this Project</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body showleaddetails">
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name:</label><span class="name"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Client Name:</label><span class="clientname"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Sales Agent:</label><span class="salesagent"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Brand Name:</label><span class="brand"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Package Name:</label><span class="package"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Priority:</label><span class="priority"></span>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Project Type:</label><span class="project_type"></span>
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
        var ShowProjectModal = document.getElementById('ShowProjectModal')
        ShowProjectModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var projid = button.getAttribute('data-bs-id')
            var projname = button.getAttribute('data-bs-name')
            var customer = button.getAttribute('data-bs-customer')
            var sales_agent = button.getAttribute('data-bs-sales_agent')
            var brand = button.getAttribute('data-bs-brand')
            var packagename = button.getAttribute('data-bs-package')
            var priority = button.getAttribute('data-bs-priority')
            var projecttype = button.getAttribute('data-bs-projecttype')
            var desc = button.getAttribute('data-bs-desc')
            var created_at = button.getAttribute('data-bs-created_at')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var nameval = ShowProjectModal.querySelector('.name')
            var clientnameval = ShowProjectModal.querySelector('.clientname')
            var salesagentval = ShowProjectModal.querySelector('.salesagent')
            var brandval = ShowProjectModal.querySelector('.brand')
            var packageval = ShowProjectModal.querySelector('.package')
            var priorityval = ShowProjectModal.querySelector('.priority')
            var descval = ShowProjectModal.querySelector('.desc')
            var project_typeval = ShowProjectModal.querySelector('.project_type')
            var created_atval = ShowProjectModal.querySelector('.created_at')
            nameval.textContent = projname
            clientnameval.textContent = customer
            salesagentval.textContent = sales_agent
            brandval.textContent = brand
            packageval.textContent = packagename
            priorityval.textContent = priority
            descval.textContent = desc
            project_typeval.textContent = projecttype
            created_atval.textContent = created_at
        })
    </script>

    <!-- Show Projects Modal End -->

    <!-- Archieve Project Start -->
    <script type="text/javascript">
        $(document).on('click', '.deleteProject', function(e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            Swal.fire({
                title: 'Are you sure you want to archive this Project?',
                text: "You can revert it back!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, archive it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('projects.archiveProject')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: {
                            type: 'archiveProject',
                            id: id
                        },
                        success: function(res) {
                            Swal.fire(
                                'Archived!',
                                'Project has been archived!',
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

    <!-- Archieve Project End -->

    @endpush
<!--CK EDITOR SCRIPT START-->
<script type="text/javascript">
  
  ClassicEditor.create(document.querySelector('#packagedetails'), {
    toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList'],
    heading: {
        options: [
            {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'}
        ]
    }
})

$('.image-popup').magnificPopup({
    type: 'image',
    zoom: {
        enabled: true,
        duration: 300,
        easing: 'ease-in-out',
        opener: function(openerElement) {
            return openerElement.is('img') ? openerElement : openerElement.find('img');
        }
    }
});
</script>

<!--CK EDITOR SCRIPT END-->
<!-- Delete Lead Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deleteLead',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this lead?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('lead.deleteLead')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteLead',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Lead has been deleted successfully!',
			  'success'
			)
            $('#allleads').load(document.URL +  ' #allleads');
        }
    })
  }})
    })


</script>
<!-- Delete Lead Ajax End -->

<!-- Delete Opportunity Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deleteOpportunity',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this opportunity?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('opportunity.deleteOpportunity')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteOpportunity',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Opportunity has been deleted successfully!',
			  'success'
			)
            $('#allOpportunity').load(document.URL +  ' #allOpportunity');
        }
    })
  }})
    })


</script>
<!-- Delete Opportunity Ajax End -->

<!-- Delete Brand Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deleteBrand',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this brand?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('brands.deleteBrand')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteBrand',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Brand has been deleted successfully!',
			  'success'
			)
            $('#allBrands').load(document.URL +  ' #allBrands');
        }
    })
  }})
    })


</script>
<!-- Delete Brand Ajax End -->

<!-- Delete Package Ajax Start -->

<script type="text/javascript">
$(document).on('click','.deletePackage',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this package?',
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
            $('#allPackages').load(document.URL +  ' #allPackages');
        }
    })
  }})
    })


</script>

<!-- Delete Package Ajax End -->

<!-- Delete Package Types Ajax Start -->

<script type="text/javascript">
$(document).on('click','.deletePackageTypes',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this package types?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('packageTypes.deletePackageTypes')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deletePackageTypes',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Package Type has been deleted successfully!',
			  'success'
			)
            $('#allPackageTypes').load(document.URL +  ' #allPackageTypes');
        }
    })
  }})
    })


</script>

<!-- Delete Package Types Ajax End -->

<!-- Delete Roles Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deleteRole',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this role?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('admin.deleteRole')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteRole',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Role has been deleted successfully!',
			  'success'
			)
            $('#allRoles').load(document.URL +  ' #allRoles');
        }
    })
  }})
    })


</script>

<!-- Delete Roles Ajax End -->
<!-- Delete Permissions Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deletePermission',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this role?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('admin.deletePermission')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deletePermission',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Permission has been deleted successfully!',
			  'success'
			)
            $('#allPermissions').load(document.URL +  ' #allPermissions');
        }
    })
  }})
    })


</script>

<!-- Delete Permissions Ajax End -->
<!-- Inactive User Ajax Start -->
<script type="text/javascript">
$(document).on('click','.deleteUser',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to In-Active this user?',
  text: "You can revert it back!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, inactivate it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('users.inactiveUser')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'inactiveUser',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'User has been inactivated successfully!',
			  'success'
			)
            $('#allUsers').load(document.URL +  ' #allUsers');
        }
    })
  }})
    })


</script>

<!-- Inactive User Ajax End -->
<!-- Active User Ajax Start -->
<script type="text/javascript">
$(document).on('click','.activeUser',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to Active this user?',
  text: "You can revert it back!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, activate it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('users.activeUser')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'activeUser',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'User has been activated successfully!',
			  'success'
			)
            $('#allUsers').load(document.URL +  ' #allUsers');
        }
    })
  }})
    })


</script>

<!-- Active User Ajax End -->
<!-- Archieve Project Start -->
<script type="text/javascript">
$(document).on('click','.deleteProject',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to archive this project?',
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
        data: {type:'archiveProject',id:id},
        success: function(res){
           	Swal.fire(
			  'Archived!',
			  'Project has been archived!',
			  'success'
			)
            $('#allProjects').load(document.URL +  ' #allProjects');
        }
    })
  }})
    })


</script>

<!-- Archieve Project End -->
<!-- Delete Team Start -->
<script type="text/javascript">
$(document).on('click','.deleteTeam',function(e){
    e.preventDefault();
    var id = $(this).attr('rel');
    Swal.fire({
  title: 'Are you sure you want to delete this team?',
  text: "You can revert it back!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('admin.deleteTeam')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'deleteTeam',id:id},
        success: function(res){
           	Swal.fire(
			  'Deleted!',
			  'Team has been deleted!',
			  'success'
			)
            $('#allTeams').load(document.URL +  ' #allTeams');
        }
    })
  }})
    })


</script>

<!-- Delete Team End -->
<!-- Checkout User Start -->
<script type="text/javascript">
$(document).on('click','.timeout',function(e){
    e.preventDefault();
    var timein = $(this).attr('rel')+"000";
    var now = new Date().getTime();
    var remaining = timein-now;
    var hours = Math.floor((remaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((remaining % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
    Swal.fire({
  title: 'Are you sure you want to timeout?',
  text: "Hours Remaining (0"+hours+":"+minutes+":"+seconds+") .You cannot revert it back!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        url: "{{route('attendance.timeOut')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {type:'timeout'},
        success: function(res){
           	Swal.fire(
			  'Timedout!',
			  'You are timedout successfully!',
			  'success'
			)
            $('#attendancedetails').load(document.URL +  ' #attendancedetails');
        }
    })
  }})
    })


</script>
<!-- Checkout User End -->
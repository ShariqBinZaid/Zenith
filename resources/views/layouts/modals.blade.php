<!-- ________________________________________________LEADS________________________________________________________ -->

<!-- Edit Lead Modal Start -->
<div class="modal fade" id="EditLeadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditLeadModalLabel">Update Lead</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="updateleadform">
      <div class="modal-body">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Username:</label>
            <input type="text" class="form-control leadusername" id="leadusername" name="name">
            <input type="hidden" name="id" id="leadid" class="leadid"/>
            {{@csrf_field()}}
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Email:</label>
            <input type="text" class="form-control leademail"  id="leademail" name="email" disabled>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Phone:</label>
            <input type="text" class="form-control leadphone" id="leadphone" name="phone" disabled>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Brand:</label>
            <select class="form-control brand_id" name="brand_id" id="brand_id">
                <option value="1">Brand 1</option>
                <option value="2">Brand 2</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary updateleadsubmit">Update</button>
      </div>
      
      </form>
    </div>
  </div>
</div>
<script>
    var EditLeadModal = document.getElementById('EditLeadModal')
    EditLeadModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var leadidval = button.getAttribute('data-bs-leadid')
    var leademailval = button.getAttribute('data-bs-email')
    var leadusernameval = button.getAttribute('data-bs-leadusername')
    var brand_idval = button.getAttribute('data-bs-brand_id')
    var leadphoneval = button.getAttribute('data-bs-leadphone')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var leademail = EditLeadModal.querySelector('.leademail')
    var leadid = EditLeadModal.querySelector('.leadid')
    var leadusername = EditLeadModal.querySelector('.leadusername')
    var brand_id = EditLeadModal.querySelector('.brand_id')
    var leadphone = EditLeadModal.querySelector('.leadphone')
    
    leademail.value = leademailval
    leadid.value = leadidval
    leadusername.value = leadusernameval
    brand_id.value = brand_idval
    leadphone.value = leadphoneval
    })
    $('.updateleadsubmit').on('click',function(e){
    e.preventDefault();
    var form = $('.updateleadform').serialize();
      var formdata = 'updateleadform';
      $.ajax({
        url: "{{route('lead.updatelead')}}",
        type: 'POST',
        data: form+"&type="+formdata,
        success: function(res){
           	Swal.fire(
			  'Thank You!',
			  'Lead has been updated successfully!',
			  'success'
			)
            $('#allleads').load(document.URL +  ' #allleads');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            var errors = XMLHttpRequest['responseJSON']['errors'];
            var response = JSON.parse(XMLHttpRequest.responseText);
            var errorString = '<ul>';
            $.each( response.errors, function( key, value) {
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
      })
    })

</script>
<!-- Edit Lead Modal End -->
<!-- Show Lead Modal Start -->
<div class="modal fade" id="ShowLeadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ShowLeadModalLabel">Details of this Lead</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body showleaddetails">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Username:</label><span class="leadusername"></span>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Email:</label><span class="leademail"></span>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Phone:</label><span class="leadphone"></span>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Brand:</label><span class="brand_id"></span>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">URL:</label><span class="url"></span>
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
  
  var ShowLeadModal = document.getElementById('ShowLeadModal')
  ShowLeadModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var leademailval = button.getAttribute('data-bs-email')
    var leadusernameval = button.getAttribute('data-bs-leadusername')
    var brand_idval = button.getAttribute('data-bs-brand_id')
    var leadphoneval = button.getAttribute('data-bs-leadphone')
    var leadurl = button.getAttribute('data-bs-url')
    var leadcreated_at = button.getAttribute('data-bs-created_at')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var leademail = ShowLeadModal.querySelector('.leademail')
    var leadusername = ShowLeadModal.querySelector('.leadusername')
    var brand_id = ShowLeadModal.querySelector('.brand_id')
    var leadphone = ShowLeadModal.querySelector('.leadphone')
    var url = ShowLeadModal.querySelector('.url')
    var created_at = ShowLeadModal.querySelector('.created_at')
    leademail.textContent = leademailval
    leadusername.textContent = leadusernameval
    brand_id.textContent = brand_idval
    leadphone.textContent = leadphoneval
    url.textContent = leadurl
    created_at.textContent = leadcreated_at
    })
</script>
<!-- Show Lead Modal End -->

<!-- ________________________________________________OPPORTUNITIES________________________________________________________ -->



<!-- ________________________________________________BRANDS________________________________________________________ -->

<!-- Edit Brands Modal Start -->
<div class="modal fade" id="EditbrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditbrandModalLabel">Update Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updatebrandform" enctype="multipart/form-data" action="{{route('brands.updateBrand')}}" method="POST">
      <div class="modal-body">
      <img src="" class="brandimage">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="recipient-name" class="col-form-label">Brand Name:</label>
            <input type="text" class="form-control brandname" id="brandname" name="name">
            <input type="hidden" name="id" id="brandid" class="brandid"/>
            <input type="hidden" name="oldlinkimage" id="oldlinkimage" class="oldlinkimage"/>
            
            {{@csrf_field()}}
          </div>
          
          <div class="mb-3 col-md-6">
            <label for="message-text" class="col-form-label">Brand Type:</label>
            <select class="form-control brandtype" name="type" id="brandtype">
                <option selected disabled>Choose the Brand Type...</option>
                <option value="Design">Design</option>
                <option value="E-Book">E-Book</option>
                <option value="Mobile Apps">Mobile Apps</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="message-text" class="col-form-label">Brand URL:</label>
            <input type="text" class="form-control brandurl" id="brandurl" name="url">
          </div>
          <div class="mb-3 col-md-6">
            <label for="message-text" class="col-form-label">Brand Initials:</label>
            <input type="text" class="form-control brandinitials" id="brandinitials" name="initials">
          </div>
        </div>
        <div class="mb-3 ">
            <label for="message-text" class="col-form-label">Brand Image:</label>
            <input type="file" class="form-control"  id="brandimage" name="image">
          </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary updatebrandsubmit">Update</button>
      </div>
      
      </form>
    </div>
  </div>
</div>
<script>
    var EditbrandModal = document.getElementById('EditbrandModal')
    EditbrandModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var brandidval = button.getAttribute('data-bs-id')
    var brandnameval = button.getAttribute('data-bs-name')
    var brandimageval = button.getAttribute('data-bs-image')
    var brandurlval = button.getAttribute('data-bs-url')
    var initialsval = button.getAttribute('data-bs-initials')
    var brandtypeval = button.getAttribute('data-bs-type')
    var oldimagelinkval = button.getAttribute('data-bs-oldimagelink')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var brandid = EditbrandModal.querySelector('.brandid')
    var brandname = EditbrandModal.querySelector('.brandname')
    var brandimage = EditbrandModal.querySelector('.brandimage')
    var brandurl = EditbrandModal.querySelector('.brandurl')
    var brandinitials = EditbrandModal.querySelector('.brandinitials')
    var brandtype = EditbrandModal.querySelector('.brandtype')
    var oldlinkimage = EditbrandModal.querySelector('.oldlinkimage')
    
    brandid.value = brandidval
    brandname.value = brandnameval
    brandimage.src = brandimageval
    oldlinkimage.value = oldimagelinkval
    brandurl.value = brandurlval
    brandinitials.value = initialsval
    brandtype.value = brandtypeval
    })
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $('#updatebrandform').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        

        $.ajax({
            type:'POST',
            url: "{{route('brands.updateBrand')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
              Swal.fire(
                'Thank You!',
                'Brand has been updated successfully!',
                'success'
              )
            $('#allBrands').load(document.URL +  ' #allBrands');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
              var errors = XMLHttpRequest['responseJSON']['errors'];
              var response = JSON.parse(XMLHttpRequest.responseText);
              var errorString = '<ul>';
              $.each( response.errors, function( key, value) {
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
<!-- Edit brand Modal End -->
<!-- Show brand Modal Start -->
<div class="modal fade" id="ShowbrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ShowbrandModalLabel">Details of this Brand</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body showbranddetails">
      <div class="mb-3">
      <image class="brandimage"/></div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Name:</label><span class="brandname"></span>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">URL:</label><span class="brandurl"></span>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Type:</label><span class="brandtype"></span>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Initials:</label><span class="brandinitials"></span>
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
  var ShowbrandModal = document.getElementById('ShowbrandModal')
  ShowbrandModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var brandnameval = button.getAttribute('data-bs-name')
  var brandtypeval = button.getAttribute('data-bs-type')
  var brandurlval = button.getAttribute('data-bs-url')
  var brandinitialsval = button.getAttribute('data-bs-initials')
  var brandimageval = button.getAttribute('data-bs-image')
  var brandcreated_at = button.getAttribute('data-bs-created_at')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var brandname = ShowbrandModal.querySelector('.brandname')
  var brandurl = ShowbrandModal.querySelector('.brandurl')
  var brandimage = ShowbrandModal.querySelector('.brandimage')
  var brandinitials = ShowbrandModal.querySelector('.brandinitials')
  var brandtype = ShowbrandModal.querySelector('.brandtype')
  var created_at = ShowbrandModal.querySelector('.created_at')
  brandname.textContent = brandnameval
  brandtype.textContent = brandtypeval
  brandurl.textContent = brandurlval
  brandinitials.textContent = brandinitialsval
  brandimage.src = brandimageval
  created_at.textContent = brandcreated_at
  })
</script>
<!-- Show Brands Modal End -->


<!-- ________________________________________________PACKAGES________________________________________________________ -->

<!-- Edit Packages Modal Start -->
<!-- <div class="modal fade" id="EditPackageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditPackageModalLabel">Update Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updatepackageform"  action="{{route('packages.updatePackage')}}" method="POST">
      <div class="modal-body">
      <img src="" class="brandimage">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="recipient-name" class="col-form-label">Package Name:</label>
            <input type="text" class="form-control brandname" id="brandname" name="name">
            <input type="hidden" name="id" id="brandid" class="brandid"/>
            
            {{@csrf_field()}}
          </div>
          <div class="mb-3 col-md-6">
            <label for="message-text" class="col-form-label">Package Type:</label>
            <select class="form-control brandtype" name="type" id="brandtype">
                <option selected disabled>Choose the Brand Type...</option>
                <option value="Design">Design</option>
                <option value="E-Book">E-Book</option>
                <option value="Mobile Apps">Mobile Apps</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="message-text" class="col-form-label">Brand URL:</label>
            <input type="text" class="form-control brandurl" id="brandurl" name="url">
          </div>
          <div class="mb-3 col-md-6">
            <label for="message-text" class="col-form-label">Brand Initials:</label>
            <input type="text" class="form-control brandinitials" id="brandinitials" name="initials">
          </div>
        </div>
        <div class="mb-3 ">
            <label for="message-text" class="col-form-label">Brand Image:</label>
            <input type="file" class="form-control"  id="brandimage" name="image">
          </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary updatebrandsubmit">Update</button>
      </div>
      
      </form>
    </div>
  </div>
</div>
<script>
    var EditbrandModal = document.getElementById('EditbrandModal')
    EditbrandModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var brandidval = button.getAttribute('data-bs-id')
    var brandnameval = button.getAttribute('data-bs-name')
    var brandimageval = button.getAttribute('data-bs-image')
    var brandurlval = button.getAttribute('data-bs-url')
    var initialsval = button.getAttribute('data-bs-initials')
    var brandtypeval = button.getAttribute('data-bs-type')
    var oldimagelinkval = button.getAttribute('data-bs-oldimagelink')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var brandid = EditbrandModal.querySelector('.brandid')
    var brandname = EditbrandModal.querySelector('.brandname')
    var brandimage = EditbrandModal.querySelector('.brandimage')
    var brandurl = EditbrandModal.querySelector('.brandurl')
    var brandinitials = EditbrandModal.querySelector('.brandinitials')
    var brandtype = EditbrandModal.querySelector('.brandtype')
    var oldlinkimage = EditbrandModal.querySelector('.oldlinkimage')
    
    brandid.value = brandidval
    brandname.value = brandnameval
    brandimage.src = brandimageval
    oldlinkimage.value = oldimagelinkval
    brandurl.value = brandurlval
    brandinitials.value = initialsval
    brandtype.value = brandtypeval
    })
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $('#updatebrandform').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        

        $.ajax({
            type:'POST',
            url: "{{route('brands.updateBrand')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
              Swal.fire(
                'Thank You!',
                'Brand has been updated successfully!',
                'success'
              )
            $('#allBrands').load(document.URL +  ' #allBrands');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
              var errors = XMLHttpRequest['responseJSON']['errors'];
              var response = JSON.parse(XMLHttpRequest.responseText);
              var errorString = '<ul>';
              $.each( response.errors, function( key, value) {
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


</script> -->
<!-- Edit Packages Modal End -->
<!-- Show Packages Modal Start -->
<div class="modal fade" id="ShowPackageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ShowPackageModalLabel">Details of this Package</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body showbranddetails">
      <div class="mb-3">
      <image class="brandimage"/></div>
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
  ShowPackageModal.addEventListener('show.bs.modal', function (event) {
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
<!-- Show Packages Modal End -->

<!-- ------------------------------------------Packages Types--------------------------------------->

<!-- Show Packages Types Modal Start -->

<div class="modal fade" id="ShowPackageTypesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ShowPackageTypesModalLabel">Details of this Package Types</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body showbranddetails">
      <div class="mb-3">
      <image class="brandimage"/></div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Name:</label><span class="pkgname"></span>
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
  var ShowPackageModal = document.getElementById('ShowPackageTypesModal')
  ShowPackageModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var nameval = button.getAttribute('data-bs-name')
  var pkgcreated_at = button.getAttribute('data-bs-created_at')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var pkgname = ShowPackageModal.querySelector('.pkgname')
  var created_at = ShowPackageModal.querySelector('.created_at')
  
  pkgname.textContent = nameval
  created_at.textContent = pkgcreated_at
  })
</script>

<!-- Show Packages Types Modal End -->


<!-- ------------------------------------------Roles--------------------------------------->
<!-- Edit Roles Modal Start -->
<div class="modal fade" id="EditRolesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditRoleModalLabel">Update Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateroleform">
      <div class="modal-body">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="recipient-name" class="col-form-label">Role Name:</label>
            <input type="text" class="form-control rolename" id="rolename" name="name">
            <input type="hidden" name="id" id="roleid" class="roleid"/>
            {{@csrf_field()}}
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary updaterolesubmit">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
    var EditRolesModal = document.getElementById('EditRolesModal')
    EditRolesModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var roleidval = button.getAttribute('data-bs-id')
    var rolenameval = button.getAttribute('data-bs-name')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var roleid = EditRolesModal.querySelector('.roleid')
    var rolename = EditRolesModal.querySelector('.rolename')
    
    roleid.value = roleidval
    rolename.value = rolenameval
    })
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $('#updateroleform').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{route('admin.updateRole')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
              Swal.fire(
                'Thank You!',
                'Role has been updated successfully!',
                'success'
              )
            $('#allRoles').load(document.URL +  ' #allRoles');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
              var errors = XMLHttpRequest['responseJSON']['errors'];
              var response = JSON.parse(XMLHttpRequest.responseText);
              var errorString = '<ul>';
              $.each( response.errors, function( key, value) {
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
<!-- Edit Roles Modal End -->

<!-- ------------------------------------------Permissions------------------------------------- -->
<!-- Edit Permissions Modal Start -->
<div class="modal fade" id="EditPermissionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditPermissionModalLabel">Update Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updatepermissionsform">
      <div class="modal-body">
        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="recipient-name" class="col-form-label">Role Name:</label>
            <input type="text" class="form-control permissionname" id="permissionname" name="name">
            <input type="hidden" name="id" id="permissionid" class="permissionid"/>
            {{@csrf_field()}}
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary updatepermissionsubmit">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script>
    var EditPermissionModal = document.getElementById('EditPermissionModal')
    EditPermissionModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var permissionidval = button.getAttribute('data-bs-id')
    var permissionnameval = button.getAttribute('data-bs-name')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var permissionid = EditPermissionModal.querySelector('.permissionid')
    var permissionname = EditPermissionModal.querySelector('.permissionname')
    
    permissionid.value = permissionidval
    permissionname.value = permissionnameval
    })
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $('#updatepermissionsform').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{route('admin.updatePermission')}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
              Swal.fire(
                'Thank You!',
                'Permission has been updated successfully!',
                'success'
              )
            $('#allPermissions').load(document.URL +  ' #allPermissions');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
              var errors = XMLHttpRequest['responseJSON']['errors'];
              var response = JSON.parse(XMLHttpRequest.responseText);
              var errorString = '<ul>';
              $.each( response.errors, function( key, value) {
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


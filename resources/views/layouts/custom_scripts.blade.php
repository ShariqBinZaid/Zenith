<!--CK EDITOR SCRIPT START-->
<script type="text/javascript">
  


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
  title: 'Are you sure you want to Timeout?',
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
            //$('#attendancedetails').load(document.URL +  '#attendancedetails');
            location.reload();
        }
    })
  }})
    })
</script>

<!-- Checkout User End -->
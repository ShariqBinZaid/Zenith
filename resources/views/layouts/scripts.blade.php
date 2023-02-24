<script src="{{asset('service-worker.js')}}"></script>
<script src="{{asset('libs/bundle.js')}}"></script>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>

<!-- Apex chart -->
<script src="{{asset('libs/charts/apex/apexcharts.min.js')}}"></script>

<!-- Slick -->
<script src="{{asset('libs/slick/slick.min.js')}}"></script>

<!-- Examples -->
<script src="{{asset('js/examples/dashboard.js')}}"></script>

<!-- Main Javascript file -->
<script src="{{asset('js/app.min.js')}}"></script>


    <!-- Examples -->
    <script src="{{asset('js/examples/customers.js')}}"></script>

<!-- Prism -->
<script src="{{asset('libs/prism/prism.js')}}"></script>
<script src="{{asset('libs/lightbox/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('libs/ckeditor5/ckeditor.js')}}"></script>
<!-- Examples -->

<link rel="stylesheet" href="{{asset('libs/dropzone/dropzone.css')}}" type="text/css">
<input type="hidden" class="userid" value="{{auth()->user()->id?? null}}"/>
<!-- Javascript -->
<script src="{{asset('libs/dropzone/dropzone.js')}}"></script>
<script type="text/javascript">
      
      
      var userId = $('.userid').val();
      // if (notificationsCount <= 0) {
      //   notificationsWrapper.hide();
      // }

      // Enable pusher logging - don't include this in production
      // Pusher.logToConsole = true;

      var pusher = new Pusher('1ffe0e82aee820f60bbe', {
        encrypted: true
      });

      // Subscribe to the channel we specified in our Laravel Event
      var leadAssignChannel = pusher.subscribe('lead-assign-'+userId);
      // Bind a function to a Event (the full Laravel class)
      leadAssignChannel.bind('App\\Events\\LeadAssign', function(data) {
        var existingNotifications = $('ul.leadassignnotify').html();
        var notificationsCount = parseInt($('.nav-link-notify').attr('data-count'));
        var newNotificationHtml = `
        <li class="px-0 list-group-item">
                            <a href="{{route('lead.allLeads')}}" class="d-flex">
                                <div class="flex-shrink-0">
                                    <figure class="avatar avatar-info me-3">
                                            <span class="avatar-text rounded-circle">
                                                <i class="bi bi-person"></i>
                                            </span>
                                    </figure>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-bold d-flex justify-content-between">
                                        `+data.notify.message+`
                                    </p>
                                    <span class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> Just Now
                                    </span>
                                </div>
                            </a>
                        </li>
        `;
        $('ul.leadassignnotify').html(newNotificationHtml + existingNotifications);
        $('.leadassignnotifytab').addClass('nav-link-notify');
        notificationsCount+=1;
        $('.nav-link-notify').attr('data-count',notificationsCount);
        const audio = new Audio("{{ asset('sound/notialert2.wav') }}");
        audio.play();
      });
      var opportunityAssignChannel = pusher.subscribe('opportunity-assign-' + userId);
      // Bind a function to a Event (the full Laravel class)
      opportunityAssignChannel.bind('App\\Events\\OpportunityAssign', function(data) {
        var existingNotifications = $('.opportunityassignnotify').html();
        var notificationsCount = parseInt($('.nav-link-notify').attr('data-count'));
        var newNotificationHtml = `
        <li class="px-0 list-group-item">
                            <a href="{{route('opportunity.allOpportunities')}}" class="d-flex">
                                <div class="flex-shrink-0">
                                    <figure class="avatar avatar-info me-3">
                                            <span class="avatar-text rounded-circle">
                                                <i class="bi bi-briefcase"></i>
                                            </span>
                                    </figure>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-bold d-flex justify-content-between">
                                        `+data.notify.message+`
                                    </p>
                                    <span class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> Just Now
                                    </span>
                                </div>
                            </a>
                        </li>
        `;
        $('.opportunityassignnotify').html(newNotificationHtml + existingNotifications);
        $('.opportunityassignnotifytab').addClass('nav-link-notify');
        notificationsCount+=1;
        $('.nav-link-notify').attr('data-count',notificationsCount);
        const audio = new Audio("{{ asset('sound/notialert2.wav') }}");
        audio.play();
      });
      function get_time_diff( datetime )
      {
          var datetime = typeof datetime !== 'undefined' ? datetime : "2014-01-01 01:02:03.123456";

          var datetime = new Date( datetime ).getTime();
          var now = new Date().getTime();

          if( isNaN(datetime) )
          {
              return "";
          }

          console.log( datetime + " " + now);

          if (datetime < now) {
              var milisec_diff = now - datetime;
          }else{
              var milisec_diff = datetime - now;
          }

          var days = Math.floor(milisec_diff / 1000 / 60 / (60 * 24));

          var date_diff = new Date( milisec_diff );

          return days + " Days "+ date_diff.getHours() + " Hours " + date_diff.getMinutes() + " Minutes " + date_diff.getSeconds() + " Seconds";
      }
    </script>
@include('layouts.modals')
@include('layouts.custom_scripts')
@stack('scripts')

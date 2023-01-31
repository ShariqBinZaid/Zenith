<script src="{{asset('libs/bundle.js')}}"></script>

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

<!-- Javascript -->
<script src="{{asset('libs/dropzone/dropzone.js')}}"></script>
@include('layouts.modals')
@include('layouts.custom_scripts')
@stack('scripts')
<!--**********************************
                Main wrapper end
            ***********************************-->

<!--**********************************
                Scripts
            ***********************************-->
<!-- Required vendors -->
<script>
    window.addEventListener('load', function () {
        $('#spiner').css('display', 'none'); 
    });
</script>
<script src="{{ url('admin') }}/vendor/global/global.min.js"></script>
<script src="{{ url('admin') }}/vendor/chart-js/chart.bundle.min.js"></script>
<script src="{{ url('admin') }}/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="{{ url('admin') }}/vendor/apexchart/apexchart.js"></script>

<!-- Dashboard 1 -->
<!-- <script src="{{ url('admin') }}/js/dashboard/dashboard-1.js"></script> -->
<script src="{{ url('admin') }}/vendor/draggable/draggable.js"></script>
<script src="{{ url('admin') }}/vendor/swiper/js/swiper-bundle.min.js"></script>
<script src="{{ url('admin') }}/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="{{ url('admin') }}/vendor/datatables/js/dataTables.buttons.min.js"></script>
<script src="{{ url('admin') }}/vendor/datatables/js/buttons.html5.min.js"></script>
<script src="{{ url('admin') }}/vendor/datatables/js/jszip.min.js"></script>
<script src="{{ url('admin') }}/js/plugins-init/datatables.init.js"></script>

<!-- Apex Chart -->

<script src="{{ url('admin') }}/vendor/bootstrap-datetimepicker/js/moment.js"></script>
<script src="{{ url('admin') }}/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- Vectormap -->
<script src="{{ url('admin') }}/vendor/jqvmap/js/jquery.vmap.min.js"></script>
<script src="{{ url('admin') }}/vendor/jqvmap/js/jquery.vmap.world.js"></script>
<script src="{{ url('admin') }}/vendor/jqvmap/js/jquery.vmap.usa.js"></script>
<script src="{{ url('admin') }}/js/custom.min.js"></script>



<!-- <script src="{{ url('admin') }}/js/deznav-init.js"></script> -->

<script src="{{ url('admin') }}/js/demo.js"></script>
<script type="text/javascript" src="https://parsleyjs.org/dist/parsley.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    @if (session('success'))
        var type = 'success';
        switch (type) {
            case 'success':
                toastr.success("{{ session('success') }}");
                break;
        }
    @endif
    @if (session('error'))
        var type = 'error';
        switch (type) {
            case 'error':
                toastr.error("{{ session('error') }}");
                break;
        }
    @endif
</script>

</body>

</html>

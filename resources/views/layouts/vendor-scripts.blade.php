<!-- jQuery 3 -->
<script src="{{ URL::asset('build/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::asset('build/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- PACE -->
<script src="{{ URL::asset('build/bower_components/pace/pace.min.js') }}"></script>
<!-- TOASTR -->
<script src="{{ URL::asset('build/plugins/toastr/toastr.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ URL::asset('build/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ URL::asset('build/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('build/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ URL::asset('build/dist/js/demo.js') }}"></script>

<script type="text/javascript">
    @if (session()->has('success'))
        toastr.success('{{ session('success') }}')
    @elseif (session()->has('error'))
        toastr.error('{{ session('error') }}')
    @endif

    // To make Pace works on Ajax calls
    $(document).ajaxStart(function() {
        Pace.restart()
    })
    $('.ajax').click(function() {
        $.ajax({
            url: '#',
            success: function(result) {
                $('.ajax-content').html('<hr>Ajax Request Completed !')
            }
        })
    })
</script>
@stack('script')
@yield('script')
@yield('script-bottom')

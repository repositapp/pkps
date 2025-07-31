<!-- Bootstrap Bundle Js -->
<script src="{{ URL::asset('dist/vender/bootstrap/js/bootstrap.bundle.min.js') }}" type="bfe746cb187ffc8b145a0dbf-text/javascript"></script>
<!-- Jquery Js -->
<script src="{{ URL::asset('dist/vender/jquery/jquery.min.js') }}" type="bfe746cb187ffc8b145a0dbf-text/javascript"></script>
<!-- Slick Slider Js -->
<script src="{{ URL::asset('dist/vender/slick/slick/slick.min.js') }}" type="bfe746cb187ffc8b145a0dbf-text/javascript"></script>
<!-- Quantity Custom Js -->
<script src="{{ URL::asset('dist/js/quantity.js') }}" type="bfe746cb187ffc8b145a0dbf-text/javascript"></script>
<!-- Custom Js -->
<script src="{{ URL::asset('dist/js/script.js') }}" type="bfe746cb187ffc8b145a0dbf-text/javascript"></script>
<script src="{{ URL::asset('dist/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"
    data-cf-settings="bfe746cb187ffc8b145a0dbf-|49" defer></script>

<!-- TOASTR -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ URL::asset('build/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };

    @if (session()->has('success'))
        toastr.success('{{ session('success') }}')
    @elseif (session()->has('error'))
        toastr.error('{{ session('error') }}')
    @endif
</script>
@yield('script')

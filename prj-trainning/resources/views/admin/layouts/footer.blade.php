<script>
    // sau 5s thong bao bien mat
    if( $(".alert").text() != ''){
        setTimeout(() =>{
            $(".alert").removeClass('alert alert-danger alert-success').text('')
        }, 5000);
    }
</script>

<!-- jQuery -->
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/template/admin/dist/js/adminlte.min.js"></script>



<!-- jquery-validation -->
<script src="/template/admin/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/template/admin/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE for demo purposes -->
{{--<script src="/template/admin/dist/js/demo.js"></script>--}}
<!-- Page specific script -->

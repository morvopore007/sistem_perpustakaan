<script src="<?php echo e(asset('backend/custom_downloaded_file/axios.min.js')); ?>"></script>


<script src="<?php echo e(asset('backend/plugins/jquery/jquery.min.js')); ?>"></script>


<script src="<?php echo e(asset('backend/plugins/bootstrap/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>


<script src="<?php echo e(asset('backend/plugins/sidemenu/sidemenu.js')); ?>"></script>


<script src="<?php echo e(asset('backend/plugins/p-scroll/perfect-scrollbar.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/p-scroll/pscroll.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/sticky.js')); ?>"></script>


<script src="<?php echo e(asset('backend/plugins/summernote-editor/summernote1.js')); ?>"></script>
<script src="<?php echo e(asset('backend/js/summernote.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/dropify.min.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/toastr.min.js')); ?>"></script>


<script src="<?php echo e(asset('backend/plugins/datatable/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/js/dataTables.bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/js/butsns.bootstrap5.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/js/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/pdfmake/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/pdfmake/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/js/butsns.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/js/buttons.colVis.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/datatable/responsive.bootstrap5.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/js/table-data.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/apexcharts.js')); ?>"></script>


<script src="<?php echo e(asset('backend/plugins/select2/select2.full.min.js')); ?>"></script>


<script src="<?php echo e(asset('backend/plugins/circle-progress/circle-progress.min.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/index1.js')); ?>"></script>
<script src="<?php echo e(asset('backend/js/index.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/reply.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/themeColors.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/custom.js')); ?>"></script>


<script src="<?php echo e(asset('backend/switcher/js/switcher.js')); ?>"></script>


<script src="<?php echo e(asset('backend/js/sweetalert2@11.js')); ?>"></script>


<script>
    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        toastr.options.positionClass = 'toast-top-right';

        <?php if(Session::has('t-success')): ?>
            toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': true,
            'progressBar': true,
            'positionClass': 'toast-top-right',
            'preventDuplicates': false,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        };
        toastr.success("<?php echo e(session('t-success')); ?>");
        <?php endif; ?>

            <?php if(Session::has('t-error')): ?>
            toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': true,
            'progressBar': true,
            'positionClass': 'toast-top-right',
            'preventDuplicates': false,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        };
        toastr.error("<?php echo e(session('t-error')); ?>");
        <?php endif; ?>

            <?php if(Session::has('t-info')): ?>
            toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': true,
            'progressBar': true,
            'positionClass': 'toast-top-right',
            'preventDuplicates': false,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        };
        toastr.info("<?php echo e(session('t-info')); ?>");
        <?php endif; ?>

            <?php if(Session::has('t-warning')): ?>
            toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': true,
            'progressBar': true,
            'positionClass': 'toast-top-right',
            'preventDuplicates': false,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        };
        toastr.warning("<?php echo e(session('t-warning')); ?>");
        <?php endif; ?>
    });
</script>



<script>
    $(document).ready(function() {
        $('.dropify').dropify();

        $('#logo').on('dropify.afterClear', function(event, element) {
            $('input[name="remove_logo"]').val('1');
        });

        $('#favicon').on('dropify.afterClear', function(event, element) {
            $('input[name="remove_favicon"]').val('1');
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            tabsize: 2,
            height: 220,
        });
    });
</script>


<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/partials/scripts.blade.php ENDPATH**/ ?>
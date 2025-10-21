<?php $__env->startSection('title', '404 Not Found'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-content error-page error2">
    <div class="container text-center">
        <div class="error-template">
            <h2 class="text-white mb-2">404<span class="fs-20">error</span></h2>
            <h5 class="error-details text-white">
                Oops! Some error has occured, Requested page not found!
            </h5>
            <div class="text-center">
                <a class="btn btn-primary mt-5 mb-5" href="<?php echo e(route('dashboard')); ?>"> <i class="fa fa-long-arrow-left"></i> Back to Dashboard </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.minimal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/errors/404.blade.php ENDPATH**/ ?>
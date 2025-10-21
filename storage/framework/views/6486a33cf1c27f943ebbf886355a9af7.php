<!doctype html>
<html lang="en" dir="ltr">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="bdCalling IT Ltd.">
    <meta name="keywords" content="pure_water_innovation">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <?php echo $__env->make('auth.partials.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body class="ltr login-img">

    
    <?php echo $__env->make('auth.partials.switch', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    

    
    <div id="global-loader">
        <img src=" <?php echo e(asset('backend')); ?>/images/loader.svg" class="loader-img" alt="Loader">
    </div>

    
    <?php echo $__env->make('auth.partials.switch-icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    

    <!-- PAGE -->
    <div class="page">
        <div>
            
            <?php echo $__env->make('auth.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            

            <div class="container-login100">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
    <!-- End PAGE -->

    <?php echo $__env->make('auth.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>


</html>
<?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/auth/app.blade.php ENDPATH**/ ?>
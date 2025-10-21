<!doctype html>
<html lang="en" dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="author" content="bdCalling IT Ltd.">
		<meta name="keywords" content="laravel admin template, bootstrap admin template, admin dashboard template, admin dashboard, admin template, admin, bootstrap 5, laravel admin, laravel admin dashboard template, laravel ui template, laravel admin panel, admin panel, laravel admin dashboard, laravel template, admin ui dashboard">

        <!-- TITLE -->
		<title><?php echo $__env->yieldContent('title'); ?></title>

        <?php echo $__env->make('auth.partials.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </head>


        <body class="ltr error-bg">


        <!-- Switcher-->
        <!-- Switcher -->
        <?php echo $__env->make('auth.partials.switch', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End Switcher -->
        <!-- Switcher-->

            <!-- GLOBAL-LOADER -->
            <div id="global-loader">
                <img src="<?php echo e(asset('backend/images/loader.svg')); ?> " class="loader-img" alt="Loader">
            </div>

            <!-- Switcher Icon-->
            <?php echo $__env->make('auth.partials.switch-icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


		<!-- PAGE -->
		<div class="page">
            <!-- PAGE-CONTENT OPEN -->
            <?php echo $__env->yieldContent('content'); ?>
             <!-- PAGE-CONTENT OPEN CLOSED -->
         </div>
         <!-- End PAGE -->


      <?php echo $__env->make('auth.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </body>
</html>
<?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/errors/minimal.blade.php ENDPATH**/ ?>
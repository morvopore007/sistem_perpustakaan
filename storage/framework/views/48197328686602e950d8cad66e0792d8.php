<?php
    $systemSetting = App\Models\SystemSetting::first();
?>

<div class="col col-login mx-auto text-center">
    <a href="<?php echo e(route('welcome')); ?>">
        <img src="<?php echo e(isset($systemSetting->logo) && !empty($systemSetting->logo) ? asset($systemSetting->logo) : asset('frontend/eVento_logo.png')); ?>"
            class="header-brand-img" alt="">
    </a>
</div>
<?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/auth/partials/header.blade.php ENDPATH**/ ?>
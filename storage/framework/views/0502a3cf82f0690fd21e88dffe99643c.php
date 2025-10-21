<?php
    $systemSetting = App\Models\SystemSetting::first();
?>

<!-- FAVICON -->
<link rel="shortcut icon" type="image/x-icon"
    href="<?php echo e(isset($systemSetting->favicon) && !empty($systemSetting->favicon) ? asset($systemSetting->favicon) : asset('frontend/eVento_Favicon.png')); ?>" />

<!-- BOOTSTRAP CSS -->
<link id="style" href="<?php echo e(asset('backend')); ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

<!-- STYLE CSS -->
<link href="<?php echo e(asset('backend')); ?>/css/style.css" rel="stylesheet" />
<link href="<?php echo e(asset('backend')); ?>/css/skin-modes.css" rel="stylesheet" />



<!--- FONT-ICONS CSS -->
<link href="<?php echo e(asset('backend')); ?>/plugins/icons/icons.css" rel="stylesheet" />

<!-- INTERNAL Switcher css -->
<link href="<?php echo e(asset('backend')); ?>/switcher/css/switcher.css" rel="stylesheet">
<link href="<?php echo e(asset('backend')); ?>/switcher/demo.css" rel="stylesheet">
<?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/auth/partials/styles.blade.php ENDPATH**/ ?>
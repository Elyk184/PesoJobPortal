<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'PESO Job Portal'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <?php if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="peso-body">
    <?php if (isset($component)) { $__componentOriginalb6bd4fee08fe683722f87df065d516a6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb6bd4fee08fe683722f87df065d516a6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-wrapper','data' => ['title' => $pageTitle ?? null,'subtitle' => $pageSubtitle ?? null,'icon' => $pageIcon ?? null,'hideAdminTopbar' => $hideAdminTopbar ?? false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageTitle ?? null),'subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageSubtitle ?? null),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageIcon ?? null),'hide-admin-topbar' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hideAdminTopbar ?? false)]); ?>
        <?php echo $__env->yieldContent('content'); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb6bd4fee08fe683722f87df065d516a6)): ?>
<?php $attributes = $__attributesOriginalb6bd4fee08fe683722f87df065d516a6; ?>
<?php unset($__attributesOriginalb6bd4fee08fe683722f87df065d516a6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb6bd4fee08fe683722f87df065d516a6)): ?>
<?php $component = $__componentOriginalb6bd4fee08fe683722f87df065d516a6; ?>
<?php unset($__componentOriginalb6bd4fee08fe683722f87df065d516a6); ?>
<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\layouts\admin-dashboard.blade.php ENDPATH**/ ?>
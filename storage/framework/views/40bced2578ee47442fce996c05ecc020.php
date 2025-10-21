

<?php $__env->startSection('title', 'Buku Saya'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Buku Saya</h1>
            <p class="page-description">Jelajahi dan cari buku yang tersedia</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('member.dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buku Saya</li>
            </ol>
        </div>
    </div>
    

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buku Tersedia</h3>
                </div>
                <div class="card-body">
                    
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Cari buku..." value="<?php echo e(request('search')); ?>">
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>

                    
                    <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <?php if($book->book_cover): ?>
                                                <img src="<?php echo e(asset('storage/' . $book->book_cover)); ?>" 
                                                     alt="<?php echo e($book->title); ?>" 
                                                     class="img-fluid rounded" 
                                                     style="height: 200px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="height: 200px;">
                                                    <i class="fe fe-book" style="font-size: 48px; color: #ccc;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <h5 class="card-title"><?php echo e(Str::limit($book->title, 30)); ?></h5>
                                        <p class="text-muted"><?php echo e($book->author); ?></p>
                                        <p class="text-muted small"><?php echo e($book->category->name ?? 'Tidak Ada Kategori'); ?></p>
                                        
                                        <div class="mb-2">
                                            <span class="badge bg-success"><?php echo e($book->available_copies); ?> Tersedia</span>
                                        </div>
                                        
                                        <a href="<?php echo e(route('member.books.show', $book)); ?>" class="btn btn-primary btn-sm">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fe fe-book" style="font-size: 64px; color: #ccc;"></i>
                                    <h4 class="mt-3">Tidak ada buku ditemukan</h4>
                                    <p class="text-muted">Coba sesuaikan kriteria pencarian Anda</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="d-flex justify-content-center">
                        <?php echo e($books->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/member/books/index.blade.php ENDPATH**/ ?>
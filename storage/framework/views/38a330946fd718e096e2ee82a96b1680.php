

<?php $__env->startSection('title', 'Peminjaman Saya'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Peminjaman Saya</h1>
            <p class="page-description">Lihat buku yang sedang Anda pinjam</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('member.dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Peminjaman Saya</li>
            </ol>
        </div>
    </div>
    

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Peminjaman Saat Ini</h3>
                    <div class="card-options">
                        <a href="<?php echo e(route('member.borrowings.history')); ?>" class="btn btn-outline-primary">
                            <i class="fe fe-clock"></i> Lihat Riwayat
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($borrowings->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Penulis</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $borrowings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrowing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($borrowing->book->book_cover): ?>
                                                        <img src="<?php echo e(asset('storage/' . $borrowing->book->book_cover)); ?>" 
                                                             alt="<?php echo e($borrowing->book->title); ?>" 
                                                             class="rounded me-3" 
                                                             style="width: 50px; height: 70px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 50px; height: 70px;">
                                                            <i class="fe fe-book text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-0"><?php echo e($borrowing->book->title); ?></h6>
                                                        <small class="text-muted"><?php echo e($borrowing->book->category->name ?? 'Tidak Ada Kategori'); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo e($borrowing->book->author); ?></td>
                                            <td><?php echo e($borrowing->borrow_date->format('d M Y')); ?></td>
                                            <td>
                                                <span class="<?php echo e($borrowing->due_date < now() ? 'text-danger' : ''); ?>">
                                                    <?php echo e($borrowing->due_date->format('d M Y')); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if($borrowing->status == 'borrowed'): ?>
                                                    <span class="badge bg-primary">Dipinjam</span>
                                                <?php elseif($borrowing->status == 'overdue'): ?>
                                                    <span class="badge bg-danger">Terlambat</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?php echo e(ucfirst($borrowing->status)); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('member.books.show', $borrowing->book)); ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fe fe-eye"></i> Lihat Buku
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        
                        <div class="d-flex justify-content-center">
                            <?php echo e($borrowings->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fe fe-book-open" style="font-size: 64px; color: #ccc;"></i>
                            <h4 class="mt-3">Tidak Ada Peminjaman Saat Ini</h4>
                            <p class="text-muted">Anda tidak memiliki buku yang sedang dipinjam saat ini.</p>
                            <a href="<?php echo e(route('member.books.index')); ?>" class="btn btn-primary">
                                <i class="fe fe-search"></i> Jelajahi Buku
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/member/borrowings/index.blade.php ENDPATH**/ ?>
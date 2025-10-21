

<?php $__env->startSection('title', 'Riwayat Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Peminjaman</h1>
            <p class="page-description">Lihat riwayat peminjaman Anda</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('member.dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('member.borrowings.index')); ?>">Peminjaman Saya</a></li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat</li>
            </ol>
        </div>
    </div>
    

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Peminjaman</h3>
                </div>
                <div class="card-body">
                    
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="from_date" class="form-control" value="<?php echo e(request('from_date')); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="to_date" class="form-control" value="<?php echo e(request('to_date')); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="<?php echo e(route('member.borrowings.history')); ?>" class="btn btn-outline-secondary">Bersihkan</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if($borrowings->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Penulis</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Tanggal Kembali</th>
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
                                            <td><?php echo e($borrowing->due_date->format('d M Y')); ?></td>
                                            <td>
                                                <?php if($borrowing->return_date): ?>
                                                    <?php echo e($borrowing->return_date->format('d M Y')); ?>

                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($borrowing->status == 'returned'): ?>
                                                    <span class="badge bg-success">Dikembalikan</span>
                                                <?php elseif($borrowing->status == 'lost'): ?>
                                                    <span class="badge bg-danger">Hilang</span>
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
                            <i class="fe fe-clock" style="font-size: 64px; color: #ccc;"></i>
                            <h4 class="mt-3">Tidak Ada Riwayat Ditemukan</h4>
                            <p class="text-muted">Tidak ada riwayat peminjaman ditemukan untuk kriteria yang dipilih.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/member/borrowings/history.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title', 'Reservasi Saya'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Reservasi Saya</h1>
            <p class="page-description">Kelola reservasi buku Anda</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('member.dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservasi Saya</li>
            </ol>
        </div>
    </div>
    

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reservasi Saya</h3>
                    <div class="card-options">
                        <a href="<?php echo e(route('member.books.index')); ?>" class="btn btn-outline-primary">
                            <i class="fe fe-search"></i> Jelajahi Buku
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                                    <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Dikonfirmasi</option>
                                    <option value="expired" <?php echo e(request('status') == 'expired' ? 'selected' : ''); ?>>Kedaluwarsa</option>
                                    <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="<?php echo e(route('member.reservations.index')); ?>" class="btn btn-outline-secondary">Bersihkan</a>
                            </div>
                        </div>
                    </form>

                    <?php if($reservations->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Penulis</th>
                                        <th>Tanggal Reservasi</th>
                                        <th>Berlaku Sampai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($reservation->book->book_cover): ?>
                                                        <img src="<?php echo e(asset('storage/' . $reservation->book->book_cover)); ?>" 
                                                             alt="<?php echo e($reservation->book->title); ?>" 
                                                             class="rounded me-3" 
                                                             style="width: 50px; height: 70px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 50px; height: 70px;">
                                                            <i class="fe fe-book text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-0"><?php echo e($reservation->book->title); ?></h6>
                                                        <small class="text-muted"><?php echo e($reservation->book->category->name ?? 'Tidak Ada Kategori'); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo e($reservation->book->author); ?></td>
                                            <td><?php echo e($reservation->reservation_date->format('d M Y')); ?></td>
                                            <td>
                                                <span class="<?php echo e($reservation->expires_at < now() ? 'text-danger' : ''); ?>">
                                                    <?php echo e($reservation->expires_at->format('d M Y H:i')); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if($reservation->status == 'pending'): ?>
                                                    <span class="badge bg-warning">Menunggu</span>
                                                <?php elseif($reservation->status == 'confirmed'): ?>
                                                    <span class="badge bg-success">Dikonfirmasi</span>
                                                <?php elseif($reservation->status == 'expired'): ?>
                                                    <span class="badge bg-danger">Kedaluwarsa</span>
                                                <?php elseif($reservation->status == 'cancelled'): ?>
                                                    <span class="badge bg-secondary">Dibatalkan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info"><?php echo e(ucfirst($reservation->status)); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?php echo e(route('member.books.show', $reservation->book)); ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fe fe-eye"></i> Lihat Buku
                                                    </a>
                                                    <?php if(in_array($reservation->status, ['pending', 'confirmed'])): ?>
                                                        <form action="<?php echo e(route('member.reservations.destroy', $reservation)); ?>" method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                                <i class="fe fe-x"></i> Batal
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        
                        <div class="d-flex justify-content-center">
                            <?php echo e($reservations->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fe fe-calendar" style="font-size: 64px; color: #ccc;"></i>
                            <h4 class="mt-3">Tidak Ada Reservasi</h4>
                            <p class="text-muted">Anda tidak memiliki reservasi buku saat ini.</p>
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

<?php echo $__env->make('backend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/member/reservations/index.blade.php ENDPATH**/ ?>
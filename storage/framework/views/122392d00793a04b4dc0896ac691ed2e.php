

<?php $__env->startSection('title', 'Reservasi'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Reservasi Buku</h1>
            <p class="page-description">Kelola reservasi buku perpustakaan</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservasi</li>
            </ol>
        </div>
    </div>
    

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="<?php echo e(route('reservations.create')); ?>" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Tambah Reservasi
            </a>
        </div>
        <div class="col-md-6 text-end">
            <span class="text-muted">Total: <?php echo e($reservations->total()); ?> reservasi</span>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Reservasi</h3>
        </div>
        <div class="card-body">
            <?php if($reservations->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pemesan</th>
                                <th>Buku</th>
                                <th>Tanggal Reservasi</th>
                                <th>Tanggal Kedaluwarsa</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration + ($reservations->currentPage() - 1) * $reservations->perPage()); ?></td>
                                <td>
                                    <strong><?php echo e($reservation->user->name); ?></strong>
                                    <br>
                                    <small class="text-muted"><?php echo e($reservation->user->email); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo e($reservation->book->title); ?></strong>
                                    <br>
                                    <small class="text-muted"><?php echo e($reservation->book->author); ?></small>
                                </td>
                                <td><?php echo e($reservation->reservation_date->format('d/m/Y')); ?></td>
                                <td><?php echo e($reservation->expires_at->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <?php switch($reservation->status):
                                        case ('pending'): ?>
                                            <span class="badge bg-warning">Menunggu</span>
                                            <?php break; ?>
                                        <?php case ('approved'): ?>
                                            <span class="badge bg-success">Disetujui</span>
                                            <?php break; ?>
                                        <?php case ('cancelled'): ?>
                                            <span class="badge bg-danger">Dibatalkan</span>
                                            <?php break; ?>
                                        <?php case ('expired'): ?>
                                            <span class="badge bg-secondary">Kedaluwarsa</span>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <span class="badge bg-secondary"><?php echo e($reservation->status); ?></span>
                                    <?php endswitch; ?>
                                </td>
                                <td><?php echo e($reservation->created_at->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('reservations.show', $reservation)); ?>" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php if($reservation->status == 'pending'): ?>
                                            <form action="<?php echo e(route('reservations.approve', $reservation)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if($reservation->status != 'cancelled' && $reservation->status != 'expired'): ?>
                                            <form action="<?php echo e(route('reservations.cancel', $reservation)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-warning btn-sm" title="Batalkan">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('reservations.edit', $reservation)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('reservations.destroy', $reservation)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($reservations->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-muted">Belum ada reservasi</h4>
                    <p class="text-muted">Mulai dengan menambahkan reservasi pertama Anda.</p>
                    <a href="<?php echo e(route('reservations.create')); ?>" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> Tambah Reservasi Pertama
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="row mt-4">
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold"><?php echo e($reservations->total()); ?></h3>
                            <p class="text-muted fs-13 mb-0">Total Reservasi</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold text-warning"><?php echo e($reservations->where('status', 'pending')->count()); ?></h3>
                            <p class="text-muted fs-13 mb-0">Menunggu Persetujuan</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-warning text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold text-success"><?php echo e($reservations->where('status', 'approved')->count()); ?></h3>
                            <p class="text-muted fs-13 mb-0">Disetujui</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-success text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20,6 9,17 4,12"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold text-danger"><?php echo e($reservations->where('status', 'cancelled')->count()); ?></h3>
                            <p class="text-muted fs-13 mb-0">Dibatalkan</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-danger text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/reservations/index.blade.php ENDPATH**/ ?>
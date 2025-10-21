

<?php $__env->startSection('title', 'Peminjaman'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Peminjaman Buku</h1>
            <p class="page-description">Kelola peminjaman buku perpustakaan</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Peminjaman</li>
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
            <a href="<?php echo e(route('borrowings.create')); ?>" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Tambah Peminjaman
            </a>
        </div>
        <div class="col-md-6 text-end">
            <span class="text-muted">Total: <?php echo e($borrowings->total()); ?> peminjaman</span>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Peminjaman</h3>
        </div>
        <div class="card-body">
            <?php if($borrowings->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Peminjam</th>
                                <th>Buku</th>
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
                                <td><?php echo e($loop->iteration + ($borrowings->currentPage() - 1) * $borrowings->perPage()); ?></td>
                                <td>
                                    <strong><?php echo e($borrowing->user->name); ?></strong>
                                    <br>
                                    <small class="text-muted"><?php echo e($borrowing->user->email); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo e($borrowing->book->title); ?></strong>
                                    <br>
                                    <small class="text-muted"><?php echo e($borrowing->book->author); ?></small>
                                </td>
                                <td><?php echo e($borrowing->borrow_date->format('d/m/Y')); ?></td>
                                <td><?php echo e($borrowing->due_date->format('d/m/Y')); ?></td>
                                <td>
                                    <?php if($borrowing->return_date): ?>
                                        <?php echo e($borrowing->return_date->format('d/m/Y')); ?>

                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php switch($borrowing->status):
                                        case ('pending'): ?>
                                            <span class="badge bg-warning">Menunggu</span>
                                            <?php break; ?>
                                        <?php case ('approved'): ?>
                                            <span class="badge bg-info">Disetujui</span>
                                            <?php break; ?>
                                        <?php case ('borrowed'): ?>
                                            <span class="badge bg-primary">Dipinjam</span>
                                            <?php break; ?>
                                        <?php case ('returned'): ?>
                                            <span class="badge bg-success">Dikembalikan</span>
                                            <?php break; ?>
                                        <?php case ('overdue'): ?>
                                            <span class="badge bg-danger">Terlambat</span>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <span class="badge bg-secondary"><?php echo e($borrowing->status); ?></span>
                                    <?php endswitch; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('borrowings.show', $borrowing)); ?>" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php if($borrowing->status == 'pending'): ?>
                                            <form action="<?php echo e(route('borrowings.approve', $borrowing)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if($borrowing->status == 'borrowed'): ?>
                                            <form action="<?php echo e(route('borrowings.return', $borrowing)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-warning btn-sm" title="Kembalikan">
                                                    <i class="fa fa-undo"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('borrowings.edit', $borrowing)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('borrowings.destroy', $borrowing)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">
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
                    <?php echo e($borrowings->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                    </div>
                    <h4 class="text-muted">Belum ada peminjaman</h4>
                    <p class="text-muted">Mulai dengan menambahkan peminjaman pertama Anda.</p>
                    <a href="<?php echo e(route('borrowings.create')); ?>" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> Tambah Peminjaman Pertama
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
                            <h3 class="mb-2 fw-semibold"><?php echo e($borrowings->total()); ?></h3>
                            <p class="text-muted fs-13 mb-0">Total Peminjaman</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
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
                            <h3 class="mb-2 fw-semibold text-warning"><?php echo e($borrowings->where('status', 'pending')->count()); ?></h3>
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
                            <h3 class="mb-2 fw-semibold text-primary"><?php echo e($borrowings->where('status', 'borrowed')->count()); ?></h3>
                            <p class="text-muted fs-13 mb-0">Sedang Dipinjam</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
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
                            <h3 class="mb-2 fw-semibold text-danger"><?php echo e($borrowings->where('status', 'overdue')->count()); ?></h3>
                            <p class="text-muted fs-13 mb-0">Terlambat</p>
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

<?php echo $__env->make('backend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/borrowings/index.blade.php ENDPATH**/ ?>
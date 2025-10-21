

<?php $__env->startSection('title', 'Edit Reservasi'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Reservasi</h1>
            <p class="page-description">Ubah informasi reservasi buku</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('reservations.index')); ?>">Reservasi</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('reservations.show', $reservation)); ?>">Detail</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
    

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Reservasi</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('reservations.update', $reservation)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="user_id" class="form-label">Anggota <span class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="user_id" name="user_id" required>
                                        <option value="">Pilih Anggota</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>" 
                                                    <?php echo e(old('user_id', $reservation->user_id) == $user->id ? 'selected' : ''); ?>>
                                                <?php echo e($user->name); ?> (<?php echo e($user->email); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="book_id" class="form-label">Buku <span class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['book_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="book_id" name="book_id" required>
                                        <option value="">Pilih Buku</option>
                                        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($book->id); ?>" 
                                                    <?php echo e(old('book_id', $reservation->book_id) == $book->id ? 'selected' : ''); ?>>
                                                <?php echo e($book->title); ?> - <?php echo e($book->author); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['book_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="pending" <?php echo e(old('status', $reservation->status) == 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                                        <option value="approved" <?php echo e(old('status', $reservation->status) == 'approved' ? 'selected' : ''); ?>>Disetujui</option>
                                        <option value="cancelled" <?php echo e(old('status', $reservation->status) == 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
                                        <option value="expired" <?php echo e(old('status', $reservation->status) == 'expired' ? 'selected' : ''); ?>>Kedaluwarsa</option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="reservation_date" class="form-label">Tanggal Reservasi <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['reservation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="reservation_date" name="reservation_date" 
                                           value="<?php echo e(old('reservation_date', $reservation->reservation_date->format('Y-m-d'))); ?>" required>
                                    <?php $__errorArgs = ['reservation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="expires_at" class="form-label">Tanggal Kedaluwarsa <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="expires_at" name="expires_at" 
                                           value="<?php echo e(old('expires_at', $reservation->expires_at->format('Y-m-d\TH:i'))); ?>" required>
                                    <div class="form-text">Reservasi akan kedaluwarsa pada tanggal dan waktu yang ditentukan.</div>
                                    <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        
                        <div class="alert alert-info">
                            <h5 class="alert-heading">
                                <i class="fa fa-info-circle me-2"></i>Informasi Saat Ini
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Anggota:</strong> <?php echo e($reservation->user->name); ?></p>
                                    <p><strong>Buku:</strong> <?php echo e($reservation->book->title); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Status:</strong> 
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
                                        <?php endswitch; ?>
                                    </p>
                                    <p><strong>Dibuat:</strong> <?php echo e($reservation->created_at->format('d F Y H:i')); ?></p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('reservations.show', $reservation)); ?>" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-set expiration date when reservation date changes
        const reservationDateInput = document.getElementById('reservation_date');
        const expiresAtInput = document.getElementById('expires_at');
        
        reservationDateInput.addEventListener('change', function() {
            if (this.value) {
                const reservationDate = new Date(this.value);
                const expirationDate = new Date(reservationDate);
                expirationDate.setDate(expirationDate.getDate() + 7); // Add 7 days
                expirationDate.setHours(23, 59, 0, 0); // Set to end of day
                
                const formattedDate = expirationDate.toISOString().slice(0, 16);
                expiresAtInput.value = formattedDate;
            }
        });

        // Status change warning
        const statusSelect = document.getElementById('status');
        const originalStatus = '<?php echo e($reservation->status); ?>';
        
        statusSelect.addEventListener('change', function() {
            if (this.value !== originalStatus) {
                const statusText = this.options[this.selectedIndex].text;
                if (confirm(`Apakah Anda yakin ingin mengubah status reservasi menjadi "${statusText}"?`)) {
                    // Status change confirmed
                } else {
                    // Revert to original status
                    this.value = originalStatus;
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/reservations/edit.blade.php ENDPATH**/ ?>
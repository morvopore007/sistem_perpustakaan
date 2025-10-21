

<?php $__env->startSection('title', $book->title); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-header">
        <div>
            <h1 class="page-title"><?php echo e($book->title); ?></h1>
            <p class="page-description">Detail Buku</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('member.dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('member.books.index')); ?>">Buku Saya</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e(Str::limit($book->title, 20)); ?></li>
            </ol>
        </div>
    </div>
    

    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <?php if($book->book_cover): ?>
                        <img src="<?php echo e(asset('storage/' . $book->book_cover)); ?>" 
                             alt="<?php echo e($book->title); ?>" 
                             class="img-fluid rounded mb-3">
                    <?php else: ?>
                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                             style="height: 300px;">
                            <i class="fe fe-book" style="font-size: 64px; color: #ccc;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <span class="badge bg-success fs-6"><?php echo e($book->available_copies); ?> Tersedia</span>
                    </div>
                    
                    <?php if($book->available_copies > 0): ?>
                        <form action="<?php echo e(route('member.reservations.store')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-plus"></i> Reservasi Buku
                            </button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary" disabled>
                            <i class="fe fe-x"></i> Tidak Tersedia
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Buku</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Judul:</strong></td>
                                    <td><?php echo e($book->title); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Penulis:</strong></td>
                                    <td><?php echo e($book->author); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>ISBN:</strong></td>
                                    <td><?php echo e($book->isbn); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Penerbit:</strong></td>
                                    <td><?php echo e($book->publisher); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori:</strong></td>
                                    <td><?php echo e($book->category->name ?? 'Tidak Ada Kategori'); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Tahun Terbit:</strong></td>
                                    <td><?php echo e($book->publication_year); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Edisi:</strong></td>
                                    <td><?php echo e($book->edition); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Halaman:</strong></td>
                                    <td><?php echo e($book->pages); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Bahasa:</strong></td>
                                    <td><?php echo e($book->language); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi:</strong></td>
                                    <td><?php echo e($book->location); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <?php if($book->description): ?>
                        <div class="mt-4">
                            <h5>Deskripsi</h5>
                            <p><?php echo e($book->description); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Ulasan</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <span class="me-2">Rating Rata-rata:</span>
                            <div class="rating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= $averageRating): ?>
                                        <i class="fe fe-star text-warning"></i>
                                    <?php else: ?>
                                        <i class="fe fe-star text-muted"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span class="ms-2"><?php echo e(number_format($averageRating, 1)); ?>/5</span>
                            </div>
                        </div>
                    </div>

                    
                    <?php if(!$userReview && auth()->user()->borrowings()->where('book_id', $book->id)->where('status', 'returned')->exists()): ?>
                        <div class="mb-4">
                            <h5>Tulis Ulasan</h5>
                            <form action="<?php echo e(route('member.reviews.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <select name="rating" class="form-control" required>
                                        <option value="">Pilih Rating</option>
                                        <option value="1">1 Bintang</option>
                                        <option value="2">2 Bintang</option>
                                        <option value="3">3 Bintang</option>
                                        <option value="4">4 Bintang</option>
                                        <option value="5">5 Bintang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ulasan</label>
                                    <textarea name="review" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                            </form>
                        </div>
                    <?php elseif($userReview): ?>
                        <div class="mb-4">
                            <h5>Ulasan Anda</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="rating mb-2">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <?php if($i <= $userReview->rating): ?>
                                                        <i class="fe fe-star text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="fe fe-star text-muted"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <p><?php echo e($userReview->review); ?></p>
                                        </div>
                                        <div>
                                            <form action="<?php echo e(route('member.reviews.destroy', $userReview)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($book->reviews->count() > 0): ?>
                        <h5>Ulasan Lainnya</h5>
                        <?php $__currentLoopData = $book->reviews->where('user_id', '!=', auth()->id()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="rating mb-2">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <?php if($i <= $review->rating): ?>
                                                        <i class="fe fe-star text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="fe fe-star text-muted"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <p class="mb-1"><strong><?php echo e($review->user->name); ?></strong></p>
                                            <p><?php echo e($review->review); ?></p>
                                        </div>
                                        <small class="text-muted"><?php echo e($review->created_at->format('d M Y')); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted">Belum ada ulasan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistem_perpustakaan\resources\views/backend/member/books/show.blade.php ENDPATH**/ ?>
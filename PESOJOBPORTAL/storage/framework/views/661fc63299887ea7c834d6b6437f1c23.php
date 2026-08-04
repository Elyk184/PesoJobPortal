<?php $__env->startSection('title', 'Admin Profile | PESO Admin'); ?>

<?php
    $pageTitle = 'Profile';
    $pageSubtitle = 'Manage your admin account settings';
    $pageIcon = 'bi-person-circle';
?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <style>
        .profile-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .profile-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 12px;
            padding: 3rem 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(215, 38, 56, 0.08) 0%, rgba(215, 38, 56, 0) 100%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .profile-avatar-section {
            position: relative;
            z-index: 1;
            margin-bottom: 1.5rem;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            font-weight: 800;
            color: white;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 25px rgba(215, 38, 56, 0.3);
            border: 4px solid white;
        }

        .profile-avatar {
            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            object-fit: cover;
            display: block;
        }

        .profile-name {
            font-size: 28px;
            font-weight: 800;
            color: #0d1f3c;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .profile-role {
            font-size: 14px;
            color: #6b7280;
            font-weight: 600;
            margin-top: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .profile-card h5 {
            color: #0d1f3c;
            font-weight: 800;
            margin-bottom: 1.5rem;
            border-bottom: 3px solid #d72638;
            padding-bottom: 1rem;
            font-size: 17px;
            letter-spacing: -0.3px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-weight: 700;
            color: #0d1f3c;
            margin-bottom: 0.75rem;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #d72638;
            box-shadow: 0 0 0 4px rgba(215, 38, 56, 0.1);
            background: #fafbfc;
        }

        .form-control::placeholder {
            color: #a1a5ab;
        }

        .photo-upload-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .photo-upload-input {
            display: none;
        }

        .photo-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 2rem;
            border: 2px dashed #d72638;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(215, 38, 56, 0.05) 0%, rgba(215, 38, 56, 0.02) 100%);
            font-weight: 700;
            color: #d72638;
        }

        .photo-upload-label:hover {
            background: linear-gradient(135deg, rgba(215, 38, 56, 0.1) 0%, rgba(215, 38, 56, 0.05) 100%);
            border-color: #ff6b7a;
            box-shadow: 0 4px 12px rgba(215, 38, 56, 0.15);
        }

        .photo-upload-icon {
            font-size: 24px;
        }

        .photo-upload-text {
            text-align: left;
        }

        .photo-upload-text small {
            display: block;
            color: #6b7280;
            font-weight: 500;
            margin-top: 0.25rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn-save {
            background: linear-gradient(135deg, #d72638 0%, #ff6b7a 100%);
            color: white;
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(215, 38, 56, 0.2);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(215, 38, 56, 0.3);
            color: white;
        }

        .btn-cancel {
            background: #e5e7eb;
            color: #374151;
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-cancel:hover {
            background: #d1d5db;
            color: #374151;
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #7c2d12;
            border-left: 4px solid #dc2626;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e3a8a;
            border-left: 4px solid #3b82f6;
        }

        .alert i {
            font-size: 18px;
        }

        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 4px solid #3b82f6;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 14px;
        }

        .info-box i {
            margin-right: 0.75rem;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .profile-header {
                padding: 2rem 1.5rem;
            }

            .profile-name {
                font-size: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn-save, .btn-cancel {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <?php if($errors->any()): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle-fill"></i>
                <?php echo e($error); ?>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar-section">
                <div class="profile-avatar">
                    <img src="https://i.pinimg.com/736x/f5/47/d8/f547d800625af9056d62efe8969aeea0.jpg" alt="<?php echo e($admin->name); ?>">
                </div>
            </div>
            <h3 class="profile-name"><?php echo e($admin->name); ?></h3>
            <p class="profile-role">Administrator</p>
        </div>

        <!-- Edit Profile Form -->
        <div class="profile-card">
            <h5><i class="bi bi-pencil-square me-2"></i>Edit Profile</h5>

            <div class="info-box">
                <i class="bi bi-info-circle"></i>
                Update your profile information and photo below
            </div>

            <form method="POST" action="<?php echo e(route('admin.profile.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <!-- Photo Upload -->
                <div class="form-group">
                    <label class="form-label">Profile Photo</label>
                    <div class="photo-upload-wrapper">
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="photo-upload-input">
                        <label for="profile_photo" class="photo-upload-label">
                            <span class="photo-upload-icon"><i class="bi bi-image"></i></span>
                            <span class="photo-upload-text">
                                Click to upload or drag and drop
                                <small>PNG, JPG, GIF up to 10MB</small>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Name and Email -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name', $admin->name)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo e(old('email', $admin->email)); ?>" required>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="btn-group">
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-circle"></i> Save Changes
                    </button>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Account Info Card -->
        <div class="profile-card">
            <h5><i class="bi bi-shield-check me-2"></i>Account Information</h5>

            <div style="display: grid; gap: 1rem;">
                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 1rem; align-items: center;">
                    <span style="color: #6b7280; font-weight: 600;">Account Type:</span>
                    <span style="color: #0d1f3c; font-weight: 700; background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%); color: #7c2d12; padding: 6px 12px; border-radius: 6px; display: inline-block; font-size: 12px; text-transform: uppercase; width: fit-content;">Administrator</span>
                </div>
                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 1rem; align-items: center;">
                    <span style="color: #6b7280; font-weight: 600;">Member Since:</span>
                    <span style="color: #0d1f3c; font-weight: 600;"><?php echo e($admin->created_at->format('F d, Y')); ?></span>
                </div>
                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 1rem; align-items: center;">
                    <span style="color: #6b7280; font-weight: 600;">Last Updated:</span>
                    <span style="color: #0d1f3c; font-weight: 600;"><?php echo e($admin->updated_at->format('F d, Y \a\t g:i A')); ?></span>
                </div>
                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 1rem; align-items: center;">
                    <span style="color: #6b7280; font-weight: 600;">Account ID:</span>
                    <span style="color: #a1a5ab; font-family: monospace; font-weight: 500;">#<?php echo e($admin->id); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Drag and drop for file upload
    const fileInput = document.getElementById('profile_photo');
    const uploadLabel = document.querySelector('.photo-upload-label');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadLabel.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadLabel.addEventListener(eventName, () => {
            uploadLabel.style.borderColor = '#ff6b7a';
            uploadLabel.style.background = 'linear-gradient(135deg, rgba(215, 38, 56, 0.15) 0%, rgba(215, 38, 56, 0.1) 100%)';
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadLabel.addEventListener(eventName, () => {
            uploadLabel.style.borderColor = '#d72638';
            uploadLabel.style.background = 'linear-gradient(135deg, rgba(215, 38, 56, 0.05) 0%, rgba(215, 38, 56, 0.02) 100%)';
        });
    });

    uploadLabel.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        fileInput.files = files;
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\PesoJobPortal\PESOJOBPORTAL\resources\views\admin\profile.blade.php ENDPATH**/ ?>
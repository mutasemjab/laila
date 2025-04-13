
<?php $__env->startSection('title'); ?>
سجل حضور <?php echo e($user->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .user-profile {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .user-header {
        background: linear-gradient(135deg, #0063e5 0%, #0084ff 100%);
        color: white;
        padding: 25px;
        position: relative;
    }
    
    .user-header h2 {
        margin: 0;
        font-weight: 600;
    }
    
    .user-info {
        list-style: none;
        padding: 0;
        margin: 15px 0 0 0;
        display: flex;
        gap: 30px;
    }
    
    .user-info li {
        display: flex;
        align-items: center;
    }
    
    .user-info li i {
        margin-left: 8px;
        opacity: 0.8;
    }
    
    .back-button {
        padding: 8px 20px;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 15px;
        display: inline-flex;
        align-items: center;
    }
    
    .back-button:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }
    
    .back-button i {
        margin-left: 5px;
    }
    
    .room-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .room-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .room-name {
        font-weight: 600;
        font-size: 1.2rem;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .room-name i {
        color: #0084ff;
        margin-left: 10px;
        font-size: 1.5rem;
    }
    
    .room-total {
        background-color: rgba(0, 132, 255, 0.1);
        color: #0084ff;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .visit-list {
        padding: 0;
        list-style: none;
        margin: 0;
    }
    
    .visit-item {
        padding: 15px 20px;
        border-bottom: 1px solid #f5f5f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .visit-item:last-child {
        border-bottom: none;
    }
    
    .visit-time {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .visit-time-item {
        display: flex;
        flex-direction: column;
    }
    
    .visit-time-label {
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 3px;
    }
    
    .visit-time-value {
        font-weight: 600;
        color: #333;
    }
    
    .visit-duration {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .visit-duration.active {
        background-color: rgba(0, 132, 255, 0.1);
        color: #0084ff;
    }
    
    .no-records {
        padding: 30px;
        text-align: center;
        color: #666;
    }
    
    .no-records i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 15px;
        display: block;
    }
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 20px;
        display: flex;
        align-items: center;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        background-color: rgba(0, 132, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 15px;
    }
    
    .stat-icon i {
        font-size: 1.8rem;
        color: #0084ff;
    }
    
    .stat-content h3 {
        margin: 0 0 5px 0;
        font-size: 0.9rem;
        color: #666;
    }
    
    .stat-content p {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 600;
        color: #333;
    }
    
    .time-arrow {
        color: #aaa;
        font-size: 1.2rem;
        margin: 0 10px;
    }
    
    @media (max-width: 768px) {
        .visit-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .visit-time {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderlink'); ?>
<a href="<?php echo e(route('users.index')); ?>"> سجل حضور المستخدمين </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderactive'); ?>
<?php echo e($user->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
function formatDuration($seconds) {
    if ($seconds < 60) {
        return $seconds . ' ثانية';
    }
    
    $minutes = floor($seconds / 60);
    $remainingSeconds = $seconds % 60;
    
    if ($minutes < 60) {
        return $minutes . ' دقيقة ' . ($remainingSeconds > 0 ? 'و ' . $remainingSeconds . ' ثانية' : '');
    }
    
    $hours = floor($minutes / 60);
    $remainingMinutes = $minutes % 60;
    
    $formattedTime = $hours . ' ساعة';
    
    if ($remainingMinutes > 0) {
        $formattedTime .= ' و ' . $remainingMinutes . ' دقيقة';
    }
    
    if ($remainingSeconds > 0 && $remainingMinutes == 0) {
        $formattedTime .= ' و ' . $remainingSeconds . ' ثانية';
    }
    
    return $formattedTime;
}
?>
<div class="container-fluid">
    <!-- User Profile Card -->
    <div class="user-profile">
        <div class="user-header">
            <a href="<?php echo e(route('users.index')); ?>" class="back-button">
                <i class="fas fa-chevron-right"></i>
                العودة للقائمة
            </a>
            <h2>سجل حضور <?php echo e($user->name); ?></h2>
            <ul class="user-info">
                <li><i class="fas fa-phone"></i> <?php echo e($user->phone); ?></li>
                <li><i class="fas fa-barcode"></i> <?php echo e($user->barcode); ?></li>
                <li>
                    <i class="fas fa-circle <?php echo e($user->activate == 1 ? 'text-success' : 'text-danger'); ?>"></i>
                    <?php echo e($user->activate == 1 ? 'نشط' : 'غير نشط'); ?>

                </li>
            </ul>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-door-open"></i>
            </div>
            <div class="stat-content">
                <h3>عدد الغرف التي تم زيارتها</h3>
                <p><?php echo e(count($roomTimeLogs)); ?></p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <div class="stat-content">
                <h3>عدد مرات تسجيل الدخول</h3>
                <p><?php echo e(array_sum(array_map(function($room) { return count($room['visits']); }, $roomTimeLogs))); ?></p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>إجمالي الوقت</h3>
                <p>
                    <?php echo e(formatDuration(
                            array_sum(array_map(function($room) { 
                                return $room['total_seconds']; 
                            }, $roomTimeLogs))
                        )); ?>

                </p>
            </div>
        </div>
    </div>
    
    <!-- Room Time Logs -->
    <?php if(count($roomTimeLogs) > 0): ?>
        <?php $__currentLoopData = $roomTimeLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomLog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="room-card">
            <div class="room-header">
                <div class="room-name">
                    <i class="fas fa-door-open"></i>
                    <?php echo e($roomLog['room']->name); ?>

                </div>
                <div class="room-total">
                    إجمالي الوقت: <?php echo e($roomLog['total_time']); ?>

                </div>
            </div>
            
            <ul class="visit-list">
                <?php $__currentLoopData = $roomLog['visits']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="visit-item">
                    <div class="visit-time">
                        <div class="visit-time-item">
                            <span class="visit-time-label">تسجيل الدخول</span>
                            <span class="visit-time-value"><?php echo e($visit['check_in_time']->format('Y-m-d g:i A')); ?></span>
                        </div>
                        
                        <span class="time-arrow">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        
                        <div class="visit-time-item">
                            <span class="visit-time-label">تسجيل الخروج</span>
                            <span class="visit-time-value">
                                <?php echo e($visit['check_out_time'] ? $visit['check_out_time']->format('Y-m-d g:i A') : 'لم يتم الخروج بعد'); ?>

                            </span>
                        </div>
                    </div>
                    
                    <div class="visit-duration <?php echo e(!$visit['check_out_time'] ? 'active' : ''); ?>">
                        <?php echo e($visit['duration']); ?>

                    </div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="no-records">
            <i class="fas fa-clock"></i>
            <p>لا يوجد سجلات حضور لهذا المستخدم</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    // Format duration helper function for JS
    function formatDuration(seconds) {
        if (seconds < 60) {
            return seconds + ' ثانية';
        }
        
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        
        if (minutes < 60) {
            return minutes + ' دقيقة ' + (remainingSeconds > 0 ? 'و ' + remainingSeconds + ' ثانية' : '');
        }
        
        const hours = Math.floor(minutes / 60);
        const remainingMinutes = minutes % 60;
        
        let formattedTime = hours + ' ساعة';
        
        if (remainingMinutes > 0) {
            formattedTime += ' و ' + remainingMinutes + ' دقيقة';
        }
        
        if (remainingSeconds > 0 && remainingMinutes == 0) {
            formattedTime += ' و ' + remainingSeconds + ' ثانية';
        }
        
        return formattedTime;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laila\resources\views/admin/users/showLog.blade.php ENDPATH**/ ?>
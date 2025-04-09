

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4>Attendance Logs for <?php echo e($user->name); ?></h4>
                        <div>
                            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">Back to Users</a>
                            <button id="calculate-time" class="btn btn-primary">Calculate Total Time</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="time-result" class="alert alert-info">
                        Total Time: <?php echo e($totalTime); ?>

                    </div>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Time</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($log->id); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($log->type === 'in' ? 'bg-success' : 'bg-danger'); ?>">
                                            <?php echo e(ucfirst($log->type)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($log->time->format('H:i:s')); ?></td>
                                    <td><?php echo e($log->time->format('Y-m-d')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    
                    <?php echo e($logs->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calculateBtn = document.getElementById('calculate-time');
        const timeResult = document.getElementById('time-result');
        
        calculateBtn.addEventListener('click', function() {
            // Show loading indicator
            timeResult.innerHTML = 'Calculating...';
            
            // Send the request to calculate time
            fetch('<?php echo e(route('attendance.calculate', $user->id)); ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    timeResult.innerHTML = `
                        <strong>Total Time:</strong> ${data.total_time_formatted}
                    `;
                } else {
                    timeResult.innerHTML = 'Error calculating time';
                }
            })
            .catch(error => {
                timeResult.innerHTML = `Error: ${error.message}`;
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laila\resources\views/admin/attendance/user_logs.blade.php ENDPATH**/ ?>
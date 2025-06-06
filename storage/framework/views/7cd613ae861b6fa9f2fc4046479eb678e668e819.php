<?php $__env->startSection('title'); ?>
الرئيسية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<style>
    .rooms-container {
        padding: 25px;
        background-color: #f5f9fc;
        border-radius: 15px;
        min-height: 80vh;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }

    .room-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fdff 100%);
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        height: 220px;
        border: 1px solid rgba(0, 123, 255, 0.1);
    }

    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 123, 255, 0.15);
        border-color: rgba(0, 123, 255, 0.3);
    }

    .room-header {
        padding: 20px;
        color: #fff;
        background: linear-gradient(135deg, #0063e5 0%, #0084ff 100%);
        position: relative;
        height: 50%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .room-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .room-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2.5rem;
        opacity: 0.5;
    }

    .room-details {
        padding: 20px;
        height: 50%;
    }

    .room-stat {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .room-stat-label {
        color: #555;
        font-size: 0.9rem;
    }

    .room-stat-value {
        font-weight: 600;
        color: #0084ff;
        font-size: 1.1rem;
    }

    /* Scanner Modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-container {
        background-color: #fff;
        width: 90%;
        max-width: 500px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        transform: scale(0.8);
        transition: all 0.3s ease;
    }

    .modal-overlay.active .modal-container {
        transform: scale(1);
    }

    .modal-header {
        background: linear-gradient(135deg, #0063e5 0%, #0084ff 100%);
        color: #fff;
        padding: 20px;
        position: relative;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
    }

    .modal-close {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 25px;
        text-align: center;
    }

    .barcode-input-container {
        margin: 20px 0;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .barcode-input {
        padding: 15px;
        border: 2px solid #ddd;
        border-radius: 10px;
        font-size: 1.2rem;
        width: 100%;
        text-align: center;
        transition: all 0.3s ease;
        background-color: #f9fdff;
    }

    .barcode-input:focus {
        border-color: #0084ff;
        box-shadow: 0 0 0 3px rgba(0, 132, 255, 0.2);
        outline: none;
    }

    .btn-scan {
        padding: 12px 25px;
        background: linear-gradient(135deg, #0063e5 0%, #0084ff 100%);
        color: #fff;
        border: none;
        border-radius: 30px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        width: 100%;
        margin-top: 15px;
    }

    .btn-scan:hover {
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
        transform: translateY(-2px);
    }

    .scan-status {
        margin-top: 15px;
        padding: 15px;
        border-radius: 8px;
        display: none;
    }

    .scan-status.success {
        background-color: rgba(40, 167, 69, 0.1);
        border: 1px solid rgba(40, 167, 69, 0.2);
        color: #28a745;
        display: block;
    }

    .scan-status.error {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
        color: #dc3545;
        display: block;
    }

    .scan-status.loading {
        background-color: rgba(0, 123, 255, 0.1);
        border: 1px solid rgba(0, 123, 255, 0.2);
        color: #0084ff;
        display: block;
    }

    /* Dashboard Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .dashboard-title {
        display: flex;
        align-items: center;
    }

    .dashboard-title i {
        font-size: 1.5rem;
        color: #0084ff;
        margin-left: 10px;
    }

    .dashboard-title h1 {
        margin: 0;
        font-size: 1.8rem;
        color: #333;
    }

    .dashboard-filters {
        display: flex;
        gap: 15px;
    }

    .filter-btn {
        padding: 8px 15px;
        border-radius: 20px;
        background-color: #fff;
        color: #555;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn.active {
        background-color: #0084ff;
        color: #fff;
        border-color: #0084ff;
    }

    /* User Feedback Toast */
    .toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #fff;
        padding: 15px 25px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 15px;
        z-index: 99999;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .toast.active {
        transform: translateY(0);
        opacity: 1;
    }

    .toast i {
        font-size: 1.5rem;
    }

    .toast.success i {
        color: #28a745;
    }

    .toast.error i {
        color: #dc3545;
    }

    .toast-message {
        font-weight: 500;
    }

    /* Stats Cards at Top */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.5rem;
    }

    .stat-icon.blue {
        background-color: rgba(0, 123, 255, 0.1);
        color: #0084ff;
    }

    .stat-icon.green {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .stat-icon.orange {
        background-color: rgba(255, 153, 0, 0.1);
        color: #ff9900;
    }

    .stat-icon.purple {
        background-color: rgba(111, 66, 193, 0.1);
        color: #6f42c1;
    }

    .stat-icon.red {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .stat-content h3 {
        margin: 0;
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 5px;
    }

    .stat-content p {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
    }

    /* Refresh button */
    .refresh-stats {
        background: none;
        border: none;
        color: #0084ff;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        padding: 8px 15px;
        border-radius: 20px;
        transition: all 0.3s ease;
        margin-right: 15px;
    }

    .refresh-stats:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .refresh-stats i {
        margin-left: 5px;
    }

    /* Animation for refresh icon */
    .fa-sync-alt {
        transition: transform 0.5s ease;
    }

    .refresh-stats:hover .fa-sync-alt {
        transform: rotate(180deg);
    }

    .refreshing .fa-sync-alt {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderlink'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>"> الرئيسية </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderactive'); ?>
عرض الغرف
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="rooms-container">
    <div class="dashboard-header">
        <div class="dashboard-title">
            <i class="fas fa-door-open"></i>
            <h1><?php echo e(__('messages.rooms')); ?></h1>
        </div>
        <div class="dashboard-filters">
            <button class="refresh-stats" id="refreshStats">
                <i class="fas fa-sync-alt"></i>
                تحديث البيانات
            </button>
            <button class="filter-btn active" data-filter="all">جميع الغرف</button>
            <button class="filter-btn" data-filter="active">الغرف النشطة</button>
            <button class="filter-btn" data-filter="empty">الغرف الفارغة</button>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>إجمالي الحضور الحالي</h3>
                <p id="total-attendance"><?php echo e($totalActiveUsers); ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <div class="stat-icon green">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
            <div class="stat-content">
                <h3>الغرف النشطة</h3>
                <p id="active-rooms"><?php echo e($activeRooms); ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>متوسط وقت الحضور</h3>
                <p id="avg-time"><?php echo e($avgTime); ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <h3>إجمالي المستخدمين</h3>
                <p id="total-users"><?php echo e($totalUsers); ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <div class="stat-content">
                <h3>إجمالي عمليات التسجيل</h3>
                <p id="total-check-ins"><?php echo e($totalCheckIns); ?></p>
            </div>
        </div>
    </div>

    <div class="rooms-grid">
        <!-- Room Card Template - Will be populated dynamically -->
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="room-card" data-room-id="<?php echo e($room->id); ?>" data-status="<?php echo e($room->current_occupancy > 0 ? 'active' : 'empty'); ?>">
            <div class="room-header">
                <h3><?php echo e($room->name); ?></h3>
                <div class="room-icon">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
            <div class="room-details">
                <div class="room-stat">
                    <span class="room-stat-label">عدد الحاضرين</span>
                    <span class="room-stat-value"><?php echo e($room->current_occupancy); ?></span>
                </div>
                <div class="room-stat">
                    <span class="room-stat-label">آخر تسجيل دخول</span>
                    <span class="room-stat-value last-check-in"><?php echo e($room->last_check_in ? Carbon\Carbon::parse($room->last_check_in)->diffForHumans() : 'لا يوجد'); ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Scanner Modal -->
<div class="modal-overlay" id="scannerModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 id="modal-room-name">اسم الغرفة</h2>
            <div class="modal-close" id="closeModal">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="modal-body">
            <p>أدخل الباركود الخاص بالمستخدم للتسجيل</p>
            <div class="barcode-input-container">
                <input type="text" id="barcode-input" class="barcode-input" placeholder="أدخل الباركود هنا..." autofocus>
                <button class="btn-scan" id="scanBtn">تسجيل</button>
            </div>
            <div class="scan-status" id="scanStatus"></div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <div class="toast-message">تم تسجيل الدخول بنجاح</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rooms = document.querySelectorAll('.room-card');
    const modal = document.getElementById('scannerModal');
    const closeModal = document.getElementById('closeModal');
    const modalRoomName = document.getElementById('modal-room-name');
    const barcodeInput = document.getElementById('barcode-input');
    const scanBtn = document.getElementById('scanBtn');
    const scanStatus = document.getElementById('scanStatus');
    const toast = document.getElementById('toast');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const refreshStats = document.getElementById('refreshStats');
    
    let currentRoomId = null;

    // Helper function to get the CSRF token
    function getCSRFToken() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        let token = '';
        
        if (csrfToken) {
            token = csrfToken.getAttribute('content');
        } else {
            console.error('CSRF token meta tag not found');
            // Try to get it from a form if available
            const tokenInput = document.querySelector('input[name="_token"]');
            if (tokenInput) {
                token = tokenInput.value;
            }
        }
        
        return token;
    }

    // Filter rooms
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter rooms
            rooms.forEach(room => {
                if (filter === 'all' || room.getAttribute('data-status') === filter) {
                    room.style.display = 'block';
                } else {
                    room.style.display = 'none';
                }
            });
        });
    });

    // Validate barcode before scanning
    function validateBarcode(barcode) {
        // First, show loading state
        scanStatus.className = 'scan-status loading';
        scanStatus.textContent = 'جاري التحقق من الباركود...';
        
        // Make a validation request
        return fetch('<?php echo e(route("validate.barcode")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken()
            },
            body: JSON.stringify({
                barcode: barcode.trim()
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.valid) {
                return true; // Barcode is valid
            } else {
                scanStatus.className = 'scan-status error';
                scanStatus.textContent = 'هذا الباركود غير مسجل في النظام';
                showToast(false, 'هذا الباركود غير مسجل في النظام');
                return false;
            }
        })
        .catch(error => {
            console.error('Error validating barcode:', error);
            // For development, to avoid blocking if the endpoint doesn't exist yet
            return true;
        });
    }

    // Process barcode
    function processBarcode(barcode) {
        if (!barcode || barcode.trim() === '') {
            scanStatus.className = 'scan-status error';
            scanStatus.textContent = 'الرجاء إدخال باركود صحيح';
            return;
        }
        
        fetch('<?php echo e(route("scan.barcode")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken()
            },
            body: JSON.stringify({
                user_barcode: barcode.trim(),
                room_id: currentRoomId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                scanStatus.className = 'scan-status success';
                scanStatus.innerHTML = `
                    <strong>${data.user}</strong> تم تسجيل 
                    ${data.type === 'in' ? 'الدخول' : 'الخروج'} بنجاح
                    ${data.time_spent ? '<br>وقت البقاء: ' + data.time_spent : ''}
                `;
                
                showToast(true, data.type === 'in' ? 'تم تسجيل الدخول بنجاح' : 'تم تسجيل الخروج بنجاح');
                
                // Update room stats with data from the server
                updateRoomStats(currentRoomId, data.current_room_occupancy, data.last_check_in);
                
                // Update all stats to reflect the changes
                fetchAndUpdateStats();
                
                // Clear input for next scan
                barcodeInput.value = '';
                barcodeInput.focus();
            } else {
                scanStatus.className = 'scan-status error';
                scanStatus.textContent = data.message || 'فشل في تسجيل الباركود';
                showToast(false, data.message || 'فشل في تسجيل الباركود');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            scanStatus.className = 'scan-status error';
            scanStatus.textContent = 'هذا الباركود غير مسجل في النظام';
            showToast(false, 'هذا الباركود غير مسجل في النظام');
            
            // Clear input for next scan
            barcodeInput.value = '';
            barcodeInput.focus();
        });
    }

    // Update room stats
    function updateRoomStats(roomId, occupancy, lastCheckIn) {
        const roomCard = document.querySelector(`.room-card[data-room-id="${roomId}"]`);
        if (roomCard) {
            const occupancyElement = roomCard.querySelector('.room-stat-value');
            if (occupancyElement) {
                occupancyElement.textContent = occupancy;
            }
            
            // Update last check-in time if provided
            if (lastCheckIn) {
                const lastCheckInElement = roomCard.querySelector('.last-check-in');
                if (lastCheckInElement) {
                    lastCheckInElement.textContent = lastCheckIn;
                }
            }
            
            // Update room status for filtering
            roomCard.setAttribute('data-status', occupancy > 0 ? 'active' : 'empty');
        }
    }

    // Fetch and update all statistics from the server
    function fetchAndUpdateStats() {
        fetch('<?php echo e(route("room.statistics")); ?>', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken()
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update dashboard stats
            document.getElementById('total-attendance').textContent = data.totalActiveUsers;
            document.getElementById('active-rooms').textContent = data.activeRooms;
            document.getElementById('avg-time').textContent = data.avgTime;
            document.getElementById('total-users').textContent = data.totalUsers;
            document.getElementById('total-check-ins').textContent = data.totalCheckIns;
            
            // Update each room's stats if provided
            if (data.rooms) {
                data.rooms.forEach(roomData => {
                    const roomCard = document.querySelector(`.room-card[data-room-id="${roomData.id}"]`);
                    if (roomCard) {
                        // Update occupancy
                        const occupancyEl = roomCard.querySelector('.room-stat-value');
                        if (occupancyEl) {
                            occupancyEl.textContent = roomData.current_occupancy;
                        }
                        
                        // Update last check-in
                        const lastCheckInEl = roomCard.querySelector('.last-check-in');
                        if (lastCheckInEl) {
                            lastCheckInEl.textContent = roomData.last_check_in_human || 'لا يوجد';
                        }
                        
                        // Update status for filtering
                        roomCard.setAttribute('data-status', 
                            roomData.current_occupancy > 0 ? 'active' : 'empty');
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error fetching statistics:', error);
        });
    }

    // Refresh all stats (for the refresh button)
    function refreshAllStats() {
        // Add spinning animation to refresh button
        refreshStats.classList.add('refreshing');
        
        fetchAndUpdateStats();
        
        // Show success toast
        showToast(true, 'تم تحديث البيانات بنجاح');
        
        // Remove spinning animation after a moment
        setTimeout(() => {
            refreshStats.classList.remove('refreshing');
        }, 1000);
    }

    // Show toast notification
    function showToast(success, message) {
        toast.className = success ? 'toast success active' : 'toast error active';
        toast.querySelector('i').className = success ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        toast.querySelector('.toast-message').textContent = message;
        
        setTimeout(() => {
            toast.className = toast.className.replace('active', '');
        }, 3000);
    }

    // Open scanner modal
    rooms.forEach(room => {
        room.addEventListener('click', function() {
            currentRoomId = this.getAttribute('data-room-id');
            modalRoomName.textContent = this.querySelector('h3').textContent;
            
            scanStatus.className = 'scan-status';
            scanStatus.textContent = '';
            
            modal.classList.add('active');
            
            // Focus on input field
            setTimeout(() => {
                barcodeInput.focus();
            }, 300);
        });
    });

    // Close scanner modal
    closeModal.addEventListener('click', function() {
        modal.classList.remove('active');
        barcodeInput.value = '';
    });

    // Scan button click
    scanBtn.addEventListener('click', function() {
        const barcode = barcodeInput.value;
        if (!barcode || barcode.trim() === '') {
            scanStatus.className = 'scan-status error';
            scanStatus.textContent = 'الرجاء إدخال باركود صحيح';
            return;
        }
        
        // Validate barcode first then process if valid
        validateBarcode(barcode).then(isValid => {
            if (isValid) {
                processBarcode(barcode);
            } else {
                // Clear input for next scan
                barcodeInput.value = '';
                barcodeInput.focus();
            }
        });
    });
    
    // Handle Enter key press in input field
    barcodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const barcode = this.value;
            if (!barcode || barcode.trim() === '') {
                scanStatus.className = 'scan-status error';
                scanStatus.textContent = 'الرجاء إدخال باركود صحيح';
                return;
            }
            
            // Validate barcode first then process if valid
            validateBarcode(barcode).then(isValid => {
                if (isValid) {
                    processBarcode(barcode);
                } else {
                    // Clear input for next scan
                    this.value = '';
                    this.focus();
                }
            });
        }
    });

    // Add refresh button event listener
    refreshStats.addEventListener('click', refreshAllStats);
    
    // Refresh stats every 60 seconds (optional)
    // setInterval(fetchAndUpdateStats, 60000);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laila\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
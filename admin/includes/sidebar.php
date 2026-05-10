<?php
// Admin sidebar
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="col-md-2 p-0">
    <div class="sidebar">
        <div class="list-group list-group-flush">
            <a href="dashboard.php" class="list-group-item list-group-item-action <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="technicians.php" class="list-group-item list-group-item-action <?php echo $current_page == 'technicians.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Technicians
            </a>
            <a href="add_technician.php" class="list-group-item list-group-item-action <?php echo $current_page == 'add_technician.php' ? 'active' : ''; ?>">
                <i class="fas fa-plus-circle"></i> Add Technician
            </a>
            <a href="categories.php" class="list-group-item list-group-item-action <?php echo $current_page == 'categories.php' ? 'active' : ''; ?>">
                <i class="fas fa-tags"></i> Categories
            </a>
            <a href="bookings.php" class="list-group-item list-group-item-action <?php echo $current_page == 'bookings.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check"></i> Bookings
            </a>
        </div>
    </div>
</div>

<style>
.sidebar {
    background: #f8f9fa;
    min-height: calc(100vh - 56px);
    border-right: 1px solid #dee2e6;
}
.sidebar .list-group-item {
    border: none;
    padding: 12px 20px;
    transition: all 0.3s;
}
.sidebar .list-group-item:hover {
    background: #e9ecef;
    padding-left: 25px;
}
.sidebar .list-group-item.active {
    background: #0d6efd;
    color: white;
}
.sidebar .list-group-item i {
    width: 25px;
}
</style>
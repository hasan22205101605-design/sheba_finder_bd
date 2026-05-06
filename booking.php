<?php
require_once 'db.php';

if(!isLoggedIn()) {
    $_SESSION['error'] = "Please login to book a technician!";
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $technician_id = $_POST['technician_id'];
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'] ?: $_SESSION['user_email'];
    $address = $_POST['address'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $hours = $_POST['hours'];
    $price_per_hour = $_POST['price_per_hour'];
    $total_amount = $hours * $price_per_hour;
    
    $sql = "INSERT INTO bookings (technician_id, user_id, customer_name, customer_phone, 
            customer_email, address, booking_date, booking_time, total_amount, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $technician_id, $_SESSION['user_id'], $customer_name, $customer_phone,
        $customer_email, $address, $booking_date, $booking_time, $total_amount
    ]);
    
    if($result) {
        $_SESSION['success'] = "Booking confirmed successfully!";
        header("Location: my-bookings.php");
    } else {
        $_SESSION['error'] = "Booking failed! Please try again.";
        header("Location: technician.php?id=" . $technician_id);
    }
} else {
    header("Location: service.php");
}
exit();
?>
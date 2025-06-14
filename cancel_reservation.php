<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['reservation_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing reservation_id']);
    exit();
}

$reservationId = intval($data['reservation_id']);

require_once 'connection.php';

if (!$conn || $conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

// Check that reservation exists and is ongoing
$checkSql = "
    SELECT r.reservation_id
    FROM RESERVATION r
    JOIN RESERVATION_STATUS rs ON r.status_id = rs.status_id
    WHERE r.reservation_id = ? AND rs.status = 'Ongoing'
";
$stmtCheck = $conn->prepare($checkSql);
$stmtCheck->bind_param('i', $reservationId);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Reservation not found or not ongoing']);
    exit();
}
$stmtCheck->close();

// Get the status_id for 'Cancelled'
$statusSql = "SELECT status_id FROM RESERVATION_STATUS WHERE status = 'Cancelled'";
$statusResult = $conn->query($statusSql);
if (!$statusResult || $statusResult->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => "'Cancelled' status not found"]);
    exit();
}
$statusRow = $statusResult->fetch_assoc();
$cancelledStatusId = intval($statusRow['status_id']);

// Now update reservation status
$updateSql = "UPDATE RESERVATION SET status_id = ? WHERE reservation_id = ?";
$stmtUpdate = $conn->prepare($updateSql);
if (!$stmtUpdate) {
    echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
    exit();
}
$stmtUpdate->bind_param('ii', $cancelledStatusId, $reservationId);

if ($stmtUpdate->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmtUpdate->error]);
}

$stmtUpdate->close();
$conn->close();
?>

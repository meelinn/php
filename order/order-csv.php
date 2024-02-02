<?php
// 包含數據庫連接
require_once __DIR__ . '/parts/pdo-connect.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="orders.csv"');

$output = fopen('php://output', 'w');

fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// 寫入標題列
fputcsv($output, ['會員ID', '訂單ID', '產品ID', '訂單數量', '訂單狀態', '創建日期']);

// 查詢數據庫
$sql = "SELECT member_id, order_id, fk_product_id, order_quantity, order_state, created_at FROM orders";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>

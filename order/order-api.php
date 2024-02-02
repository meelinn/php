<?php
// order-api.php

header('Content-Type: application/json');

// 包含數據庫連接
require_once __DIR__ . '/parts/pdo-connect.php';

// 獲取HTTP請求的方法
$method = $_SERVER['REQUEST_METHOD'];

// 根據不同的HTTP方法處理不同的操作
$validFields = ['member_id', 'order_id', 'fk_product_id', 'order_quantity', 'order_state'];

try {
  switch ($method) {
    case 'GET':
      $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
      $pageSize = 10;
      $offset = ($page - 1) * $pageSize;
      $orderBy = isset($_GET['orderBy']) && in_array($_GET['orderBy'], $validFields) ? $_GET['orderBy'] : 'created_at';
      $orderDirection = isset($_GET['orderDirection']) && strtolower($_GET['orderDirection']) === 'desc' ? 'DESC' : 'ASC';

      $searchField = $_GET['searchField'] ?? '';
      $searchTerm = $_GET['searchTerm'] ?? '';

      $sql = "SELECT * FROM orders";
     $params = [];
      if ($searchField && in_array($searchField, $validFields) && $searchTerm) {
        $sql .= " WHERE $searchField LIKE :searchTerm";
        $params[':searchTerm'] = "%$searchTerm%";
      }

      
      
      $sql .= " ORDER BY $orderBy $orderDirection LIMIT :limit OFFSET :offset";

      $stmt = $pdo->prepare($sql);
      foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val);
      }

      $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // 计算总记录数
      $totalCountQuery = "SELECT COUNT(*) FROM orders";
      if ($searchField && in_array($searchField, $validFields) && $searchTerm) {
        $totalCountQuery .= " WHERE $searchField LIKE :searchTerm";
      }
      $totalCountStmt = $pdo->prepare($totalCountQuery);
      $totalCountStmt->execute($params);
      $totalRecords = $totalCountStmt->fetchColumn();

      // 计算总页数
      $totalPages = ceil($totalRecords / $pageSize);

      $response = [
        'orders' => $orders,
        'totalPages' => $totalPages
      ];
      echo json_encode($response);
      break;

    case 'POST':
      $input = json_decode(file_get_contents('php://input'), true);

      // 驗證和處理$input數據

      $stmt = $pdo->prepare("INSERT INTO orders (member_id, order_id, fk_product_id, order_quantity, order_state) VALUES (:member_id, :order_id, :fk_product_id, :order_quantity, :order_state)");
      $stmt->execute([
        ':member_id' => $input['member_id'],
        ':order_id' => $input['order_id'],
        ':fk_product_id' => $input['fk_product_id'],
        ':order_quantity' => $input['order_quantity'],
        ':order_state' => $input['order_state']
      ]);
      echo json_encode(['message' => '訂單已創建']);
     
      break;
      // 處理POST請求 - 新增訂單

    case 'PUT':
      $input = json_decode(file_get_contents('php://input'), true);

      // 確保從 $input 獲取所有需要的值
      $orderId = $input['order_id'];
      $orderQuantity = $input['order_quantity'];
      $orderState = $input['order_state'];

      // 更新數據庫
      $stmt = $pdo->prepare("UPDATE orders SET order_quantity = :order_quantity, order_state = :order_state WHERE order_id = :order_id");
      $stmt->execute([
        ':order_quantity' => $orderQuantity,
        ':order_state' => $orderState,
        ':order_id' => $orderId
      ]);
      echo json_encode(['message' => '訂單已更新']);
      break;


      // 在switch語句中處理DELETE請求
    case 'DELETE':
      // 解析查詢字符串以獲取order_id
      parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $queryParams);
      $orderId = $queryParams['order_id'] ?? '';

      // 執行刪除操作
      $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");
      $stmt->execute([':order_id' => $orderId]);

      echo json_encode(['message' => '訂單已刪除']);
      break;
    default:
      echo json_encode(['message' => 'HTTP方法不被支持']);
      break;
  }
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}

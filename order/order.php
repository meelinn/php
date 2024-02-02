<?php
require __DIR__ . '/parts/pdo-connect.php'; // 用於數據庫連接
require __DIR__ . '/parts/admin-required.php'; // 如果這是管理員專用頁面

// 這裡是獲取訂單數據的代碼
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1); // 确保页码最小为 1
$perPage = 5;

$totalRows = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalPages = ceil($totalRows / $perPage);

$offset = ($page - 1) * $perPage;
$sql = "SELECT member_id, order_id, fk_product_id, order_quantity, order_state, created_at FROM orders LIMIT $offset, $perPage";
try {
    $orders = $pdo->query($sql)->fetchAll();
} catch (PDOException $e) {
    die("數據庫查詢失敗: " . $e->getMessage());
}

?>



<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<style>
    /* 在這裡添加自定義的CSS */
</style>

</head>

<body>
    <!-- 在這裡添加訂單列表的HTML -->
    <div class="container mt-3" id="yourTableId">
        <h2>訂單列表</h2>

        <table class="table">
            <form id="searchForm">
                <div class="form-group">
                    <label for="searchTerm">搜尋訂單:</label>
                    <br>
                    <input type="text" class="form-control" id="searchTerm" name="searchTerm" placeholder="輸入搜尋關鍵字">
                </div>

                <div class="form-group">
                    <label for="searchField">篩選選項:</label>
                    <select class="form-control" id="searchField" name="searchField">
                        <option value="member_id">會員ID</option>
                        <option value="order_id">訂單ID</option>
                        <option value="fk_product_id">產品ID</option>
                        <option value="order_quantity">訂單數量</option>
                        <option value="order_state">訂單狀態</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">搜尋</button>
            </form>
            &nbsp;
            <button id="showAllOrders" class="btn btn-secondary">顯示全部</button>
            &nbsp;
            <a href="order-csv.php" class="btn btn-primary">匯出為CSV</a>


            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="javascript:void(0);" onclick="loadOrders(1)">第一頁</a>
                    </li>
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="javascript:void(0);" onclick="loadOrders(<?= max($page - 1, 1) ?>)">上一頁</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="javascript:void(0);" onclick="loadOrders(<?= $i ?>)"><?= $i ?></a>
                        </li>
                    <?php endfor ?>

                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="javascript:void(0);" onclick="loadOrders(<?= min($page + 1, $totalPages) ?>)">下一頁</a>
                    </li>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="javascript:void(0);" onclick="loadOrders(<?= $totalPages ?>)">最後一頁</a>
                    </li>
                </ul>
            </nav>
            <thead>
                <tr>
                    <th>
                        會員ID
                        <button onclick="sortOrders('member_id', 'asc');"><i class="fas fa-sort-up"></i></button>
                        <button onclick="sortOrders('member_id', 'desc');"><i class="fas fa-sort-down"></i></button>
                    </th>
                    <th>
                        訂單ID
                        <button onclick="sortOrders('order_id', 'asc');"><i class="fas fa-sort-up"></i></button>
                        <button onclick="sortOrders('order_id', 'desc');"><i class="fas fa-sort-down"></i></button>
                    </th>
                    <th>
                        產品ID
                        <button onclick="sortOrders('fk_product_id', 'asc');"><i class="fas fa-sort-up"></i></button>
                        <button onclick="sortOrders('fk_product_id', 'desc');"><i class="fas fa-sort-down"></i></button>
                    </th>
                    <th>
                        訂單數量
                        <button onclick="sortOrders('order_quantity', 'asc');"><i class="fas fa-sort-up"></i></button>
                        <button onclick="sortOrders('order_quantity', 'desc');"><i class="fas fa-sort-down"></i></button>
                    </th>
                    <th>
                        訂單狀態
                        <button onclick="sortOrders('order_state', 'asc');"><i class="fas fa-sort-up"></i></button>
                        <button onclick="sortOrders('order_state', 'desc');"><i class="fas fa-sort-down"></i></button>
                    </th>
                    <th>
                        訂單創建日期
                        <button onclick="sortOrders('created_at', 'asc');"><i class="fas fa-sort-up"></i></button>
                        <button onclick="sortOrders('created_at', 'desc');"><i class="fas fa-sort-down"></i></button>
                    </th>
                </tr>
            </thead>


            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= htmlspecialchars($order['member_id']) ?></td>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['fk_product_id']) ?></td>
                        <td class="orderQuantity"><?= htmlspecialchars($order['order_quantity']) ?></td>
                        <td class="orderState"><?= htmlspecialchars($order['order_state']) ?></td> 
                        <td ><?= htmlspecialchars($order['created_at']) ?></td>
                        <!-- 添加了類名 -->
                       
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- 編輯訂單的模態框 -->
<!-- 編輯訂單的模態框 -->
<div class="modal" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">編輯訂單</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editOrderForm">
                    <!-- 其他表單元素 -->

                    <div class="form-group">
                        <label for="editOrderQuantity">訂單數量</label>
                        <input type="number" class="form-control" id="editOrderQuantity" name="orderQuantity">
                    </div>
                    <div class="form-group">
                        <label for="editOrderState">訂單狀態</label>
                        <select class="form-control" id="editOrderState" name="orderState">
                            <option value="待處理">待處理</option>
                            <option value="處理中">處理中</option>
                            <option value="已發貨">已發貨</option>
                            <option value="已送達">已送達</option>
                            <option value="已取消">已取消</option>
                            <!-- 添加其他需要的狀態 -->
                        </select>
                    </div>
                    <input type="hidden" id="editOrderId" name="orderId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                <button type="button" class="btn btn-primary" id="saveEdit">保存更改</button>
            </div>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        var currentSearchField = '';
        var currentSearchTerm = '';
        var currentPage = 1; // 預設頁碼
        var totalPages = 0; // 假設的總頁數，您需要根據實際情況調整
        var currentSortColumn = 'order_id';
        var currentSortDirection = 'DESC';

        function sortOrders(orderBy) {

            if (currentSortColumn === orderBy) {
                currentSortDirection = currentSortDirection === 'ASC' ? 'DESC' : 'ASC';
            } else {
                currentSortColumn = orderBy;
                currentSortDirection = 'ASC';
            }
            loadOrders(currentPage, currentSearchField, currentSearchTerm, currentSortColumn, currentSortDirection);
        }

        function loadOrders(page, searchField = currentSearchField, searchTerm = currentSearchTerm, orderBy = currentSortColumn, orderDirection = currentSortDirection) {


            $.ajax({
                url: 'order-api.php',
                type: 'GET',
                data: {
                    page: page,
                    searchField: searchField,
                    searchTerm: searchTerm,
                    orderBy: orderBy,
                    orderDirection: orderDirection,
                    timestamp: new Date().getTime()
                },

                success: function(data) {
                    orders = data.orders;
                    totalPages = data.totalPages; // 從後端獲取的總頁數
                    currentPage = page; // 更新全局变量

                    var tableBody = $('#yourTableId tbody');
                    tableBody.empty();
                    $.each(orders, function(i, order) {
                        var row = $('<tr id="order-row-' + order.order_id + '"></tr>');
                        row.append('<td>' + order.member_id + '</td>');
                        row.append('<td>' + order.order_id + '</td>');
                        row.append('<td>' + order.fk_product_id + '</td>');
                        row.append('<td>' + order.order_quantity + '</td>');
                        row.append('<td>' + order.order_state + '</td>');
                        row.append('<td>' + order.created_at + '<td>');
                        row.append('<td><button class="btn btn-primary edit-btn" data-id="' + order.order_id + '">編輯</button>' +
                            '<button class="btn btn-danger delete-btn" data-id="' + order.order_id + '">刪除</button></td>');
                        tableBody.append(row);
                    });
                    $('.pagination').off('click', '.page-link');
                    updatePaginationControls(totalPages, currentPage, searchField, searchTerm);
                    bindButtonEvents();
                },
                error: function(error) {
                    console.error("An error occurred: " + error.statusText);
                }
            });
        }

        function updatePaginationControls(totalPages, currentPage, searchField, searchTerm) {
            var paginationDiv = $('.pagination');
            paginationDiv.empty(); // 清空现有的分页控件

            var maxPageButtons = 5; // 最大分頁按鈕數
            var startPage, endPage;

            if (totalPages <= maxPageButtons) {
                // 总页数小于等于最大分页按钮数时，显示所有页码
                startPage = 1;
                endPage = totalPages;
            } else {
                // 确定分页按钮的开始和结束页码
                startPage = Math.max(currentPage - 2, 1);
                endPage = startPage + maxPageButtons - 1;

                // 处理边界情况
                if (endPage > totalPages) {
                    endPage = totalPages;
                    startPage = endPage - maxPageButtons + 1;
                }
            }

            // 添加第一頁和上一页按钮
            paginationDiv.append('<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="loadOrders(1); return false;">第一頁</a></li>');
            paginationDiv.append('<li class="page-item ' + (currentPage === 1 ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="loadOrders(' + Math.max(1, currentPage - 1) + '); return false;">上一頁</a></li>');

            // 生成数字分页按钮
            for (let i = startPage; i <= endPage; i++) {
                var activeClass = i === currentPage ? 'active' : '';
                paginationDiv.append('<li class="page-item ' + activeClass + '"><a class="page-link" href="#" onclick="loadOrders(' + i + ',\'' + searchField + '\',\'' + searchTerm + '\'); return false;">' + i + '</a></li>');
            }


            // 添加下一页和最后一页按钮
            paginationDiv.append('<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="loadOrders(' + Math.min(totalPages, currentPage + 1) + '); return false;">下一頁</a></li>');
            paginationDiv.append('<li class="page-item ' + (currentPage === totalPages ? 'disabled' : '') + '"><a class="page-link" href="#" onclick="loadOrders(' + totalPages + '); return false;">最後一頁</a></li>');
        }

        // 為新創建的按鈕綁定事件
        $('.page-button').on('click', function() {
            var selectedPage = $(this).data('page');
            currentPage = selectedPage;
            loadOrders(currentPage);
        });


        $(document).ready(function() {
            loadOrders(currentPage, currentSearchField, currentSearchTerm, currentSortColumn, currentSortDirection);
            bindButtonEvents(); // 初始时绑定按钮事件

            $('#showAllOrders').on('click', function() {
                loadOrders(1);
            })


            $('#searchForm').submit(function(e) {
                e.preventDefault();
                currentSearchField = $('#searchField').val();
                currentSearchTerm = $('#searchTerm').val();
                loadOrders(1, currentSearchField, currentSearchTerm, currentSortColumn, currentSortDirection);
            });

            $('.pagination').off('click', '.page-link').on('click', '.page-link', function(e) {
                e.preventDefault();
                var clickedPage = $(this).text();
                var newPage;

                switch (clickedPage) {
                    case '第一頁':
                        newPage = 1;
                        break;
                    case '上一頁':
                        newPage = Math.max(1, currentPage - 1);
                        break;
                    case '下一頁':
                        newPage = Math.min(totalPages, currentPage + 1);
                        break;
                    case '最後一頁':
                        newPage = totalPages;
                        break;
                    default:
                        newPage = parseInt(clickedPage);
                }

                loadOrders(newPage, currentSearchField, currentSearchTerm);
            });
        });

        function bindButtonEvents() {
            $('.edit-btn').off('click').on('click', function() {
                var orderId = $(this).data('id');
                $('#editOrderId').val(orderId);
                $('#editModal').modal('show');
                // AJAX 請求以獲取訂單詳細信息並顯示模態框
                // ...
            });
        }


        $('#yourTableId').on('click', '.delete-btn', function() {
            var orderId = $(this).data('id');
            var button = $(this); // 保存当前按钮的引用
            if (confirm('確定要刪除此訂單')) {
                $.ajax({
                    url: 'order-api.php?order_id=' + orderId,
                    type: 'DELETE',
                    success: function(result) {
                        button.closest('tr').remove();
                    },
                    error: function(xhr, status, error) {
                        alert("删除失败: " + error);
                    }
                });
            }
        });

        $('#saveEdit').on('click', function() {
            // 處理表單提交
            var orderData = {
                order_id: $('#editOrderId').val(), // 確保這裡是您用來識別訂單的唯一ID
                order_quantity: $('#editOrderQuantity').val(),
                order_state: $('#editOrderState').val()
            };
            console.log(orderData); // 打印以检查数据


            // 發送 AJAX 請求更新數據
            $.ajax({
                url: 'order-api.php',
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(orderData), // 使用 orderData 變量
                // 省略其餘代碼...
                success: function(result) {
                    // 處理成功的回應
                    alert("訂單編輯更新成功！");
                    $('#editModal').modal('hide');

                    // 更新頁面上的相關元素
                    var updatedRow = $('#order-row-' + orderData.order_id);
                    var newStateDisplayText = $("#editOrderState option:selected").text();
    updatedRow.find('.orderState').text(newStateDisplayText);

                    console.log(updatedRow); // 打印以检查是否选中了正确的行
                    updatedRow.find('.orderQuantity').text(orderData.order_quantity);
                    updatedRow.find('.orderState').text(orderData.order_state);

                },
                error: function(xhr, status, error) {
                    // 處理錯誤的回應
                    alert("您的訂單編輯更新失敗" + error);
                }
            });
        });

        // 綁定分頁按鈕事件
        $('#prevPage').on('click', function() {
            if (currentPage > 1) {
                currentPage--; // 減少頁碼
                loadOrders(currentPage); // 加載新頁碼的數據
            }
        });

        $('#nextPage').on('click', function() {
            // 假設您知道總頁數是 totalPages
            // 如果不知道總頁數，您可能需要從後端獲取或通過其他方式確定
            if (currentPage < totalPages) {
                currentPage++; // 增加頁碼
                loadOrders(currentPage); // 加載新頁碼的數據
            }
        });
        // 初始載入
        loadOrders(currentPage);
    </script>
</body>

</html>
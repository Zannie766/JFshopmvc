<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$config = require 'config.php';
$base = $config['base'];
$baseURL = $config['baseURL'];
$assets = $config['assets'];

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý sản phẩm và doanh thu</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> <!-- Thư viện xuất Excel -->
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
    h1, h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    th { background-color: #007bff; color: white; }
    .controls { margin-top: 20px; text-align: center; }
    .controls input, .controls button { margin: 5px; padding: 10px; }
    .btn { background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
    .btn:hover { background-color: #218838; }
    #topCustomers { margin-top: 30px; }
  </style>
</head>
<body>

<h1>Quản lý sản phẩm - Doanh thu</h1>

<div class="controls">
  <input type="text" id="searchInput" placeholder="Tìm theo tên khách hàng...">
  <input type="date" id="startDate">
  <input type="date" id="endDate">
  <button class="btn" onclick="loadProducts()">Lọc</button>
  <button class="btn" onclick="exportExcel()">Xuất Excel</button>
</div>

<table id="productTable">
  <thead>
    <tr>
      <th>Tên sản phẩm</th>
      <th>Giá bán (VND)</th>
      <th>Số lượng bán</th>
      <th>Doanh thu (VND)</th>
      <th>Khách hàng</th>
      <th>Ngày mua</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody id="productTableBody"></tbody>
</table>

<h2 id="totalRevenue">Tổng doanh thu: 0 VND</h2>

<div id="topCustomers">
  <h2>Top Khách hàng</h2>
  <ul id="topCustomerList"></ul>
</div>

<script>
function loadProducts() {
  const products = JSON.parse(localStorage.getItem("products")) || [];
  const tableBody = document.getElementById("productTableBody");
  tableBody.innerHTML = "";

  const search = document.getElementById("searchInput").value.trim().toLowerCase();
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;

  let totalRevenue = 0;
  const customerRevenue = {};

  products.forEach((product, index) => {
    const revenue = product.price * product.sold;
    const productDate = product.date || "2025-01-01"; // nếu không có ngày thì gán tạm

    if (product.customer.toLowerCase().includes(search)) {
      if ((!startDate || productDate >= startDate) && (!endDate || productDate <= endDate)) {
        totalRevenue += revenue;

        customerRevenue[product.customer] = (customerRevenue[product.customer] || 0) + revenue;

        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${product.name}</td>
          <td>${product.price.toLocaleString()}</td>
          <td>${product.sold}</td>
          <td>${revenue.toLocaleString()}</td>
          <td>${product.customer}</td>
          <td>${product.date}</td>
          <td><button onclick="deleteProduct(${index})" class="btn" style="background:#dc3545;">Xóa</button></td>
        `;
        tableBody.appendChild(row);
      }
    }
  });

  document.getElementById("totalRevenue").innerText = `Tổng doanh thu: ${totalRevenue.toLocaleString()} VND`;

  // Top khách hàng
  const topList = Object.entries(customerRevenue)
    .sort((a, b) => b[1] - a[1])
    .slice(0, 5);

  const ul = document.getElementById("topCustomerList");
  ul.innerHTML = "";
  topList.forEach(([name, revenue]) => {
    const li = document.createElement("li");
    li.textContent = `${name}: ${revenue.toLocaleString()} VND`;
    ul.appendChild(li);
  });
}

function deleteProduct(index) {
  const products = JSON.parse(localStorage.getItem("products")) || [];
  products.splice(index, 1);
  localStorage.setItem("products", JSON.stringify(products));
  loadProducts();
}

function exportExcel() {
  const products = JSON.parse(localStorage.getItem("products")) || [];
  const exportData = products.map(product => ({
    "Tên sản phẩm": product.name,
    "Giá bán (VND)": product.price,
    "Số lượng bán": product.sold,
    "Doanh thu (VND)": product.price * product.sold,
    "Khách hàng": product.customer,
    "Ngày mua": product.date || ""
  }));

  const worksheet = XLSX.utils.json_to_sheet(exportData);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Doanh thu");

  XLSX.writeFile(workbook, "doanh_thu.xlsx");
}

window.onload = loadProducts;
</script>

</body>
</html>
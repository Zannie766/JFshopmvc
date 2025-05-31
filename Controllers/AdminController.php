<?php
require_once __DIR__ . '/../Models/AdminModel.php';

class AdminController {
    private $adminModel;

    public function __construct(AdminModel $adminModel) {
        $this->adminModel = $adminModel;
        // Removed the recursive instantiation bug
    }

    public function index() {
        // Load config
        $config = require __DIR__ . '/../config.php';
        $base = $config['base'];
        $baseURL = $config['baseURL'];
        $assets = $config['assets'];

        // Initialize data array
        $data = [];

        // Handle revenue actions (add, update, delete)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            $id = $_POST['id'] ?? null;
            $amount = $_POST['amount'] ?? 0;
            $description = $_POST['description'] ?? '';
            $date = $_POST['date'] ?? date('Y-m-d');

            try {
                if ($action === 'add_revenue') {
                    $this->adminModel->addRevenue($amount, $description, $date);
                    $data['success'] = 'Thêm doanh thu thành công!';
                } elseif ($action === 'update_revenue' && $id) {
                    $this->adminModel->updateRevenue($id, $amount, $description, $date);
                    $data['success'] = 'Cập nhật doanh thu thành công!';
                } elseif ($action === 'delete_revenue' && $id) {
                    $this->adminModel->deleteRevenue($id);
                    $data['success'] = 'Xóa doanh thu thành công!';
                }
            } catch (Exception $e) {
                $data['error'] = 'Lỗi thao tác: ' . $e->getMessage();
            }
        }

        // Check if password is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
            $password = $_POST['password'];
            if ($this->adminModel->verifyPassword($password)) {
                try {
                    // Fetch data for dashboard
                    $data = array_merge($data, [
                        'userCount' => $this->adminModel->countUsers(),
                        'recentActivities' => $this->adminModel->getRecentActivities(10),
                        'totalRevenue' => $this->adminModel->calculateTotalRevenue(),
                        'revenueRecords' => $this->adminModel->getRevenueRecords(10),
                        'chartData' => $this->generateChartData(),
                        'isAuthenticated' => true
                    ]);
                } catch (Exception $e) {
                    $data = [
                        'error' => 'Không thể tải dữ liệu: ' . $e->getMessage(),
                        'isAuthenticated' => false
                    ];
                }
            } else {
                $data = [
                    'error' => 'Mật khẩu không đúng!',
                    'isAuthenticated' => false
                ];
            }
        } else {
            $data['isAuthenticated'] = $data['isAuthenticated'] ?? false;
        }

        // Extract data for use in view
        extract($data);

        // Load the view
        require_once __DIR__ . '/../Views/admin.php';
    }

    private function generateChartData() {
        try {
            $monthlyRevenue = $this->adminModel->getMonthlyRevenue(6); // Last 6 months
            $labels = [];
            $data = [];
            $currentMonth = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            
            for ($i = 5; $i >= 0; $i--) {
                $month = (clone $currentMonth)->modify("-$i months");
                $monthKey = $month->format('Y-m');
                $labels[] = $month->format('M Y');
                $data[] = isset($monthlyRevenue[$monthKey]) ? $monthlyRevenue[$monthKey] : 0;
            }

            return [
                'type' => 'bar',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => 'Doanh thu ($)',
                            'data' => $data,
                            'backgroundColor' => ['#e84393', '#dc3545', '#007bff', '#28a745', '#ffc107', '#17a2b8'],
                            'borderColor' => ['#d73683', '#c82333', '#0056b3', '#218838', '#e0a800', '#138496'],
                            'borderWidth' => 1
                        ]
                    ]
                ],
                'options' => [
                    'scales' => [
                        'y' => ['beginAtZero' => true, 'title' => ['display' => true, 'text' => 'Doanh thu ($)']],
                        'x' => ['title' => ['display' => true, 'text' => 'Tháng']]
                    ]
                ]
            ];
        } catch (Exception $e) {
            return [
                'type' => 'bar',
                'data' => ['labels' => [], 'datasets' => []],
                'options' => []
            ];
        }
    }

    // Add user management methods
    public function addUser($username, $email, $revenue) {
        try {
            return $this->adminModel->addUser($username, $email, $revenue);
        } catch (Exception $e) {
            throw new Exception('Không thể thêm người dùng: ' . $e->getMessage());
        }
    }

    public function updateUser($id, $username, $email, $revenue) {
        try {
            return $this->adminModel->updateUser($id, $username, $email, $revenue);
        } catch (Exception $e) {
            throw new Exception('Không thể cập nhật người dùng: ' . $e->getMessage());
        }
    }

    public function deleteUser($id) {
        try {
            return $this->adminModel->deleteUser($id);
        } catch (Exception $e) {
            throw new Exception('Không thể xóa người dùng: ' . $e->getMessage());
        }
    }

    public function getUsers() {
        try {
            return $this->adminModel->getUsers();
        } catch (Exception $e) {
            return [];
        }
    }
}
?>
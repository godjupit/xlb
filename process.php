<?php
// 配置 MySQL 连接参数
$host = '127.0.0.1';
$port = 3306;
$dbname = 'xlb';
$username = 'root';
$password = 'CA5SyB4YTDtnt6d3';

// 创建 PDO 实例来连接数据库
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    //如果没有用户表，创建用户表
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL
    )";
    $pdo->exec($sql);

    // 检查请求方式是否为 POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 获取表单数据
        $name = $_POST['name'];
        $email = $_POST['email'];
        $action = $_POST['action'];
        
        // 数据验证（简单检查）
        if (empty($name) || empty($email)) {
            echo "用户名和邮箱不能为空。";
            exit;
        }

        // 注册操作
        if ($action === 'register') {
            // 检查是否已有该邮箱或用户名
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR name = :name");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $userCount = $stmt->fetchColumn();

            if ($userCount > 0) {
                // 如果已存在用户，返回错误信息
                echo "fail_register";
                exit;
            }

            // 使用预处理语句插入数据到数据库
            $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // 返回成功信息
            echo "success_register"; // 返回给前端注册成功的标识
            exit;

        } elseif($action === 'login') {
            // 使用预处理语句查询数据库
            $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name AND email = :email");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();

            // 如果用户存在，输出欢迎信息
            if ($user) {
                
                echo "success_login!";
                
                exit;
            } else {
                // 如果用户不存在，输出错误信息
                echo "用户不存在，请先注册。";
                exit;
            }
            
        }
    }
} catch (PDOException $e) {
    // 如果数据库连接失败，输出错误信息
    echo "数据库连接失败：" . $e->getMessage();
    exit;
}
?>

<?php
// 数据库连接
$host = '127.0.0.1';
$port = 3306;
$dbname = 'xlb';
$username = 'root';
$password = 'CA5SyB4YTDtnt6d3';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // 如果没有帖子表，创建帖子表
    $sql = "CREATE TABLE IF NOT EXISTS posts (
          id INT AUTO_INCREMENT PRIMARY KEY,
        user_name VARCHAR(50) NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_id INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 获取表单数据
        $userName = htmlspecialchars($_POST['userName'], ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
        $user_id = $_POST['user_id'];
       

        // 插入用户id
        
        //$stmt = $pdo->prepare("INSERT INTO posts (user_name, content) VALUES (:userName, :content)");
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, user_name, content) VALUES (:user_id, :userName, :content)");
    
        // 绑定参数
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':content', $content);

        $stmt->bindParam(':user_id', $user_id);

        // 执行插入操作
        $stmt->execute();


        // 返回成功响应
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

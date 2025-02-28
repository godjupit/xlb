<?php
$host = '127.0.0.1';
$port = 3306;
$dbname = 'xlb';
$username = 'root';
$password = 'CA5SyB4YTDtnt6d3';

   
$dsn = "mysql:host=$host;port=$port;dbname=$dbname";
$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 查询所有博客
$stmt = $pdo->prepare("SELECT id,filedata FROM files");
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
// foreach ($blogs as &$blog) {
//     // 将二进制数据转为 base64 编码
//     $blog['filedata'] = base64_encode($blog['filedata']);
// }
// 返回 JSON 格式的博客内容
echo json_encode([
    'success' => true,
    'blogs' => $blogs
]);


?>

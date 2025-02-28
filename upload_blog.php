<?php


    ini_set('display_errors', 1);  // 开启错误显示
    error_reporting(E_ALL);         // 显示所有错误




    $host = '127.0.0.1';
    $port = 3306;
    $dbname = 'xlb';
    $username = 'root';
    $password = 'CA5SyB4YTDtnt6d3';

    $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $sql = "CREATE TABLE IF NOT EXISTS files (
        id INT AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(255),
        filedata LONGBLOB NOT NULL
    )";


    $pdo->exec($sql);
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $filetmp = $_FILES['mdFile']['tmp_name'];
       
        //$userName = htmlspecialchars($_POST['userName'], ENT_QUOTES, 'UTF-8');
    // 读取文件内容
        
        $filedata = file_get_contents($filetmp);
        
        $stmt = $pdo->prepare("INSERT INTO files (filedata) VALUES (:filedata)");
        $stmt->bindParam(':filedata', $filedata);
        
        $stmt->execute();
        
        echo json_encode([
            'success' => true,
            'message' => 'File uploaded successfully'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }

?>
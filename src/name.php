<div class="w-full text-center">
<p class="text-red-500">
Hello
<?php
// error_log("dir: " . __DIR__);
// require_once __DIR__ . "/../vendor/autoload.php";

// use Simplon\Mysql\PDOConnector;
// require_once "mysql/mysql-connector-php";
// require_once "/usr/lib/php/20210902/mysqli.so";
// require_once "mysqli.so";

// $host = "localhost";
$host = "172.19.0.2";
$user = "root";
$password = "pass";
$database = "hero";

$conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

// $pdo = new PDOConnector(
//   $host,
//   $user,
//   $password,
//   $database
// );

// $pdoConn = $pdo->connect("utf8", []);

// $db = new Manager($host, $database, $user, $password);

error_log("Connected successfully");

// $db->disconnect();

echo $_POST["name"];
?>
!
</p>
</div>
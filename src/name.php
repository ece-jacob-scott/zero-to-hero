<div class="w-full text-center">
<p class="text-red-500">
Hello
<?php
require_once __DIR__ . "/../libraries/errors.php";

// check for HTMX header
if ($_SERVER["HTTP_HX_REQUEST"] != "true") {
  error_log("HX-Request header not found");

  header("Location: /");

  return;
}

use SQLite3;

$database = new SQLite3(__DIR__ . "/test.db");

error_log("Connected successfully");

$name = $_POST["name"];

// create names table if one doesn't exist
$database->query("CREATE TABLE IF NOT EXISTS names (name TEXT)");

// check if name already exists
$statement = $database->prepare("SELECT * FROM names WHERE name = :name");
$statement->bindValue(":name", $name);
$results = $statement->execute();

$array_results = $results->fetchArray();

// return the name
if ($array_results) {
  error_log("Name already exists");
  // echo $results->fetchArray()[0];
  $database->close();

  echo $array_results[0];
} else {
  $statement = $database->prepare("INSERT INTO names (name) VALUES (:name)");
  $statement->bindValue(":name", $name);

  $results = $statement->execute();

  $database->close();

  echo $name;
}
?>
!
</p>
</div>
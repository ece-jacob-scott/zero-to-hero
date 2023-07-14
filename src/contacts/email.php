<?php
// validate email

if ($_SERVER["REQUEST_METHOD"] != "GET") {
  http_response_code(303);
  header("Location: /contacts");
  exit();
}

$email = $_GET["email"];
$id = $_GET["id"];

$database = new SQLite3(__DIR__ . "/../../test.db");

$statement = $database->prepare(
  "SELECT * FROM contacts WHERE email = :email AND id != :id"
);
$statement->bindValue(":email", $email);
$statement->bindValue(":id", $id);
$results = $statement->execute();

$contact = $results->fetchArray(SQLITE3_ASSOC);

if ($contact && count($contact) != 0) {
  echo "<p id='error-container' class='w-full py-1 px-2 text-red-700 font-semibold'>Error: email is already in use</p>";
} else {
  echo "<p id='error-container' class='w-full py-1 px-2 text-red-700 font-semibold hidden'></p>";
}

$database->close();
exit();

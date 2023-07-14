<?php
// get id from query parameters
$contact_id = $_GET["id"];

if (!$contact_id) {
  // if there is no contact id, redirect to the contacts page
  error_log("No contact id provided");
  http_response_code(303);
  header("Location: /contacts");
  exit();
}

// if the form was submitted, delete the contact
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
  $database = new SQLite3(__DIR__ . "/../../test.db");

  $statement = $database->prepare("DELETE FROM contacts WHERE id = :id");
  $statement->bindValue(":id", $contact_id);
  $statement->execute();

  // redirect to the contact page
  http_response_code(303);
  header("Location: /contacts");
  $database->close();
  exit();
}

// redirect to the contact page if the form was not submitted
http_response_code(303);
header("Location: /contacts");

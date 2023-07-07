<?php include "../../components/header.php"; ?>

<?php
$contact_id = $_GET["id"];

if (!$contact_id) {
  // if there is no contact id, redirect to the contacts page
  header("Location: /contacts");
  exit();
}

$database = new SQLite3(__DIR__ . "/../../test.db");

// query the database for the contact with the given id
$statement = $database->prepare("SELECT * FROM contacts WHERE id = :id");
$statement->bindValue(":id", $contact_id);
$results = $statement->execute();

$contact = $results->fetchArray(SQLITE3_ASSOC);

// if the contact doesn't exist, redirect to the contacts page
if (!$contact) {
  // TODO: flash message
  header("Location: /contacts");
  exit();
}

// display the contact
$email = $contact["email"];
$first_name = $contact["first_name"];
$last_name = $contact["last_name"];
$phone_number = $contact["phone"];
?>


<div class="w-1/2 mx-auto">

<h1 class="text-2xl font-semibold">
  <?php echo $first_name . " " . $last_name; ?>
</h1>
<div class="p-1"></div>
<div>
  <p>
      <span class="font-semibold">Phone Number:</span> <?php echo $phone_number; ?>
  </p>
  <p>
      <span class="font-semibold">Email:</span> <?php echo $email; ?>
  </p>
</div>

<div class="p-2"></div>

<p>
    <a href="/edit.php?id=<?php echo $contact_id; ?>" class="hover:cursor-pointer hover:text-red-700 font-semibold">Edit</a>
    <a href="/contacts" class="hover:cursor-pointer hover:text-red-700 font-semibold">Back</a>
</p>
</div>

<?php include "../../components/footer.php"; ?>

<?php include "../../components/header.php"; ?>

<?php // get the ID from the query parameters


$contact_id = $_GET["id"];
// get contact from the database

if (!$contact_id) {
  // if there is no contact id, redirect to the contacts page
  error_log("No contact id provided");
  header("Location: /contacts");
  exit();
}

// if the form was submitted, update the contact
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $phone_number = $_POST["phone"];

  // validate the form
  $error_message = "";

  if (!$email || $email == "") {
    $error_message = "Email is required";
  } elseif (!$first_name || $first_name == "") {
    $error_message = "First name is required";
  } elseif (!$last_name || $last_name == "") {
    $error_message = "Last name is required";
  } elseif (!$phone_number || $phone_number == "") {
    $error_message = "Phone number is required";
  }

  $database = new SQLite3(__DIR__ . "/../../test.db");

  // check if the email is already in use
  $statement = $database->prepare(
    "SELECT * FROM contacts WHERE email = :email AND id != :id"
  );
  $statement->bindValue(":email", $email);
  $statement->bindValue(":id", $contact_id);
  $results = $statement->execute();

  $contact = $results->fetchArray(SQLITE3_ASSOC);

  if ($contact) {
    $error_message = "Email is already in use";
    $database->close();
  }

  // if there was no error, update the contact
  if ($error_message == "") {
    // update the contact
    $statement = $database->prepare(
      "UPDATE contacts SET email = :email, first_name = :first_name, last_name = :last_name, phone = :phone WHERE id = :id"
    );
    $statement->bindValue(":email", $email);
    $statement->bindValue(":first_name", $first_name);
    $statement->bindValue(":last_name", $last_name);
    $statement->bindValue(":phone", $phone_number);
    $statement->bindValue(":id", $contact_id);
    $statement->execute();

    // redirect to the contact page
    header("Location: /contacts");
    $database->close();
    exit();
  }
}

$database = new SQLite3(__DIR__ . "/../../test.db");

// query the database for the contact with the given id
$statement = $database->prepare("SELECT * FROM contacts WHERE id = :id");
$statement->bindValue(":id", $contact_id);
$results = $statement->execute();

$contact = $results->fetchArray(SQLITE3_ASSOC);

// if the contact doesn't exist, redirect to the contacts page
if (!$contact) {
  header("Location: /contacts");
}

// display the contact
$email = $contact["email"];
$first_name = $contact["first_name"];
$last_name = $contact["last_name"];
$phone_number = $contact["phone"];
?>

<div class="w-1/2 mx-auto">

<p id="error-container"
   class="w-full py-1 px-2 text-red-700 font-semibold <?php if (
     $error_message == ""
   ) {
     echo "hidden";
   } ?>">
   Error: <?php echo $error_message; ?>
</p>

<form action="/contacts/edit.php?id=<?php echo $contact_id; ?>" method="post"> 
    <fieldset>
      <legend class="text-2xl">Contact Values</legend>
      <div class=p-4></div>

      <input name="email" 
             placeholder="Email..." 
             class="border w-full text-gray-700 py-1 px-2" 
             id="email" 
             type="email" 
             value="<?php echo $email; ?>" 
             hx-get="/contacts/email.php?id=<?php echo $contact_id; ?>"
             hx-target="#error-container"
             hx-swap="outerHTML"
             hx-trigger="change, keyup delay:200ms changed">
      <div class=p-2></div>

      <input name="first_name" 
             placeholder="First Name..." 
             class="border w-full text-gray-700 py-1 px-2" 
             id="first_name" 
             type="text" 
             value="<?php echo $first_name; ?>"> 
      <div class=p-2></div>

      <input name="last_name" 
             placeholder="Last Name..." 
             class="border w-full text-gray-700 py-1 px-2" 
             id="last_name" 
             type="text" 
             value="<?php echo $last_name; ?>"> 
      <div class=p-2></div>

      <input name="phone" 
             placeholder="Phone Number..." 
             class="border w-full text-gray-700 py-1 px-2" 
             id="phone" 
             type="text"
             value="<?php echo $phone_number; ?>"> 
      <div class=p-2></div>
      <button
        class="w-full flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-sm border-4 text-white py-1 px-2 rounded uppercase"
        type="submit"
      >
        update
      </button>
    </fieldset>
</form>

<div class=p-1></div>

<button 
    hx-delete="/contacts/delete.php?id=<?php echo $contact_id; ?>"
    hx-target="body"
    hx-push-url="true"
    hx-confirm="Are you sure you want to delete this contact?"
    class="w-full flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-sm border-4 text-white py-1 px-2 rounded uppercase" type="submit">
  Delete Contact
</button>

<p>
    <a href="/contacts" class="hover:cursor-pointer hover:text-red-700 font-semibold">Back</a>
</p>

<div>

<?php include "../../components/footer.php"; ?>

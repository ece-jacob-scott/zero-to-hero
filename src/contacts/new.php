<?php include "../../components/header.php"; ?>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
  error_log("Creating new contact");
  // check if the request is a POST request
  // get the values from the request
  $email = $_POST["email"];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $phone_number = $_POST["phone"];

  // connect to the database
  $database = new SQLite3(__DIR__ . "/../../test.db");
  error_log("Connected successfully");

  // insert the new contact into the database
  $statement = $database->prepare(
    "INSERT INTO contacts (email, first_name, last_name, phone) VALUES (:email, :first_name, :last_name, :phone)"
  );
  $statement->bindValue(":email", $email);
  $statement->bindValue(":first_name", $first_name);
  $statement->bindValue(":last_name", $last_name);
  $statement->bindValue(":phone", $phone_number);
  $ret = $statement->execute();

  $error_message = "";
  if (!$ret) {
    // if the insert failed, print an error message
    error_log($database->lastErrorMsg());
    $error_message = "failed to create contact";
  } else {
    // if the insert succeeded, print a success message
    error_log("Contact created successfully");
  }

  // Successful insert
  if ($error_message == "") {
    // if there was an error, print the error message
    echo "<p class='text-red-700'>$error_message</p>";
    // redirect the user to the contacts page
    header("Location: /contacts");
    $database->close();
    exit();
  }
} ?>

<div class="w-1/2 mx-auto">

<?php // if there was an error, print the error message

if ($error_message != "") {
  echo "<p class='w-full py-1 px-2 text-red-700 font-semibold'>Error: $error_message</p>";
  $database->close();
} ?>

<form action="/contacts/new.php" method="post"> 
    <fieldset>
      <legend class="text-2xl">Contact Values</legend>
      <div class=p-4></div>

      <input name="email" 
             placeholder="Email..." 
             class="border w-full text-gray-700 py-1 px-2" 
             id="email" 
             type="email" 
             value="<?php echo $_POST["email"]; ?>"> 
      <div class=p-2></div>

      <input name="first_name" 
             placeholder="First Name..." 
             class="border w-full text-gray-700 py-1 px-2" 
             id="first_name" 
             type="text" 
             value="<?php echo $_POST["first_name"]; ?>"> 
      <div class=p-2></div>

      <input name="last_name" 
             placeholder="Last Name..." 
             class="border w-full text-gray-700 py-1 px-2" 
             id="last_name" 
             type="text" 
             value="<?php echo $_POST["last_name"]; ?>"> 
      <div class=p-2></div>

      <input name="phone" 
             placeholder="Phone Number..." 
             class="border w-full text-gray-700 py-1 px-2" 
             id="phone" 
             type="text"
             value="<?php echo $_POST["phone"]; ?>"> 
      <div class=p-2></div>
      <button
        class="w-full flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-sm border-4 text-white py-1 px-2 rounded uppercase"
        type="submit"
      >
      save
      </button>
    </fieldset>
</form>

<p>
    <a href="/contacts" class="hover:cursor-pointer hover:text-red-700 font-semibold">Back</a>
</p>

<div>

<?php include "../../components/footer.php"; ?>

<?php include "../../components/header.php"; ?>
<div class="w-1/2 mx-auto">
  <h1 class="text-red-400 text-2xl">Contacts</h1>
  <hr class="h-px mb-8 bg-gray-200 border-0 dark:bg-gray-700"/>
  <!--Search Term Form-->
  <form class="w-full" action="/contacts" method="get">
    <div class="flex items-center py-2">
      <input
        class="border w-full text-gray-700 mr-3 py-1 px-2"
        type="text"
        placeholder="Search Contacts"
        aria-label="Search Contacts"
        name="q"
        value="<?php echo $_GET["q"]; ?>"
      />
      <button
        class="flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-sm border-4 text-white py-1 px-2 rounded"
        type="submit"
      >
        Search
      </button>
    </div>

    <table class="w-full table-fixed border-separate border-spacing-y-4"> 
      <thead class="font-semibold text-black uppercase">
        <tr>
            <th scope="col" class="text-left px-6 py-3 bg-red-100">First</th> 
            <th scope="col" class="text-left px-6 py-3 bg-red-100">Last</th>
            <th scope="col" class="text-left px-6 py-3 bg-red-100">Phone</th>
            <th scope="col" class="text-left px-6 py-3 bg-red-100">Email</th>
            <th scope="col" class="text-left px-6 py-3 bg-red-100"></th>
        </tr>
        </thead>
        <tbody>

<?php
$database = new SQLite3(__DIR__ . "/../../test.db");

error_log("Connected successfully");

// check for search query in request arguments
$search = $_GET["q"];

if ($search) {
  error_log("Searching for $search");
  // query the database for contacts matching the search query
  $statement = $database->prepare(
    "SELECT * FROM contacts WHERE first_name LIKE :search"
  );
  $statement->bindValue(":search", "%$search%");
  $results = $statement->execute();
} else {
  // query the database for all contacts
  $results = $database->query("SELECT * FROM contacts");
}

while ($contact = $results->fetchArray(SQLITE3_ASSOC)) {

  // display each contact
  // echo "<p>" . $row["email"] . "</p>";
  $id = $contact["id"];
  $email = $contact["email"];
  $first_name = $contact["first_name"];
  $last_name = $contact["last_name"];
  $phone_number = $contact["phone"];
  ?>

  <tr>
    <td class='text-left px-6 py-3'><?php echo $first_name; ?></td>
    <td class='text-left px-6 py-3'><?php echo $last_name; ?></td>
    <td class='text-left px-6 py-3'><?php echo $phone_number; ?></td>
    <td class='text-left px-6 py-3'><?php echo $email; ?></td>
    <td class=''>
      <div class='flex flex-row items-center justify-end'>
        <a class='hover:cursor-pointer hover:text-red-700 font-semibold' href='/contacts/edit.php?id=<?php echo $id; ?>'>Edit</a>
        <span class='mx-2'>|</span>
        <a class='hover:cursor-pointer hover:text-red-700 font-semibold' href='/contacts/view.php?id=<?php echo $id; ?>'>View</a>
      </div>
    </td>
  </tr>
<?php
}
?>
        </tbody>
    </table>
    <p>
        <a href="/contacts/new.php" class="hover:cursor-pointer hover:text-red-700 font-semibold">Add Contact</a>
    </p>

</div>

<?php $database->close(); ?>
<?php include "../../components/footer.php"; ?>

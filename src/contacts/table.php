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
// check for database connection
if (!isset($database) || !$database) {
  $database = new SQLite3(__DIR__ . "/../../test.db");
}

error_log("Connected successfully");

// check for search query in request arguments
$search = $_GET["q"];
$page = $_GET["page"];

if (!$page) {
  $page = 0;
}

if ($search) {
  error_log("Searching for $search");
  // query the database for contacts matching the search query
  $statement = $database->prepare(
    "SELECT * FROM contacts WHERE first_name LIKE :search LIMIT 5 OFFSET :offset"
  );
  $statement->bindValue(":search", "%$search%");
  $statement->bindValue(":offset", $page * 5);
  $results = $statement->execute();
} else {
  // query the database for all contacts
  $statement = $database->prepare(
    "SELECT * FROM contacts LIMIT 5 OFFSET :offset"
  );
  $statement->bindValue(":offset", $page * 5);
  $results = $statement->execute();
}

$n_rows = 0;
while ($results->fetchArray(SQLITE3_ASSOC)) {
  $n_rows++;
}
$results->reset();

while ($contact = $results->fetchArray(SQLITE3_ASSOC)) {

  // display each contact
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
<?php if ($n_rows == 5) { ?> 
  <tr>
    <td colspan="5" style="text-align: center">
      <button class="bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-sm border-4 text-white py-1 px-2 rounded"
              hx-target="closest tr"
              hx-swap="outerHTML"
              hx-select="tbody > tr"
              hx-get="/contacts?page=<?php echo $page + 1; ?>">
        Load More
      </button>
    </td>
  </tr>
<?php } ?>
    </tbody>
</table>
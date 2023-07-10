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

    <?php include_once "./table.php"; ?>

    <p>
        <a href="/contacts/new.php" class="hover:cursor-pointer hover:text-red-700 font-semibold">Add Contact</a>
    </p>

</div>

<?php $database->close(); ?>
<?php include "../../components/footer.php"; ?>

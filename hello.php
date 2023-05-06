<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/htmx.org@1.9.2"></script>
</head>
<body class="bg-blue-50">

<div class="flex items-center justify-center h-screen">
<div class="w-1/2">
<form hx-post="/name.php" class="w-full">
  <div class="mb-6 w-full">
    <label for="name_input" class="block mb-2 text-sm font-medium text-gray-900 w-full">Your email</label>
    <input type="text" id="name_input" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 w-full" required>
    <div class="m-2"></div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full">Submit</button>
  </div>
</form>
</div>
</div>

</body>
</html>

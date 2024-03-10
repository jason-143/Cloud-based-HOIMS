<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Empty File Input</title>
</head>
<body>

<form id="myForm">
  <input type="file" id="fileInput" >
  <button type="submit">Submit</button>

  <label for="username">Username:</label>
<input type="text" id="username" name="username">
</form>

<script>
  document.getElementById('myForm').addEventListener('submit', function(event) {
    const fileInput = document.getElementById('fileInput');

    if (fileInput.files.length === 0) {
      alert('Please select a file before submitting the form.');
      event.preventDefault(); // Prevent form submission
    }
    // else, the form will be submitted as usual
  });
</script>

</body>
</html>
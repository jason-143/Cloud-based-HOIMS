<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    #drop-area {
      width: 300px;
      height: 200px;
      border: 2px dashed #ccc;
      text-align: center;
      padding: 10px;
      margin: 50px auto;
    }

    #file-input {
      display: none;
    }

    #drop-area.highlight {
      border-color: #007BFF;
    }

    #file-list {
      list-style-type: none;
      padding: 0;
    }

    .file-item {
      margin: 5px 0;
      padding: 5px;
      border: 1px solid #ddd;
      background-color: #f9f9f9;
    }
  </style>
  <title>Drag and Drop File</title>
</head>
<body>

<div id="drop-area" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
  <div>Drag &amp; Drop files here or click to select</div>
  <input type="file" id="file-input" multiple onchange="handleFiles(this.files)">
</div>

<ul id="file-list"></ul>

<script>
  function handleDragOver(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('drop-area').classList.add('highlight');
  }

  function handleDragLeave(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('drop-area').classList.remove('highlight');
  }

  function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('drop-area').classList.remove('highlight');

    const files = event.dataTransfer.files;
    handleFiles(files);
  }

  function handleFiles(files) {
    const fileList = document.getElementById('file-list');
    fileList.innerHTML = ''; // Clear previous file list

    for (const file of files) {
      const listItem = document.createElement('li');
      listItem.className = 'file-item';
      listItem.textContent = `File name: ${file.name}, Type: ${file.type}, Size: ${file.size} bytes`;
      fileList.appendChild(listItem);
    }
  }

  // Open file input when the drop area is clicked
  document.getElementById('drop-area').addEventListener('click', () => {
    document.getElementById('file-input').click();
  });
</script>

</body>
</html>

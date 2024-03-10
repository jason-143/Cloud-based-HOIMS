
  function validateNumber(input) {
    // Remove non-numeric characters using a regular expression
    input.value = input.value.replace(/[^0-9]/g, '');
  }

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
      
    // Manually update the file input value for dropped files
    const fileInput = document.getElementById('file-input');
    fileInput.files = files;
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


  //  check if the file is empty
  document.getElementById('document-form-file').addEventListener('submit', function (event) {
    const fileInput = document.getElementById('file-input');

    if (fileInput.files.length === 0) {
      alert('Please Upload a file before submitting.');
      event.preventDefault(); // Prevent form submission
    }
    // else, the form will be submitted as usual
  });


    function showLoading() {
        // Display the loading container
        document.getElementById('loadingContainer').style.display = 'block';
        // Optionally, you can use a timeout to ensure the loading message is visible for a certain duration
        setTimeout(function() {
            // Submit the form after displaying the loading message
            document.getElementById('document-form-file').submit();
        }, 500); // Adjust the duration (in milliseconds) as needed
        return true; // Prevent the form from submitting immediately
    }

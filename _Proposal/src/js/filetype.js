
document.getElementById('save-input').addEventListener('submit', function (event) {
    var fileInput = document.getElementById('file-input');

    // Check if a file is selected
    if (fileInput.files.length === 0) {
        alert('Please select a file.');
        event.preventDefault(); // Prevent form submission
        return;
    }

    var allowedFileTypes = ['pdf', 'doc', 'docx'];
    var fileName = fileInput.files[0].name;
    var fileType = fileName.split('.').pop().toLowerCase();

    // Check if the file type is allowed
    if (!allowedFileTypes.includes(fileType)) {
        alert('Invalid file type. Please upload only PDF, DOC, or DOCX files.');
        event.preventDefault(); // Prevent form submission
        // Clear the file input to allow the user to select a new file
        fileInput.value = '';
    }
});

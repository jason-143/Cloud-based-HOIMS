
function confirmDelete() {
    let userResponseMisc = confirm("Confirm: Do you want to delete the record?");
    if (userResponseMisc) {
        return true; // Allow form submission
    } else {
        // window.location.reload();
        return false; // Prevent form submission
    }
}

// function approvedDIV(event, action) {

//     event.preventDefault(); // Prevent default form submission

//     let container;

//     if (action === 'Approved') {
//         container = document.getElementById("approvedContainer");
//     } else if (action === 'Declined') {
//         container = document.getElementById("DisapprovedContainer");
//     }

//     if (container) {
//         container.style.display = "block";
//         setTimeout(function() {
//             container.style.display = "none";
//             // Now you can proceed with the actual form submission if needed
//             event.target.submit();
//         }, 2000);
//     }
// }

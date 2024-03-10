
function editAdminaccount() {

    let validateDiv = document.getElementById("validate-admin-idenity");
    let hideedit = document.getElementById("edit-button-id");

    if (validateDiv.style.display === "none") {
        validateDiv.style.display = "block";
        hideedit.style.display = "none";
    } else {
        validateDiv.style.display = "none";
        hideedit.style.display = "block";
        inputForm.setAttribute("disabled", true);
    }
}
function cancelupdateAdmin() {
    location.reload(true);
}

function addEmployee() {
    let canceladd = document.getElementById("cancel-add-employee");
    let add = document.getElementById("add-emplyee");
    let form = document.getElementById("add-employee-form-container");
    if (canceladd.style.display === "none") {
        add.style.display = "none";
        canceladd.style.display = "block";
        form.style.display = "block";
    }else{
        form.style.display = "none";
        add.style.display = "block";
        canceladd.style.display = "none";
    }

}
function cancelAdd() {
    location.reload(true);
}

function upperCaseF(a) {
    a.value = a.value.toUpperCase();
}
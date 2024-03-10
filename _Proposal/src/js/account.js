
function editaccount() {

    let save = document.getElementById("save-input");
    let cancel = document.getElementById("Cancel-button");
    let edit = document.getElementById("edit-button-id");

    let firstname = document.getElementById("input-firstname-hide");
    let lastname = document.getElementById("input-lastname-hide");
    let cell = document.getElementById("input-mobile-hide");
    let email = document.getElementById("input-email-hide");
    let bday = document.getElementById("input-bday-hide");
    let address = document.getElementById("input-address-hide");
    let gender = document.getElementById("input-un-hide");
    let pass = document.getElementById("input-password-hide");
    let occ = document.getElementById("input-occupation-hide");
    let school = document.getElementById("input-school-hide");
 
    let status = document.getElementById("input-status-hide");
    let dept = document.getElementById("input-department-hide");
    let type = document.getElementById("input-type-hide");

       if (save.style.display === "none") {
            edit.style.display = 'none';
           save.style.display = "block";
           cancel.style.display = "block";
          
           firstname.removeAttribute("disabled");
           lastname.removeAttribute("disabled");
           cell.removeAttribute("disabled");
           email.removeAttribute("disabled");
           bday.removeAttribute("disabled");
           address.removeAttribute("disabled");
           gender.removeAttribute("disabled");
           pass.removeAttribute("disabled");
           occ.removeAttribute("disabled");
           school.removeAttribute("disabled");
           status.removeAttribute("disabled");
           dept.removeAttribute("disabled");
           type.removeAttribute("disabled");
       } else {
           save.style.display = "none";
           cancel.style.display = "none";
           edit.style.display = "block";
           inputForm.setAttribute("disabled", true);
       }
   }
   function cancelupdate() {
    location.reload(true);
   }
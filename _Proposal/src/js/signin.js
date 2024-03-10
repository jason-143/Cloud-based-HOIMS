
function showpass2(anchors) {
    var b = document.getElementById("pass_show");

    var icon = anchors.querySelector("i");

    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');

    if (b.type === "password") {
        b.type = "text";
    } else {
        b.type = "password";
    }
}

function upperCaseF(a) {
    a.value = a.value.toUpperCase();
}
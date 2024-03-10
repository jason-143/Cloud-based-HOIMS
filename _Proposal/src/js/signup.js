function sp(anchor) {
    var a = document.getElementById("p1");
    var icon = anchor.querySelector("i");
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
    if (a.type === "password") {
        a.type = "text";
    } else {
        a.type = "password";
    }
}

function sp2(anchor) {
    var b = document.getElementById("p2");
    var icon = anchor.querySelector("i");
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
    if (b.type === "password") {
        b.type = "text";
    } else {
        b.type = "password";
    }
}

var verifyp = function() {
    if (document.getElementById('p1').value ==
        document.getElementById('p2').value) {
        document.getElementById('warn').style.color = 'green';
        document.getElementById('warn').innerHTML = 'Password match';
        return true;
    } else {
        document.getElementById('warn').style.color = 'red';
        document.getElementById('warn').innerHTML = 'Password did not match';
        return false;
    }
}

function upperCaseF(a) {
    a.value = a.value.toUpperCase();
}
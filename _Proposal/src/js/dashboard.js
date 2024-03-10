setTimeout(function() {
    location.reload();
}, 600 * 1000);


function otherDoc() {
    
    let container = document.getElementById("hidden-other-Document");

    if (container.style.display == "none") {
        container.style.display = "block"
    } else {
        container.style.display = "none"
    }

}

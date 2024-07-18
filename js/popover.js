let dialog = document.getElementById("popover");
let showButton = document.getElementsByClassName("open");
let closeButton = document.getElementsByClassName("close");

let showModal = function () {
    dialog.showModal();
    console.log("I'm working fine you're just an idiot");
}

for (var i = 0; i < showButton.length; i++) {
    showButton[i].addEventListener('click', showModal, false);
}

let closeModal = function () {
    dialog.close();
    console.log("I'm also working fine you're just an idiot twice");
}

for (var i = 0; i < closeButton.length; i++) {
    closeButton[i].addEventListener('click', closeModal, false);
}

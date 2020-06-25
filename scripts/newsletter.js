function addImage(thisParameter) {
    let image = thisParameter.firstChild;
    image.className += " mx-auto";
    const email = document.getElementById("allTheMail");
    email.appendChild(image);
    $('#uploadImage').modal('hide');
}

function addText() {

}

function uploadToNewsletter(event) {
    event.preventDefault()
    const request = new XMLHttpRequest();
    request.open("POST", "./functions/uploadImage.php", true);
    const file = event.target[1].files[0];

    if (file) {
        let myFormData = new FormData();
        myFormData.append("uploadImage", file);
        let title = document.getElementById("imageTitle").value;
        myFormData.append("imageTitle", title);
        request.send(myFormData);
    }

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (this && this.responseText && this.responseText === "success") {
                const reader = new FileReader();
                reader.onload = function () {
                    const email = document.getElementById("allTheMail");
                    const image = document.createElement("img");
                    image.src = reader.result;
                    image.width = 200;
                    image.height = 200;
                    image.className = "mx-auto ml-2 mr-2 mt-2 mb-2";
                    email.appendChild(image);
                    $('#uploadImage').modal('hide');
                }
                reader.readAsDataURL(file);
            } else {
                alert(this.responseText);
            }
        }
        return false;
    }
}
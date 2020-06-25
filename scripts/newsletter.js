function addImage(thisParameter) {
    let link = document.createElement("a");
    let image = thisParameter.firstChild;
    link.href = "#";
    link.className = image.className + " mx-auto";
    link.setAttribute("onclick", "deleteElement(this)");
    const email = document.getElementById("allTheMail");
    link.appendChild(image);
    email.appendChild(link);
    $('#uploadImage').modal('hide');
}

function addText() {
    let div = document.createElement("div");
    div.className = "mx-auto";
    div.name = "toDelete";
    let link = document.createElement("button");
    link.className = "btn btn-warning mx-auto mt-1 mb-1";
    link.innerText = "Supprimer la zone de texte";
    link.setAttribute("onclick", "deleteElement(this)");
    let text = document.createElement("textarea");
    text.name = "textarea"
    text.className = "w-75 mx-auto";
    const email = document.getElementById("allTheMail");
    div.appendChild(text);
    div.appendChild(link);
    email.appendChild(div);
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
                    const link = document.createElement("a");
                    link.href = "#";
                    link.setAttribute("onclick", "deleteElement(this)");
                    const image = document.createElement("img");
                    image.src = reader.result;
                    image.width = 200;
                    image.height = 200;
                    image.className = "mx-auto ml-2 mr-2 mt-2 mb-2";
                    link.className = image.className;
                    link.appendChild(image);
                    email.appendChild(link);
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

function deleteElement(thisParameter) {
    if (thisParameter.parentNode.name === "toDelete") {
        thisParameter.parentNode.remove();
    } else {
        thisParameter.remove();
    }
}

function saveNewsletter() {
    let title = document.getElementById("saveTitle");
    title = title.value;

    const textAreaElement = document.getElementsByName("textarea");
    for (let i = 0; i < textAreaElement.length; i++) {
        const p = document.createElement("p");
        p.innerText = textAreaElement[i].value;
        const parentNode = textAreaElement[i].parentNode;
        while (parentNode.firstChild) {
            parentNode.removeChild(parentNode.firstChild);
        }
        parentNode.appendChild(p);
    }
    const email = document.getElementById("allTheMail");
    const request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            if (request.responseText !== "") {
                alert(request.responseText);
            }
        }
    }
    request.open("POST", "./functions/saveEmail.php", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("html=" + encodeURIComponent(email.innerHTML) + "&title=" + title);
}

function changeSelect(thisParameter) {
    if (thisParameter[0].innerText === "Choisir une newsletter ...") {
        thisParameter.remove(thisParameter.firstChild);
    }
}

function enterEmail() {

    const div = document.getElementById("enterEmailAddress");

    deleteEnterEmail();

    const input = document.createElement("input");
    const small = document.createElement("small");
    input.placeholder = "Saisissez les adresses email";
    input.name = "allEmails";
    input.type = "text";
    input.className = "mt-2 form-control";
    input.setAttribute("required", "required");

    small.innerText = "Merci de saisir toutes les addresses mails séparées d'un point-virgule";
    small.className = "form-text text-muted mb-2";

    div.appendChild(input);
    div.appendChild(small);
}

function deleteEnterEmail() {
    const div = document.getElementById("enterEmailAddress");
    while (div.firstChild) {
        div.removeChild(div.firstChild);
    }
}

function sendToMe(email) {
    deleteEnterEmail();
    const div = document.getElementById("enterEmailAddress");
    const input = document.createElement("input");
    input.placeholder = "Saisissez les adresses email";
    input.name = "myEmail";
    input.type = "text";
    input.value = email;
    input.className = "mt-2 form-control";
    input.setAttribute("readonly", "true");
    div.appendChild(input);
}
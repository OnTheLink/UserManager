function getAdminPath() {
    const admin_slash = window.location.href.includes("admin/");
    const admin_no_slash = window.location.href.includes("admin");

    if (admin_slash) {
        return "../admin/";
    } else if (admin_no_slash) {
        return "./admin/";
    }

    return "";
}

function navigate(dest) {
    const adminPath = getAdminPath();

    switch (dest) {
        case "admin":
            window.location.href = "../admin";
            break;
        case "edit_admin":
            window.location.href = adminPath + "editAdmin";
            break;
        case "admin_cancel":
            window.location.href = adminPath + "?error=cancel";
            break;
        case "profile":
            window.location.href = "../profile";
            break;
        case "logout":
            window.location.href = adminPath + "../logout";
            break;
        case "new":
            window.location.href = adminPath + "new";
            break;
    }
}

function getDataFromForm(uid = null) {
    const fields = ['firstName', 'middleName', 'lastName', 'address', 'zip', 'phone', 'type'];
    if (uid === true) {
        fields.push('userID');
    }
    const dataObject = {};
    fields.forEach(field => {
        dataObject[field] = document.getElementById(field).value;
    });
    return dataObject;
}

function getAdminDataFromForm() {
    const fields = ['firstName', 'middleName', 'lastName', 'email', 'username', 'password', 'password2', 'adminID'];
    const dataObject = {};
    fields.forEach(field => {
        dataObject[field] = document.getElementById(field).value;
    });
    return dataObject;
}

function sendData(dataObject, url, successMessage, errorMessage) {
    const adminPath = getAdminPath();
    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(dataObject));

    xhr.onload = function() {
        if (xhr.responseText.includes("error")) {
            window.location.href = adminPath + "?error=" + errorMessage;
            return;
        }
        window.location.href = adminPath + "?success=" + successMessage;
    }
}

function createUser() {
    // Validate form using basic HTML5 validation
    const form = document.getElementById('newUserForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const adminPath = getAdminPath();
    const dataObject = getDataFromForm();
    sendData(dataObject, `${adminPath}new/saveNew`, "create", "create");
}

function save() {
    // Validate form using basic HTML5 validation
    const form = document.getElementById('saveUserForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const adminPath = getAdminPath();
    const dataObject = getDataFromForm(true);
    sendData(dataObject, `${adminPath}edit/save`, "edit", "edit");
}

function saveAdmin() {
    // Validate form using basic HTML5 validation
    const form = document.getElementById('saveAdminForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const adminPath = getAdminPath();
    const dataObject = getAdminDataFromForm();
    sendData(dataObject, `${adminPath}edit/saveAdmin`, "edit_admin", "edit_admin");
}

function edit(el) {
    const adminPath = getAdminPath();
    const id = el.parentElement.parentElement.querySelector('.userID').innerHTML;
    window.location.href = `${adminPath}edit?id=${id}`;
}

function remove(el) {
    const e = el.parentElement.parentElement;
    const id = e.querySelector('.userID').innerHTML;
    const firstName = e.querySelector('.firstName').innerHTML;
    const middleName = e.querySelector('.middleName').innerHTML;
    const lastName = e.querySelector('.lastName').innerHTML;
    const fullName = `${firstName} ${middleName} ${lastName}`;

    const placeholder_user = document.querySelector('.PLACEHOLDER-USER');
    const placeholder_id = document.querySelector('.PLACEHOLDER-ID');

    placeholder_user.innerHTML = fullName;
    placeholder_id.innerHTML = id;

    const terminatePopup = document.getElementById('terminatePopup');
    terminatePopup.style.display = "flex";
}
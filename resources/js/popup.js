// JavaScript to handle interaction with the evil popup
const terminatePopup = document.getElementById('terminatePopup');
terminatePopup.addEventListener('click', function (event) {
    if (event.target === terminatePopup) {
        terminatePopup.classList.add('shake');
        setTimeout(() => {
            terminatePopup.classList.remove('shake');
        }, 500);
    }
});

// Terminate logic
function terminate(el) {
    const e = el.parentElement.parentElement;
    const id = e.querySelector('.PLACEHOLDER-ID').innerHTML;
    const fullName = e.querySelector('.PLACEHOLDER-USER').innerHTML;
    const adminPath = getAdminPath();

    // Submit POST request to /admin/terminate/{id} and await response
    fetch(`${adminPath}terminate?id=${id}`, { method: 'POST' })
        .then(response => {
            if (response.status === 200) {
                // Remove the user from the table
                const userIDElements = document.querySelectorAll('.userID');
                userIDElements.forEach(userID => {
                    if (userID.innerHTML === id) {
                        userID.parentElement.remove();
                    }
                });

                // Hide the popup
                hideTerminatePopup();

                // Show the success message
                showMessage("success", `${fullName} has been terminated.`);
            } else {
                // Hide the popup
                hideTerminatePopup();

                // Show the error message
                showMessage("error", `An error occurred while trying to terminate ${fullName}.<br>Error code: ${response.status}`);
            }
        })
        .catch(error => {
            // Hide the popup
            hideTerminatePopup();

            // Show the error message
            showMessage("error", `An error occurred: ${error.message}`);
        });
}

// Cancel logic
function cancel() {
    // Hide the popup
    hideTerminatePopup();

    // Show the error message
    showMessage("error", "Termination cancelled by user.");
}

// hide popups
function hideTerminatePopup() {
    const terminatePopup = document.getElementById('terminatePopup');
    terminatePopup.style.display = "none";
}

// Message logic
function showMessage(type, message) {
    const messageContainer = document.getElementById(type + 'Message');
    const placeholder = messageContainer.querySelector('.placeholder-message');

    placeholder.innerHTML = message;
    messageContainer.style.display = 'block';
    messageContainer.style.top = '25px'; // Slide down

    setTimeout(() => {
        hideMessage(messageContainer);
    }, 3000); // Auto-hide after 3 seconds (adjust as needed)
}

function hideMessage(messageContainer) {
    messageContainer.style.top = '-75px'; // Slide up to hide
}
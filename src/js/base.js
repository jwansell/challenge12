function showError(message) {
    handleToast('errorMessage', message);
}

function handleToast(name, text) {
    const element = document.getElementById(name);
    element.style.display = 'none';
    element.innerText = text;
    element.style.display = 'inline-block';
    setTimeout(() => {
        element.style.display = 'none'
    }, 10000);
}

function showSuccess(message) {
    if (message == null) {
        message = 'Action completed';
    }
    handleToast('successMessage', message);
}
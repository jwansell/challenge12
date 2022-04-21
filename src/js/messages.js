function fetchMessages() {
    const container = document.getElementById('messages-container');
    container.innerHTML = '<div class="loading">Loading... </div>';
    fetch('/api/messages')
        .then(async response => {
            var body = await response.json();
            if (response.status == 200) {
                var string = '';
                body.data.forEach(message => {
                    string += createHtmlForMessage(message);
                });
                container.innerHTML = string;
            } else {
                showError(body.messages);
            }
        });
}

function createHtmlForMessage(message) {
    return `<div class="messages-container-item flex column">
        <div class="message-created">Created at: ${message.created_at}</div>
        <div class="message-item">Name: ${message.name}</div>
        <div class="message-item">Email: ${message.email}</div>
        <div class="message-item">Message: ${message.message}</div>
    </div>`;
}

fetchMessages();

document.getElementById('reload').addEventListener('click', fetchMessages);
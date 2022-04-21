function submitMessage() {
    var data = new FormData();
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var message = document.getElementById('message').value;

    data.append('name', name);
    data.append('message', message);
    data.append('email', email);

    fetch('/api/contact', {
        method: 'post',
        body: data
    })
        .then(async response => {
            var body = await response.json();
            if (response.status == 200) {
                window.location.reload();
            } else {
                showError(body.messages)
            }
        });
}


document.getElementById('submit')
    .addEventListener('click', submitMessage);
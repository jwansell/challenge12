function submitLogin() {
    var data = new FormData();
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    data.append('username', username);
    data.append('password', password);

    fetch('/api/login', {
        method: 'post',
        body: data,
    })
        .then(async response => {
            var body = await response.json();
            if (response.status == 200) {
                window.location.reload();
            } else {
                showError(body.messages);
            }
        });
}


document.getElementById('login')
    .addEventListener('click', submitLogin);
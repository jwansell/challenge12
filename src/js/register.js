function submitRegistration() {
    var data = new FormData();
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirm = document.getElementById('confirm').value;

    data.append('username', username);
    data.append('password', password);
    data.append('confirm', confirm);
    data.append('email', email);

    fetch('/api/register', {
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


document.getElementById('register')
    .addEventListener('click', submitRegistration);
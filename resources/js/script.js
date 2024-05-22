loginForm.addEventListener('submit', function (e) {
    e.preventDefault();
    fetch(loginForm.action, {
        method: 'POST',
        body: JSON.stringify({
            email: new FormData(loginForm).get('email'),
            password: new FormData(loginForm).get('password'),
        }),
        credentials: 'same-origin'
    })
        .then(response => response.json())
        .then(response => {
            console.log(response);
        });
});
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault()
    
    const username = document.getElementById('username').value
    const password = document.getElementById('password').value

    if (username === 'admin' && password === '12345') {
        alert("Login exitoso")
        window.location.href = 'gestion.php'
    } else {
        alert("Usuario o contraseña incorrectos")
    }
})

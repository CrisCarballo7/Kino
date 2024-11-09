document.getElementById('confirmar-compra').addEventListener('click', function() {
    alert("Compra confirmada. ¡Gracias por tu reserva!")
    window.location.href = 'inicio.html'
})

document.getElementById('titulo-pelicula').innerText = "The Batman"
document.getElementById('asientos-seleccionados').innerText = "A1, A3, B2"
document.getElementById('total-reserva').innerText = "10500"

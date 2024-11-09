document.getElementById('formAgregar').addEventListener('submit', function(event) {
    event.preventDefault()

    const titulo = document.getElementById('titulo').value
    const descripcion = document.getElementById('descripcion').value
    const imagen = document.getElementById('imagen').value
    const duracion = document.getElementById('duracion').value
    const clasificacion = document.getElementById('clasificacion').value
    const precio = document.getElementById('precio').value
    const horarios = document.getElementById('horarios').value
    const sala = document.getElementById('sala').value

    const peliculaItem = document.createElement('div')
    peliculaItem.classList.add('pelicula-item', 'clearfix')
    peliculaItem.innerHTML = `
        <img src="${imagen}" alt="${titulo}">
        <h3>${titulo}</h3>
        <p>Duración: ${duracion} min</p>
        <p>Clasificación: ${clasificacion}</p>
        <p>${descripcion}</p>
        <p>Precio: ₡${precio}</p>
        <p>Horarios: ${horarios}</p>
        <p>Sala: ${sala}</p>
        <button type="button" onclick="eliminarPelicula(this)">Eliminar</button>
    `

    document.getElementById('lista-peliculas').appendChild(peliculaItem)
    document.getElementById('formAgregar').reset()
})

function eliminarPelicula(button) {
    button.parentElement.remove()
}

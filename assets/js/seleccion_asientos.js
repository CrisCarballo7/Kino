document.querySelectorAll('.asiento').forEach(asiento => {
    asiento.addEventListener('click', function() {
        if (!this.classList.contains('ocupado')) {
            this.classList.toggle('seleccionado');
        }
    });
});

document.getElementById('continuar').addEventListener('click', function() {
    const seleccionados = document.querySelectorAll('.asiento.seleccionado');
    let mensaje = 'Has seleccionado los siguientes asientos:\n';
    seleccionados.forEach(asiento => {
        mensaje += `Fila: ${asiento.dataset.fila}, Número: ${asiento.dataset.numero}\n`;
    });
    alert(mensaje);
});

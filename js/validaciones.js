// Validaciones del lado del cliente para los formularios de la agencia

// Fecha de hoy en formato AAAA-MM-DD
function hoy() {
    const d = new Date();
    d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
    return d.toISOString().slice(0, 10);
}

function esEnteroPositivo(valor) {
    return /^[1-9][0-9]*$/.test(valor.trim());
}

function esDecimalPositivo(valor) {
    const n = Number(valor);
    return valor.trim() !== '' && !isNaN(n) && n > 0;
}

// Muestra la lista de errores; devuelve true si no hay ninguno
function mostrarErrores(errores) {
    const caja = document.getElementById('errores');
    if (errores.length === 0) {
        caja.style.display = 'none';
        return true;
    }
    caja.innerHTML = '<ul><li>' + errores.join('</li><li>') + '</li></ul>';
    caja.style.display = 'block';
    return false;
}

function validarVuelo(f) {
    const errores = [];
    const origen = f.origen.value.trim();
    const destino = f.destino.value.trim();

    if (origen === '' || destino === '') {
        errores.push('El origen y el destino son obligatorios.');
    } else if (origen.toLowerCase() === destino.toLowerCase()) {
        errores.push('El origen y el destino no pueden ser iguales.');
    }
    if (f.fecha.value === '') {
        errores.push('Seleccione la fecha del vuelo.');
    } else if (f.fecha.value < hoy()) {
        errores.push('La fecha del vuelo no puede ser anterior a hoy.');
    }
    if (!esEnteroPositivo(f.plazas_disponibles.value)) {
        errores.push('Las plazas disponibles deben ser un número entero mayor a 0.');
    }
    if (!esDecimalPositivo(f.precio.value)) {
        errores.push('El precio debe ser un número mayor a 0.');
    }
    return mostrarErrores(errores);
}

function validarHotel(f) {
    const errores = [];

    if (f.nombre.value.trim().length < 3) {
        errores.push('El nombre del hotel debe tener al menos 3 caracteres.');
    }
    if (f.ubicacion.value.trim() === '') {
        errores.push('La ubicación es obligatoria.');
    }
    if (!esEnteroPositivo(f.habitaciones_disponibles.value)) {
        errores.push('Las habitaciones disponibles deben ser un número entero mayor a 0.');
    }
    if (!esDecimalPositivo(f.tarifa_noche.value)) {
        errores.push('La tarifa por noche debe ser un número mayor a 0.');
    }
    return mostrarErrores(errores);
}

function validarReserva(f) {
    const errores = [];

    if (!esEnteroPositivo(f.id_cliente.value)) {
        errores.push('El ID de cliente debe ser un número entero mayor a 0.');
    }
    if (f.fecha_reserva.value === '') {
        errores.push('Seleccione la fecha de la reserva.');
    }
    if (f.id_vuelo.value === '') {
        errores.push('Seleccione un vuelo.');
    }
    if (f.id_hotel.value === '') {
        errores.push('Seleccione un hotel.');
    }
    return mostrarErrores(errores);
}

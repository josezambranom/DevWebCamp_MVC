(function () {
    const horas = document.querySelector('#horas');
    if(horas) {
        const categoria = document.querySelector('[name="categoria_id"]');
        const dias = document.querySelectorAll('[name="dia"]');
        const inputHiddenDia = document.querySelector('[name="dia_id"]');
        const inputHiddenHora = document.querySelector('[name="hora_id"]');

        categoria.addEventListener('change', terminoBusqueda);
        dias.forEach(dia => dia.addEventListener('change', terminoBusqueda));

        let busqueda = {
            // El '+' le indica que ese string debe ser int
            categoria_id: +categoria.value ?? '', 
            dia: +inputHiddenDia.value ?? ''
        }

        if(!Object.values(busqueda).includes('')){
            (async() => {
                await buscarEventos();
                // Resaltar la hora actual
                const id = inputHiddenHora.value;
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);
                horaSeleccionada.classList.remove('horas__hora--deshabilitada');
                horaSeleccionada.classList.add('horas__hora--seleccionada');
                horaSeleccionada.onclick = seleccionarHora;
            })();
        }

        function terminoBusqueda(ev) {
            busqueda[ev.target.name] = ev.target.value;
            
            // Reiniciar los campos ocultos y el selecctor de hora
            inputHiddenHora.value = '';
            inputHiddenDia.value = '';
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }

            if(Object.values(busqueda).includes('')) return;            
            buscarEventos();
        }

        async function buscarEventos() {
            const url = `/api/eventos-horario?dia_id=${busqueda.dia}&categoria_id=${busqueda.categoria_id}`;
            try {
                const resultado = await fetch(url);
                const eventos = await resultado.json();
                obtenerHorasDisponibles(eventos);

            } catch (error) {
                console.log(error);
            }
        }

        function obtenerHorasDisponibles(eventos) {
            // Reiniciar las horas
            const listadoHoras = document.querySelectorAll('#horas li');
            listadoHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'));
            
            // Comprobar horas disponibles y quitar la variable deshabilitado
            const horasTomadas = eventos.map(evento => evento.hora_id);

            const listadoHorasArray = Array.from(listadoHoras);

            const resultado = listadoHorasArray.filter(li => !horasTomadas.includes(li.dataset.horaId));
            resultado.forEach(li => li.classList.remove('horas__hora--deshabilitada'));

            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
            horasDisponibles.forEach(hora => hora.addEventListener('click', seleccionarHora));
        }

        function seleccionarHora(ev) {
            // Deshabilitar la hora previa si hay un nuevo click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }

            // Agregar clase de seleccionado
            ev.target.classList.add('horas__hora--seleccionada');
            inputHiddenHora.value = ev.target.dataset.horaId;

            // Llenar el campo oculto de día
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        }

    }
})();
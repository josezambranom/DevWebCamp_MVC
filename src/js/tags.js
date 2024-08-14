(function(){
    const tagsInput = document.querySelector('#tags_input');

    if(tagsInput) {
        const tagsDiv = document.querySelector('#tags');
        const tagsInputHidden = document.querySelector('[name="tags"]');

        let tags = [];

        //Recuperar del input oculto
        if(tagsInputHidden.value !== '') {
            tags = tagsInputHidden.value.split(',');
            mostrarTags();
        }

        // Escuchar los cambios del input
        tagsInput.addEventListener('keypress', guardarTab);

        function guardarTab(ev) {
            if(ev.keyCode === 44) {
                if(ev.target.value.trim() === '' || ev.target.value < 1) return;
                ev.preventDefault();
                tags = [...tags, ev.target.value.trim()];
                tagsInput.value = '';
                mostrarTags();
            }
        }

        function mostrarTags() {
            tagsDiv.textContent = '';
            tags.forEach(tag => {
                const etiqueta = document.createElement('LI');
                etiqueta.classList.add('formulario__tag');
                etiqueta.textContent = tag;
                etiqueta.ondblclick = eliminarTag;
                tagsDiv.appendChild(etiqueta);
            });
            actualizarInputHidden();
        }

        function eliminarTag(ev) {
            ev.target.remove();
            tags = tags.filter(tag => tag !== ev.target.textContent);
            actualizarInputHidden();
        }

        function actualizarInputHidden() {
            tagsInputHidden.value = tags.toString();
        }
    }

})();
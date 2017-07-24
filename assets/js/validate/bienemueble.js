//Reglas de validacion para bienes muebles
var reglas = {
  rules: {
    "autocomplete1": {
        required: true,
        checkautocomplete: 'dato_comun'
    },
    "autocomplete3": {
        required: true,
        checkautocomplete: 'oficina'
    },
    "autocomplete4": {
        required: true,
        checkautocomplete: 'empleado'
    },
  },
  messages: { },
};

$(document).ready(function() {

    $.autocomplete({
        elemet: $('input[name=autocomplete1]'),
        url: 'index.php/ActivoFijo/Bienes_Inmuebles/AutocompleteDatosComunes',
        name: 'dato_comun',
        siguiente: 'codigo_anterior',
        content: 'suggestions1'
    });

    $.autocomplete({
        elemet: $('input[name=autocomplete3]'),
        url: 'index.php/ActivoFijo/Bienes_muebles/AutocompleteOficina',
        name: 'oficina',
        siguiente: 'autocomplete4',
        content: 'suggestions3'
    });

    $.autocomplete({
        elemet: $('input[name=autocomplete4]'),
        url: 'index.php/ActivoFijo/Bienes_muebles/AutocompleteEmpleado',
        name: 'empleado',
        siguiente: 'autocomplete1',
        content: 'suggestions4'
    });

});

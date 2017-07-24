//Reglas de validacion de detalle monto
var reglas = {
  rules: {
    "autocomplete3": {
        checkautocomplete: 'hdd'
    },
    "autocomplete4": {
        checkautocomplete: 'memoria'
    },
    "autocomplete5": {
        checkautocomplete: 'so'
    },
    "autocomplete6": {
        checkautocomplete: 'office'
    },
    "autocomplete2": {
        checkautocomplete: 'procesador'
    },
    "v_hdd": {
        required: true
    },
    "v_procesador": {
        required: true
    },
    "v_memoria": {
        required: true
    },
    "clave_so": {
        required: true
    },
    "clave_office": {
        required: true
    },
    "ip": {
        required: true
    },
    "punto": {
        required: true
    },
  },
  messages: {
    "v_hdd": {
      required: "Campo obligatorio."
    },
    "v_procesador": {
      required: "Campo obligatorio."
    },
    "v_memoria": {
      required: "Campo obligatorio."
    },
    "clave_so": {
      required: "Campo obligatorio."
    },
    "clave_office": {
      required: "Campo obligatorio."
    },
    "ip": {
      required: "Campo obligatorio."
    },
    "punto": {
      required: "Campo obligatorio."
    },
  },
};

$(document).ready(function() {
  $.autocomplete({
    elemet: $('input[name=autocomplete3]'),
    url: 'index.php/ActivoFijo/Equipo_informatico/AutocompleteDiscoDuro',
    name: 'hdd',
    siguiente: 'v_hdd',
    content: 'suggestions3'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/ActivoFijo/Equipo_informatico/AutocompleteProcesador',
    name: 'procesador',
    siguiente: 'v_procesador',
    content: 'suggestions2'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete4]'),
    url: 'index.php/ActivoFijo/Equipo_informatico/AutocompleteMemoria',
    name: 'memoria',
    siguiente: 'v_memoria',
    content: 'suggestions4'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete5]'),
    url: 'index.php/ActivoFijo/Equipo_informatico/AutocompleteSistemaOperativo',
    name: 'so',
    siguiente: 'clave_so',
    content: 'suggestions5'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete6]'),
    url: 'index.php/ActivoFijo/Equipo_informatico/AutocompleteOffice',
    name: 'office',
    siguiente: 'clave_office',
    content: 'suggestions6'
  });

});

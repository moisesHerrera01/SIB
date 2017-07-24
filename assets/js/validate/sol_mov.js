//Reglas de validacion de movimiento
var reglas = {
  rules: {
    "autocomplete3": {
        checkautocomplete: 'oficina_entrega'
    },
    "autocomplete": {
        checkautocomplete: 'oficina_recibe'
    },
    "autocomplete4": {
        checkautocomplete: 'empleado'
    },
    "autocomplete5": {
        checkautocomplete: 'tipo_movimiento'
    },
    "usuario_externo": {
        lettersonly: true,
    },
    "entregado_por": {
        lettersonly: true,
    },
    "recibido_por": {
        lettersonly: true,
    },
    "autorizado_por": {
        lettersonly: true,
    },
    "visto_bueno_por": {
        lettersonly: true,
    },
  },
  messages: {
    "usuario_externo": {
      lettersonly: "Ingrese un nombre valido.",
    },
    "entregado_por": {
      lettersonly: "Ingrese un nombre valido.",
    },
    "recibido_por": {
      lettersonly: "Ingrese un nombre valido.",
    },
    "autorizado_por": {
      lettersonly: "Ingrese un nombre valido.",
    },
    "visto_bueno_por": {
        lettersonly: "Ingrese un nombre valido.",
    },
  },
};

$(document).ready(function () {

  $.autocomplete({
    elemet: $('input[name=autocomplete3]'),
    url: 'index.php/ActivoFijo/Bienes_muebles/AutocompleteOficina',
    name: 'oficina_entrega',
    siguiente: 'autocomplete3',
    content: 'suggestions1'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/ActivoFijo/Bienes_muebles/AutocompleteOficina',
    name: 'oficina_recibe',
    siguiente: 'autocomplete4',
    content: 'suggestions2'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete4]'),
    url: 'index.php/ActivoFijo/Bienes_muebles/AutocompleteEmpleado',
    name: 'empleado',
    siguiente: 'autocomplete5',
    content: 'suggestions3'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete5]'),
    url: 'index.php/ActivoFijo/Movimiento/AutocompleteTipo_movimiento',
    name: 'tipo_movimiento',
    siguiente: 'autocomplete5',
    content: 'suggestions4',
  });

});

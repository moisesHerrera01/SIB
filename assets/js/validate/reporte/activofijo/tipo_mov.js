
var reglas = {
  rules: {
    "fecha_inicio": {
      required: true,
    },
    "fecha_fin": {
      required: true,
      comparedate: 'fecha_inicio'
    },
    "autocomplete": {
      checkautocomplete: 'tipo'
    }
  },
  messages: {
    "fecha_inicio": {
      required: "La fecha inicial es obligatoria.",
    },
    "fecha_fin": {
      required: "La fecha final es obligatoria.",
    }
  },
};

$(document).ready(function() {
  //producto
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/ActivoFijo/Movimiento/AutocompleteTipo_movimiento',
    name: 'tipo',
    siguiente: 'fecha_inicio',
    content: 'suggestions'
  });

});

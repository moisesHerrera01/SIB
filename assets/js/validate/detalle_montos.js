//Reglas de validacion de detalle monto
var reglas = {
  rules: {
    "autocomplete1": {
        checkautocomplete: 'linea'
    },
    "precio": {
        min:0
    },
  },
  messages: {
    "monto": {
      min: "El monto debe ser positivo."
    },
  },
};

$(document).ready(function() {
  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/Compras/Solicitud_Disponibilidad/AutocompleteLineaTrabajo',
    name: 'linea',
    siguiente: 'monto',
    content: 'suggestions1'
  });

});

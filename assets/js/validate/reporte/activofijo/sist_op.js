
var reglas = {
  rules: {
    "fechaMin": {
      required: true,
    },
    "fechaMax": {
      required: true,
      comparedate: 'fechaMin'
    },
    "autocomplete": {
      checkautocomplete: 'version'
    }
  },
  messages: {
    "fechaMin": {
      required: "La fecha inicial es obligatoria.",
    },
    "fechaMax": {
      required: "La fecha final es obligatoria.",
    }
  },
};

$(document).ready(function() {
  //producto
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/ActivoFijo/Sistema_operativo/Autocomplete',
    name: 'version',
    siguiente: 'fechaMin',
    content: 'suggestions'
  });

});

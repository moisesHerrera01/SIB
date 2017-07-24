
var reglas = {
  rules: {
    "fechaMin": {
      required: true,
    },
    "fechaMax": {
      required: true,
      comparedate: 'fechaMin'
    },
    "autocomplete6": {
      checkautocomplete: 'office'
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
    elemet: $('input[name=autocomplete6]'),
    url: 'index.php/ActivoFijo/Equipo_informatico/AutocompleteOffice',
    name: 'office',
    siguiente: 'fechaMin',
    content: 'suggestions6'
  });

});

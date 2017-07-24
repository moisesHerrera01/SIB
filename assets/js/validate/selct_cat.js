//Reglas de validacion para seleccionar categoria
var reglas = {
  rules: {
    "autocomplete": {
        required: true,
        checkautocomplete: 'categoria'
    }
  },
  messages: {
    "autocomplete": {
      required: "La categoria es obligatoria.",
    }
  },
};

$(document).ready(function() {
  //categoria
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/ActivoFijo/Categoria/Autocomplete',
    name: 'categoria',
    siguiente: 'guardar',
    content: 'suggestions'
  });
});

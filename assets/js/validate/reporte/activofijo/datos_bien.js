
var reglas = {
  rules: {
    "autocomplete": {
        required: true,
        checkautocomplete: 'bien'
    },
  },
  messages: {
    "autocomplete": {
      required: "El bien es obligatorio."
    },
  },
};

$(document).ready(function() {
  //categoria
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/ActivoFijo/Reportes/Datos_del_bien/AutocompleteBien',
    name: 'bien',
    siguiente: 'button',
    content: 'suggestions',
  });
});

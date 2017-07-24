//Reglas de validacion para almacen
var reglas = {
  rules: {
    "autocomplete1": {
        checkautocomplete: 'almacen'
    },
    "autocomplete2": {
        checkautocomplete: 'seccion'
    },
  },
  messages: { },
};

$(document).ready(function() {

  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/ActivoFijo/Almacenes/AutocompleteAlmacen',
    name: 'almacen',
    siguiente: 'seccion',
    content: 'suggestions1'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/ActivoFijo/almacenes/AutocompleteSeccion',
    name: 'seccion',
    siguiente: 'button',
    content: 'suggestions2'
  });

});

//Reglas de validacion de solicitud bodega
var reglas = {
  rules: {
    "autocomplete3": {
        checkautocomplete: 'seccion'
    },
    "autocomplete2": {
        checkautocomplete: 'fuente'
    },
  },
};

$(document).ready(function() {
  //unidad
  $.autocomplete({
    elemet: $('input[name=autocomplete3]'),
    url: 'index.php/ActivoFijo/almacenes/AutocompleteSeccion',
    name: 'seccion',
    siguiente: 'solicitante',
    content: 'suggestions3'
  });

  //fuente
  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/Bodega/Fuentefondos/Autocomplete',
    name: 'fuente',
    siguiente: 'comentario',
    content: 'suggestions2'
  });
});

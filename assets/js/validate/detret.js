var porpagina = 0;
//Reglas de validacion de solicitud + retiro
var reglas = {
  rules: {
    "autocomplete1": {
        checkautocomplete: 'producto'
    },
    "cantidad": {
        required: true,
        min:0
    }
  },
  messages: {
    "cantidad": {
      required: "La cantidad es obligatoria.",
      min: "La cantidad no debe ser negativa."
    }
  },
};

$(document).ready(function() {
  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/Bodega/Productos/AutocompleteExistencia',
    name: 'producto',
    siguiente: 'cantidad',
    content: 'suggestions1',
    ajaxdata: {fuente: $('input[name=fuente]').val(), porpagina: 20}
  });

});

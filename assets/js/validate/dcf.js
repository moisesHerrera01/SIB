//Reglas de validacion de detalle del conteo fisico
var reglas = {
  rules: {
    "autocomplete":{
        checkautocomplete: 'producto'
    },
    "cantidad": {
        required: true,
        min: 0
    },
    "autocomplete2":{
        checkautocomplete: 'especifico'
    }
  },
  messages: {
    "cantidad": {
      required: "La cantidad es obligatoria.",
      min: "La cantidad no debe ser negativa.",
    }
  },
};

$(document).ready(function() {
  //producto
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/Bodega/Productos/Autocomplete',
    name: 'producto',
    siguiente: 'cantidad',
    content: 'suggestions'
  });

  //especifico
  $.autocomplete({
    elemet: $('input[name=autocomplete3]'),
    url: 'index.php/Bodega/Especificos/AutocompletePorProducto/',
    name: 'especifico',
    siguiente: 'button',
    content: 'suggestions2'
  });
});

//Reglas de validacion de detalle factura
var reglas = {
  rules: {
    "autocomplete": {
      checkautocomplete: 'producto'
    },
    "cantidad": {
        required: true,
        min:0
    },
    "precio": {
      required: true,
      min:0
    }
  },
  messages: {
    "cantidad": {
      required: "La cantidad es obligatoria.",
      min:"Cantidad no puede ser negativa."
    },
    "precio": {
      required: "El precio es obligatorio.",
      min:"Precio no puede ser negativo."
    }
  },
};

$(document).ready(function() {
  //producto
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/Bodega/Detallefactura/AutocompleteEspecificoProducto',
    name: 'producto',
    siguiente: 'cantidad',
    content: 'suggestions'
  });
});

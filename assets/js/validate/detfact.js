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
    url: $('input[name=autocomplete]').attr('uri'),
    name: 'producto',
    asociacion1: 'cantidad',
    siguiente: 'cantidad',
    content: 'suggestions'
  });

});

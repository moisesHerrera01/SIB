//Reglas de validacion de detalle disponibilidad
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
        min:0
    },
  },
  messages: {
    "cantidad": {
      min: "La cantidad no debe ser negativa."
    },
    "precio": {
      min: "El precio no debe ser negativo."
    },
  },
};

$(document).ready(function() {
  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/Compras/Detalle_orden_resumen/AutocompleteDetalleOrdenResumen/'+$('input[name=orden]').val(),
    name: 'producto',
    siguiente: 'cantidad',
    content: 'suggestions1',
    asociacion: ['cantidad', 'especificaciones']
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/Compras/Detalle_Solicitud_Compra/AutocompleteEspecificoProductoCompras',
    name: 'producto',
    siguiente: 'cantidad',
    content: 'suggestions1'
  });

});

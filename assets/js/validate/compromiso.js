// Reglas de validacion de aprobar solicitud compras
var reglas = {
  rules: {
    "numero": {
      required: true,
      number: true
    },
    "autocomplete2":{
      checkautocomplete: 'fuentes'
    },
    "autocomplete4":{
      checkautocomplete: 'orden_compra'
    }
  },
  messages: {
    "numero": {
      required: "El numero de compromiso es obligatorio.",
      number: "Solo numeros."
    }
  },
};

$(document).ready(function() {
  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/Bodega/Fuentefondos/Autocomplete',
    name: 'fuentes',
    siguiente: 'button',
    content: 'suggestions2'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete4]'),
    url: 'index.php/Compras/Orden_Compra/AutocompleteOrdenCompra',
    name: 'orden_compra',
    siguiente: 'concepto',
    content: 'suggestions4'
  });

});

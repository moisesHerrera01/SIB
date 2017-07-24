//Reglas de validacion de detalle producto
var reglas = {
  rules: {
    "id_especifico": {
        required: true
    },
    "autocomplete": {
        checkautocomplete: 'id_producto'
    },
  },
  messages: {
    "id_especifico": {
      required: "El número de especifico es obligatorio."
    }
  },
};

$(document).ready(function() {
  //producto
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/Bodega/Productos/Autocomplete',
    name: 'id_producto',
    siguiente: 'guardar',
    content: 'suggestions'
  });
});

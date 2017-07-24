//Reglas de validacion de oficina
var reglas = {
  rules: {
    "autocomplete": {
        checkautocomplete: 'seccion_almacen'
    },
    "nombre": {
        required: true,
    },
  },
  messages: {
    "nombre": {
      required: "El nombre es obligatorio.",
    },
  },
};

$(document).ready(function() {
  //categoria
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/ActivoFijo/Oficinas/Autocomplete',
    name: 'seccion_almacen',
    siguiente: 'nombre',
    content: 'suggestions'
  });
});
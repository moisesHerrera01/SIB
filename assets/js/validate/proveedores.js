//Reglas de validacion de proveedores
var reglas = {
  rules: {
    "autocomplete": {
        checkautocomplete: 'categoria'
    },
    "nombreProveedor": {
      required: true,
    },
    "nit": {
      required: true,
    },
  },
  messages: {
    "nombreProveedor": {
      required: "El nombre es obligatorio.",
    },
    "nit": {
      required: "El NIT es obligatorio.",
    },
  },
};

$(document).ready(function() {
  //categoria
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/Bodega/Categoria_proveedor/Autocomplete',
    name: 'categoria',
    siguiente: 'nombreProveedor',
    content: 'suggestions'
  });
});

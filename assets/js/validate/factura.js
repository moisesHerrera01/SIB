//Reglas de validacion de factura
var reglas = {
  rules: {
    "numeroFactura": {
        required: true
    },
    "autocomplete": {
        required: true,
        checkautocomplete: 'proveedor'
    },
    "autocomplete1": {
        required: true,
        checkautocomplete: 'fuente'
    },
    "autocomplete2": {
        required: true,
        checkautocomplete: 'seccion'
    },
    "nombreEntrega": {
      required: true,
      lettersonly: true,
    },
    "fechaFactura": {
      required: true,
      minordate: true
    },
  },
  messages: {
    "numeroFactura": {
      required: "El número de la factura es obligatorio."
    },
    "autocomplete": {
      required: "Debe seleccionar un elemento"
    },
    "autocomplete1": {
      required: "Debe seleccionar un elemento"
    },
    "autocomplete2": {
      required: "Debe seleccionar un elemento"
    },
    "nombreEntrega": {
      required: "El nombre entrega es obligatorio.",
      lettersonly: "El nombre entrega solo ocupa letras",
    },
    "fechaFactura": {
      required: "La fecha de la factura es obligatoria.",
    },
  },
};

$(document).ready(function() {
  //Proveedores
  $.autocomplete({
    elemet: $('input[name=autocomplete]'),
    url: 'index.php/Bodega/Proveedores/Autocomplete',
    name: 'proveedor',
    siguiente: 'nombreEntrega',
    content: 'suggestions1'
  });
  //Fuentes de fondo
  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/Bodega/Fuentefondos/Autocomplete',
    name: 'proveedor',
    siguiente: 'Button',
    content: 'suggestions2'
  });
//Fuentes de fondo
  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/Bodega/Solicitud/Autocomplete',
    name: 'seccion',
    siguiente: 'Button',
    content: 'suggestions3'
  });

});

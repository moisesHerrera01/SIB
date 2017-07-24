//Reglas de validacion de orden de compra
var reglas = {
  rules: {
    "numero": {
      required: true,
      number: true
    },
    "autocomplete1": {
        checkautocomplete: 'proveedor'
    },
    "autocomplete2": {
        checkautocomplete: 'producto'
    },
    "fecha": {
        required: true,
        minordate: true
    },
    "monto_total_oc": {
        required: true,
        min:0

    },
    "tipo": {
      checkselect: true
    }
  },
  messages: {
    "numero": {
      required: "El numero es obligatorio.",
      number: "La solicitud tiene que ser un numero."
    },
    "fecha": {
      required: "La fecha es obligatoria."
    },
    "monto_total_oc": {
      min: "El monto total de la OC es obligatorio.",
      required: "El monto es obligatorio."
    },
  },
};

$(document).ready(function() {
  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/Bodega/Proveedores/Autocomplete',
    name: 'proveedor',
    siguiente: 'autocomplete2',
    content: 'suggestions1'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/Compras/Solicitud_Disponibilidad/AutocompleteDisponibilidad',
    name: 'det_disponibilidad',
    siguiente: 'fecha',
    content: 'suggestions2',
    asociacion: ['sol_compra']
  });

});

// Reglas de validacion de bienes inmuebles
var reglas = {
  rules: {
    "extension": {
        min: 0,
    },
    "precio": {
        min: 0,
    },
    "tipo_inmueble": {
      checkselect: true,
    },
    "zona_bien": {
      checkselect: true,
    }
  },
  messages: {
    "extension": {
      min: "No debe ser negativo.",
    },
    "precio": {
      min: "No debe ser negativo.",
    },
  },
};

$(document).ready(function() {
  //categoria
  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/ActivoFijo/Bienes_Inmuebles/AutocompleteDatosComunes',
    name: 'dato_comun',
    siguiente: 'codigo_anterior',
    content: 'suggestions1'
  });
});

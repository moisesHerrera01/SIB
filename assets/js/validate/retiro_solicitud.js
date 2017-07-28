//Reglas de validacion de solicitud + retiro
var reglas = {
  rules: {
    "autocomplete3": {
      checkautocomplete: 'seccion'
    },
    "fecha_solicitud":{
      required: true,
      minordate: true
    },
    "autocomplete2":{
      checkautocomplete: 'id_fuentes'
    },
    "autocomplete":{
      checkautocomplete: 'id_usuario'
    },
    "prioridad": {
      checkselect: true,
    }
  },
  messages: {
    "fecha_solicitud":{
      required: "La fecha es obligatoria."
    },
  },
};

$(document).ready(function() {

  //fuente de fondo
  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/Bodega/Fuentefondos/Autocomplete',
    name: 'id_fuentes',
    siguiente: 'button',
    content: 'suggestions2'
  });

  //seccion
  $.autocomplete({
    elemet: $('input[name=autocomplete3]'),
    url: 'index.php/ActivoFijo/Almacenes/AutocompleteSeccion',
    name: 'seccion',
    siguiente: 'id_usuario',
    content: 'suggestions3',
    addfunction: function() {
      //solicitante
      $.autocomplete({
        elemet: $('input[name=autocomplete]'),
        url: 'index.php/Bodega/Solicitud_retiro/AutocompleteUsuarioSeccion',
        name: 'id_usuario',
        siguiente: 'default',
        content: 'suggestions1',
        ajaxdata: {seccion: $('input[name=seccion]').val()},
      });

    }
  });
});

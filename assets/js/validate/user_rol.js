//Reglas de validacion de solicitud bodega
var reglas = {
  rules: {
    "autocomplete3": {
        checkautocomplete: 'seccion'
    },
    "autocomplete2": {
        checkautocomplete: 'fuente'
    },
  },
};

$(document).ready(function() {
  //unidad
  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/Usuario_Rol/AutocompleteUsuario',
    name: 'usuario',
    siguiente: 'rol',
    content: 'suggestions1'
  });

  //fuente
  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/Usuario_Rol/AutocompleteRol',
    name: 'rol',
    siguiente: 'button',
    content: 'suggestions2'
  });
});

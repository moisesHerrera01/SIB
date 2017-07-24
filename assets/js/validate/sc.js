//Reglas de validacion de solicitud compra
var reglas = {
  rules: {
    "valor": {
      required: true,
    },
    "justificacion": {
      required: true,
    },
    "fecha": {
      required: true,
      minordate: true
    },
    "autocomplete1": {
      checkautocomplete: 'sol'
    },
    "autocomplete2": {
      checkautocomplete: 'auto'
    },
    "autocomplete3": {
      checkautocomplete: 'admin'
    },
    "archivo": {
       extension: "gif|jpg|png|pdf|docx|doc|xls|xlsx"
    },
  },
  messages: {
    "valor": {
      required: "El valor estimado es obligatorio."
    },
    "justificacion": {
      required: "Se debe justificar la compra.",
    },
    "fecha": {
      required: "La fecha es obligatoria.",
    },
    "archivo": {
      extension: "El tipo de archivo no es indicado."
    },
  },
};

$(document).ready(function() {
  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/Compras/Solicitud_Compra/AutocompleteSolicitante',
    name: 'sol',
    siguiente: 'cargo',
    content: 'suggestions1',
    asociacion: ['cargo', 'linea']
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete2]'),
    url: 'index.php/Compras/Solicitud_Compra/AutocompleteEmpleadoDatos',
    name: 'auto',
    siguiente: 'cargo_auto',
    content: 'suggestions2',
    asociacion: ['cargo_auto', 'dep_auto']
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete3]'),
    url: 'index.php/Compras/Solicitud_Compra/AutocompleteEmpleadoDatos',
    name: 'admin',
    siguiente: 'cargo_admin',
    content: 'suggestions3',
    asociacion: ['cargo_admin', 'dep_admin']
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete4]'),
    url: 'index.php/Bodega/Fuentefondos/Autocomplete',
    name: 'fuentes',
    siguiente: 'fecha',
    content: 'suggestions4'
  });

  $('input[type=file]').change(function (){
     var fileRoute = $(this).val();
     var fileName = fileRoute.split("\\");
     console.log(fileName);
     $("#file_name").val(fileName[2]);
   });

});

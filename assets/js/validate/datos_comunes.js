//Reglas de validacion de datos comunes
var reglas = {
  rules: {
    "autocomplete1": {
        required: true,
        checkautocomplete: 'subcategoria'
    },
    "autocomplete3": {
        required: true,
        checkautocomplete: 'marca'
    },
    "autocomplete4": {
        required: true,
        checkautocomplete: 'doc_ampara'
    },
    "autocomplete5": {
        required: true,
        checkautocomplete: 'proveedor'
    },
    "autocomplete6": {
        required: true,
        checkautocomplete: 'proyecto'
    },
    "autocomplete7": {
        required: true,
        checkautocomplete: 'cuenta'
    },
    "descripcion": {
        required: true,
    },
    "precio": {
        required: true,
        min:0,
    },
    "garantia": {
        required: true,
        min:0,
    },
  },
  messages: {
    "autocomplete1": {
      required: "La subcategoria es obligatoria.",
    },
    "autocomplete3": {
      required: "La marca es obligatoria.",
    },
    "autocomplete4": {
      required: "El documento ampara es obligatorio.",
    },    
    "autocomplete5": {
      required: "El proveedor es obligatorio.",
    },
    "autocomplete6": {
      required: "La fuente de fondo o proyecto es obligatoria.",
    },
    "autocomplete7": {
      required: "La cuenta contable es obligatoria.",
    },
    "descripcion": {
      required: "Este campo es obligatorio.",
    },
    "precio": {
      min: "No debe ser negativo.",
      required: "Este campo es obligatorio.",
    },
    "garantia": {
      min: "No debe ser negativo.",
      required: "Este campo es obligatorio.",
    },
  },
};

$(document).ready(function() {
  //categoria
  $.autocomplete({
    elemet: $('input[name=autocomplete1]'),
    url: 'index.php/ActivoFijo/Datos_comunes/AutocompleteSubcategorias',
    name: 'subcategoria',
    siguiente: 'marca',
    content: 'suggestions1'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete3]'),
    url: 'index.php/ActivoFijo/Datos_comunes/AutocompleteMarcas',
    name: 'marca',
    siguiente: 'descripcion',
    content: 'suggestions3'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete4]'),
    url: 'index.php/ActivoFijo/Datos_comunes/AutocompleteDocumentos',
    name: 'doc_ampara',
    siguiente: 'nombre_doc',
    content: 'suggestions4'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete5]'),
    url: 'index.php/Bodega/Proveedores/Autocomplete',
    name: 'proveedor',
    siguiente: 'proyecto',
    content: 'suggestions5'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete6]'),
    url: 'index.php/Bodega/Fuentefondos/Autocomplete',
    name: 'proyecto',
    siguiente: 'garantia',
    content: 'suggestions6'
  });

  $.autocomplete({
    elemet: $('input[name=autocomplete7]'),
    url: 'index.php/ActivoFijo/Datos_comunes/AutocompleteCuentas',
    name: 'cuenta',
    siguiente: 'codificar',
    content: 'suggestions7'
  });

});
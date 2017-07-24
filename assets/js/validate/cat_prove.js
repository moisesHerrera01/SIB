
var reglas = {
  rules: {
    "nombre": {
        required: true,
    },
    "tipo_empresa": {
        checkselect: true,
    },
    "rubro_empresa": {
        checkselect: true,
    },
  },
  messages: {
    "nombre": {
        required: "El nombre de la categoria es obligatorio.",
    },
  },
};
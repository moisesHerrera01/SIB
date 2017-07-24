//Reglas de validacion de retiro
var reglas = {
  rules: {
    "autocomplete": {
        required: true
    },
    "prioridad": {
        checkselect: true
    },
  },
  messages: {
    "autocomplete": {
      required: "El nombre de sección es obligatorio."
    }
  },
};

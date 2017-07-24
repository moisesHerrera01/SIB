//Reglas de validacion de hdd
var reglas = {
  rules: {
    "capacidad": {
        required: true,
    },
    "unidad": {
      checkselect: true,
    }
  },
  messages: {
    "capacidad": {
      required: "La capacidad es obligatoria.",
    },
  },
};

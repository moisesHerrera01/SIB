var reglas = {
  rules: {
    "fechaMin": {
      required: true,
    },
    "fechaMax": {
      required: true,
      comparedate: 'fechaMin'
    },
    "tipo_computadora": {
      checkselect: true,
    }
  },
  messages: {
    "fechaMin": {
      required: "La fecha inicial es obligatoria.",
    },
    "fechaMax": {
      required: "La fecha final es obligatoria.",
    }
  },
};
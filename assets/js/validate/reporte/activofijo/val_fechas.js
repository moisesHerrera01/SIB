var reglas = {
  rules: {
    "fecha_inicio": {
      required: true,
    },
    "fecha_fin": {
      required: true,
      comparedate: 'fecha_inicio'
    },
    "fechaMin": {
      required: true,
    },
    "fechaMax": {
      required: true,
      comparedate: 'fechaMin'
    },
  },
  messages: {
    "fecha_inicio": {
      required: "La fecha inicial es obligatoria.",
    },
    "fecha_fin": {
      required: "La fecha final es obligatoria.",
    },
    "fechaMin": {
      required: "La fecha inicial es obligatoria.",
    },
    "fechaMax": {
      required: "La fecha final es obligatoria.",
    }
  }
}
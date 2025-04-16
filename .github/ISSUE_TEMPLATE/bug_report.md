name: 🛠️ Bug Report
description: Segnala un bug nel backend
title: "[Bug]: "
labels: [bug]
body:
  - type: textarea
    attributes:
      label: Descrizione del problema
      placeholder: Spiega chiaramente il bug riscontrato
    validations:
      required: true
  - type: textarea
    attributes:
      label: Come riprodurre
      placeholder: Passaggi per riprodurre il bug
    validations:
      required: true
  - type: input
    attributes:
      label: Ambiente
      placeholder: es. local, staging, production

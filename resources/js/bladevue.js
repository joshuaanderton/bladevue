import axios from 'axios'
import { createApp as createPetiteApp } from 'petite-vue'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

createPetiteApp({

  mounted: false,
  loading: true,
  error: null,
  arguments: {}, 

  endpoint: null,
  concept: null,
  operation: null,

  reload() {
    this.fetchState()
  },

  fetchState() {
    this.loading = true

    axios.get(this.endpoint, this.arguments)
      .then(response => this.setState(response.data))
      .catch(error => this.error = error)
      .then(() => this.loading = false)
  },

  setState(params) {
    for (var key in params) {
      this[key] = params[key]
    }
  },

  run(action, params) {
    this.loading = true

    axios.post(`${this.endpoint}/actions/${action}`, params)
      .then(response => this.setState(response))
      .catch(error => this.error = error)
      .then(() => this.loading = false)
  },

  init(concept, operation, params) { 
    this.concept   = concept
    this.operation = operation
    this.endpoint  = `/blazervel/concepts/${this.concept}/components/${this.operation}`

    this.setState(params)

    this.mounted = true
  },

  $delimiters: ['${', '}']

}).mount()
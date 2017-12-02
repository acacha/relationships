export default {
  data: function () {
    return {
      validation: true,
      strictValidation: true
    }
  },
  methods: {
    toogleValidation() {
      this.validation = !this.validation
      this.strictValidation= this.validation
      this.updateValidation()
      this.updateStrictValidation()
    },
    updateValidation(){
      if (this.validation) this.$store.dispatch('enableValidationAction')
      else this.$store.dispatch('disableValidationAction')
    },
    updateStrictValidation(){
      if (this.strictValidation) this.$store.dispatch('enableStrictValidationAction')
      else this.$store.dispatch('disableStrictValidationAction')
    },
    toogleStrictValidation() {
      this.strictValidation = !this.strictValidation
      this.updateStrictValidation()
    }
  }
}

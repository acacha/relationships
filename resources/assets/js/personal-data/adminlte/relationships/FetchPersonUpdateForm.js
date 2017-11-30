export default {
  methods: {
    fetchPersonAndUpdateForm(personId) {
      this.$store.dispatch('updateLoadingAction', true)
      this.fetchPerson(personId).then( response => {
        this.updateForm(response.data)
        this.$store.dispatch('updateActionAction', this.$store.UPDATE_ACTION )
      }).catch( error => {
        console.log(error)
      })
        .then(() => {
          this.$store.dispatch('updateLoadingAction', false)
        })
    }
  }
}
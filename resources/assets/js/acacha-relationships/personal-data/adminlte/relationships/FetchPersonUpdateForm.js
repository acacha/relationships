import {UPDATE_ACTION} from '../../acacha-forms/vuex/constants.js'

export default {
  methods: {
    fetchPersonAndUpdateForm(personId) {
      this.$store.dispatch('updateLoadingAction', true)
      this.fetchPerson(personId).then( response => {
        this.updateForm(response.data)
        this.$store.dispatch('updateActionAction', UPDATE_ACTION )
        this.$store.dispatch('updateResourceIdAction', response.data.id )
        this.$store.dispatch('clearErrorsAction' )
      }).catch( error => {
        console.log(error)
      })
        .then(() => {
          this.$store.dispatch('updateLoadingAction', false)
        })
    }
  }
}
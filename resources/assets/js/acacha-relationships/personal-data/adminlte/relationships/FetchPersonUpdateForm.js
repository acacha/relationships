import {UPDATE_ACTION} from '../../acacha-forms/vuex/constants.js'

export default {
  methods: {
    fetchPersonAndUpdateForm (personId) {
      this.$store.dispatch('acacha-forms/updateLoadingAction', true)
      this.fetchPerson(personId).then(response => {
        this.updateForm(response.data)
        this.$store.dispatch('acacha-forms/updateActionAction', UPDATE_ACTION)
        this.$store.dispatch('acacha-forms/updateResourceIdAction', response.data.id)
        this.$store.dispatch('acacha-forms/clearErrorsAction')
      }).catch(error => {
        console.log(error)
      })
        .then(() => {
          this.$store.dispatch('acacha-forms/updateLoadingAction', false)
        })
    }
  }
}

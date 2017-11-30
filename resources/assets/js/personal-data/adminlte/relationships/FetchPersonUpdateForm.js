import {UPDATE_ACTION} from '../../acacha-forms/vuex/constants.js'

export default {
  methods: {
    fetchPersonAndUpdateForm(personId) {
      this.$store.dispatch('updateLoadingAction', true)
      this.fetchPerson(personId).then( response => {
        this.updateForm(response.data)
        this.$store.dispatch('updateActionAction', UPDATE_ACTION )
        console.log('response.data.id')
        console.log(response.data.id)
        this.$store.dispatch('updatePersonIdAction', response.data.id )
      }).catch( error => {
        console.log(error)
      })
        .then(() => {
          this.$store.dispatch('updateLoadingAction', false)
        })
    }
  }
}
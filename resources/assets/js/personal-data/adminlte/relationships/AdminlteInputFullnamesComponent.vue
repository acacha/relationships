<template>
    <div class="form-group">
        <label for="fullname">Full name</label>
        <multiselect
                id="fullname"
                placeholder="Select name"
                :value="fullname"
                @input="updateFullname"
                :options="fullnames"
                :custom-label="customLabel"
                track-by="identifier_id"
                :loading="loading">
        </multiselect>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>

  import Multiselect from 'vue-multiselect'
  import axios from 'axios'
  import FetchPerson from './FetchPerson'
  import FetchPersonUpdateForm from './FetchPersonUpdateForm'
  import UpdateForm from './UpdateForm'

  export default {
    name: 'AdminlteInputFullnames',
    components: {Multiselect},
    mixins: [ FetchPerson, FetchPersonUpdateForm, UpdateForm ],
    data () {
      return {
        fullnames: [],
        loading: false,
      }
    },
    computed: {
      fullname() {
        if (this.fullNameString === '') {
          return null
        }
        let fullNameFound =  this.fullnames.find((fullname) => {
          return fullname.name === this.fullNameString
        })
        if (fullNameFound) {
          return fullNameFound
        }
        const fullname = {
          id: -1,
          identifier: -1,
          identifier_id: -1,
          name: this.fullNameString
        }
        if ( this.fullnames[0].id === -1 ){
          this.fullnames.shift()
        }
        this.fullnames.splice(0,0,fullname)
        return fullname
      },
      fullNameString() {
        let fullname =  this.$store.state.form.givenName + ' ' + this.$store.state.form.surname1 + ' ' +this.$store.state.form.surname2
        return fullname.trim()
      },
    },
    methods: {
      customLabel({ name, identifier}) {
        return identifier !==-1 ? `${name} - ${identifier}` : `${name}`
      },
      updateFullname(fullname) {
        if (fullname) {
          this.fetchPersonAndUpdateForm(fullname.id)
        }
      },
      fetchFullnames() {
        const url = '/api/v1/fullname'
        this.loading = true
        axios.get(url).then( (response) => {
          this.fullnames = response.data
        }).catch( (error) => {
          console.log(error)
        }).then( () => {
          this.loading = false
        })
      },
    },
    mounted() {
      this.fetchFullnames()
    }
  }

</script>
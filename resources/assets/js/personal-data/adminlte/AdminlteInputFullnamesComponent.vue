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

  export default {
    name: 'AdminlteInputFullnames',
    components: {Multiselect},
    mixins: [ FetchPerson ],
    data () {
      return {
        fullnames: [],
        loading: false,
      }
    },
    computed: {
      fullname() {
        let currentFullName = this.currentFullNameOnForm()
        let fullname = this.findFullNameByFullname(currentFullName)
        if( fullname) return fullname
        this.fullnames.splice(0,0,{
          name : currentFullName,
          identifier: this.$store.state.form.identifier,
          identifier_id: this.$store.state.form.identifier_id
        })
        return this.fullnames[0]
      }
    },
    methods: {
      findFullNameByIdentifierId(id){
        return this.fullnames.find((fullname) => {
          return fullname.identifier_id === id
        })
      },
      findFullNameByFullname(fullnameToSearch){
        return this.fullnames.find((fullname) => {
          return fullname.name === fullnameToSearch
        })
      },
      currentFullNameOnForm() {
        let fullname =  this.$store.state.form.givenName + ' ' + this.$store.state.form.surname1 + ' ' +this.$store.state.form.surname2
        return fullname.trim()
      },
      customLabel({ name, identifier}) {
        return identifier ? `${name} - ${identifier}` : `${name}`
      },
      updateFullname(fullname) {
        if (fullname) {
          this.fetchPerson(fullname.id)
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
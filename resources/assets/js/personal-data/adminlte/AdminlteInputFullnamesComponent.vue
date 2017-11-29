<template>
    <div class="form-group">
        <label for="fullname">Full name</label>
        <multiselect
                id="fullname"
                placeholder="Select name"
                :value="fullname"
                @input="updateField"
                :options="fullnames"
                :custom-label="customLabel"
                :loading="loading">
        </multiselect>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


<script>

  import Multiselect from 'vue-multiselect'
  import axios from 'axios'

  export default {
    components: {Multiselect},
    data () {
      return {
        fullnames: [],
        loading: false,
        fullname: null
      }
    },
    methods: {
      customLabel({ name, identifier}) {
        return identifier ? `${name} - ${identifier}` : `${name}`
      },
      updateField(fullname) {
        let field = this.name
        let value = ''
        if (fullname) value = fullname.id
        this.$store.commit('updateForm', { field, value});
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
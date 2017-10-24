<!-- Vue component -->
<template>
    <div>
        <multiselect v-model="value" :options="identifiers" label="value"></multiselect>
    </div>
</template>

<script>
  import Multiselect from 'vue-multiselect'

  // register globally
  Vue.component('multiselect', Multiselect)

  export default {
    // OR register locally
    components: { Multiselect },
    data () {
      return {
        value: null,
        identifiers: []
      }
    },
    methods: {
      fetchIdentifiers() {
        let url = '/api/v1/identifier'
        axios.get(url).then((response) => {
          this.identifiers = response.data
        }).catch((error) => {
          console.log(error)
        })
      }
    },
    mounted() {
      this.fetchIdentifiers()
    }
  }
</script>

<!-- New step!
     Add Multiselect CSS. Can be added as a static asset or inside a component. -->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

</style>
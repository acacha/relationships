<!-- Vue component -->
<template>
    <div class="form-group">
        <label for="fullname">Full name</label>
        <multiselect id="fullname" v-model="fullname" :options="fullnames" label="fullname" :custom-label="customLabel"
                     @select="fullnameHasBeenSelected"
                     placeholder="Select name"></multiselect>
    </div>
</template>

<script>
  import Multiselect from 'vue-multiselect'

  export default {
    components: { Multiselect },
    data () {
      return {
        fullname: null,
        fullnames: []
      }
    },
    methods: {
      fullnameHasBeenSelected(fullname) {
        this.$emit('selected',fullname)
      },
      customLabel({ name, identifier}) {
        return `${name} - ${identifier}`
      },
      fetchFullnames() {
        let url = '/api/v1/fullname'
        axios.get(url).then((response) => {
          this.fullnames = response.data
        }).catch((error) => {
          console.log(error)
        })
      },
    },
    mounted() {
      this.fetchFullnames()
    }
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

</style>
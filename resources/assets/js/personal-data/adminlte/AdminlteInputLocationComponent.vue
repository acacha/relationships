<template>
    <div class="form-group has-feedback" :class="{ 'has-error': internalForm.errors.has(name) }">
        <transition name="fade">
            <label key="error" class="help-block" v-if="internalForm.errors.has(name)" v-text="internalForm.errors.get(name)"></label>
            <slot name="label" v-else>
                <label key="regular" :for="id">{{placeholder}}</label>
            </slot>
        </transition>

        <multiselect :id="id"
                     :name="name"
                     :placeholder="placeholder"
                     :value="location"
                     @input="updateField"
                     :options="locations"
                     select-label=""
                     :custom-label="customLabel"
                     :disabled="internalForm.submitting"
                     :loading="loading">
        </multiselect>

    </div>
</template>

<style src="./fade.css" />

<style src="vue-multiselect/dist/vue-multiselect.min.css" />

<script>

  import formWidget from './FormWidget'
  import Multiselect from 'vue-multiselect'
  import axios from 'axios'

  export default {
    components: { Multiselect },
    mixins: [ formWidget ],
    data () {
      return {
        locations: [],
        loading: false,
        location: null
      }
    },
    props: {
      name: {
        type: String,
        default: "location"
      },
      placeholder: {
        type: String,
        default: "Select location"
      }
    },
    methods: {
      customLabel({ name }) {
        return `${name}`
      },
      updateField(location) {
        let field = this.name
        let value = ''
        if (location) value = location.id
        this.$store.commit('updateForm', { field, value});
      },
      fetchLocations() {
        const url = '/api/v1/location'
        this.loading = true
        axios.get(url).then( (response) => {
          this.locations = response.data
          this.location = this.findLocationById(this.internalForm[this.name])
        }).catch( (error) => {
          console.log(error)
        }).then( () => {
          this.loading = false
        })
      },
      findLocationById(locationId){
        if (!locationId) return null
        return this.locations.find((location) => {
          return location.id == locationId
        })
      },
    },
    mounted() {
      this.fetchLocations()
    }
  }
</script>
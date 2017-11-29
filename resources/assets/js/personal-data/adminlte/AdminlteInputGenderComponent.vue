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
                     :value="gender"
                     @input="updateField"
                     :options="genders"
                     select-label=""
                     :custom-label="customLabel"
                     :disabled="internalForm.submitting">
        </multiselect>
    </div>
</template>

<style src="./fade.css" />

<style src="vue-multiselect/dist/vue-multiselect.min.css" />

<script>

  import formWidget from './FormWidget'
  import Multiselect from 'vue-multiselect'

  const genders = [
    {
      label : 'Male',
      value: 'male'
    },
    {
      label : 'Female',
      value: 'female'
    }
  ]

  export default {
    components: { Multiselect },
    mixins: [ formWidget ],
    data () {
      return {
        genders: genders
      }
    },
    props: {
      name: {
        type: String,
        default: "gender"
      },
      placeholder: {
        type: String,
        default: "Select gender"
      }
    },
    computed: {
      gender: function () {
        return genders.find( gender => {
          return gender.value === this.internalForm[this.name]
        })
      }
    },
    methods: {
      customLabel({ label }) {
        return `${label}`
      },
      updateField(gender) {
        let field = this.name
        let value = ''
        if ( gender ) value = gender.value
        this.$store.commit('updateForm', { field, value});
      }
    }
  }
</script>
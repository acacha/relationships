<template>
    <div class="form-group has-feedback" :class="{ 'has-error': hasError() }">
        <transition name="fade">
            <label key="error" class="help-block" v-if="hasError()" v-text="error()"></label>
            <slot name="label" v-else>
                <label key="regular" :for="id">{{placeholder}}</label>
            </slot>
        </transition>
        <multiselect :id="name"
                     :name="name"
                     :placeholder="placeholder"
                     :value="gender"
                     @input="updateGender"
                     :options="genders"
                     track-by="value"
                     select-label=""
                     deselect-label=""
                     :show-labels="false"
                     :custom-label="customLabel"
                     :disabled="internalForm.submitting">
        </multiselect>
    </div>
</template>

<style src="./fade.css"></style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
  import { FormComponent } from 'acacha-adminlte-vue-forms'
  import Multiselect from 'vue-multiselect'

  const genders = [
    {
      label: 'Male',
      value: 'male'
    },
    {
      label: 'Female',
      value: 'female'
    }
  ]

  export default {
    name: 'AdminLTEInputGender',
    components: { Multiselect },
    mixins: [ FormComponent ],
    data () {
      return {
        genders: genders
      }
    },
    props: {
      name: {
        type: String,
        default: 'gender'
      },
      placeholder: {
        type: String,
        default: 'Select gender'
      }
    },
    computed: {
      gender: function () {
        return this.genderObject()
      }
    },
    methods: {
      customLabel ({ label }) {
        return `${label}`
      },
      updateGender (gender) {
        let genderValue = gender ? gender.value : ''
        this.updateFormField(genderValue)
        genderValue && this.clearError()
      },
      clearError () {
        this.$store.dispatch(this.action('clearErrorAction'), this.name)
      },
      genderObject () {
        return this.genders.find(gender => {
          return gender.value === this.internalForm[this.name]
        })
      }
    }
  }
</script>

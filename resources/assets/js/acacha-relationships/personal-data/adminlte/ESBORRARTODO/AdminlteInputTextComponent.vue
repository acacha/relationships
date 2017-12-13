<template>
    <div class="form-group has-feedback" :class="{ 'has-error': internalForm.errors.has(name) }">
        <transition name="fade">
            <label key="error" class="help-block" v-if="internalForm.errors.has(name)" v-text="internalForm.errors.get(name)"></label>
            <slot name="label" v-else>
                <label key="regular" :for="id">{{placeholder}}</label>
            </slot>
        </transition>
        <input type="text"
               class="form-control"
               :id="id"
               :placeholder="placeholder"
               :name="name"
               :value="internalForm[name]"
               @keyup.stop="update($event.target.value)"
               :disabled="internalForm.submitting">
    </div>
</template>

<style src="./fade.css" />

<script>

 import formWidget from './FormWidget'

  export default {
    name: 'AdminLTEInputText',
    mixins: [ formWidget ],
    methods: {
      update (value) {
        this.updateFormField(this.trim(value))
      },
      trim (value) {
        if (typeof value === 'string' || value instanceof String) {
          return value.trim()
        }
        return value
      }
    }
  }
</script>
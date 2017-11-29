<template>
    <div class="form-group has-feedback" :class="{ 'has-error': internalForm.errors.has(name) }">
        <transition name="fade">
            <label key="error" class="help-block" v-if="internalForm.errors.has(name)" v-text="internalForm.errors.get(name)"></label>
            <slot name="label" v-else>
                <label key="regular" :for="id">{{placeholder}}</label>
            </slot>
        </transition>

        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>

            <input ref="inputDate"
                   type="text"
                   class="form-control"
                   :data-inputmask="inputMask"
                   data-mask=""
                   :id="id"
                   :name="name"
                   :value="localeDate"
                   @change="updateDate($event.target.value)"
                   :disabled="internalForm.submitting">
        </div>

    </div>
</template>

<style src="./fade.css" />

<script>

  import formWidget from './FormWidget'

  import Inputmask from "inputmask/dist/inputmask/inputmask.date.extensions";

  import { toLaravelDate, fromLaravelDate } from "./LaravelDates"

  export default {
    name: 'AdminLTEInputDateMask',
    mixins: [ formWidget ],
    data () {
      return {
        inputMask: "'alias': '" + window.acacha_relationships.config.dateMask + "'"
      }
    },
    props: {
      name: {
        type: String,
        default: "date"
      }
    },
    watch: {
      date: function(newVal) {
        this.internalDate = newVal
      }
    },
    computed: {
      localeDate: {
        get: function () {
          return fromLaravelDate(this.internalForm[this.name])
        },
        set: function (newValue) {
          this.newDate = toLaravelDate(newValue)
        }
      },
    },
    methods: {
      updateDate(date) {
        date = date ? toLaravelDate(date) : ''
        this.updateFormField(date)
      }
    },
    mounted() {
      Inputmask().mask(this.$refs.inputDate);
    }
  }
</script>
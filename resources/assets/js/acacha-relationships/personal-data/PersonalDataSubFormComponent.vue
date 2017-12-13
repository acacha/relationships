<template>
    <div>
        <div :class="'alert alert-' + alertColor + ' flash-message ' + alertDismissibleClass" v-if="alertVisible && alertMessage !=''">
            <button @click="hide" v-if="alertDismissible" type="button" class="close" alert-dismiss="alert" aria-hidden="true">×</button>
            <h4 v-if="alertTitle"><i :class="'icon fa fa-' + alertIcon"></i> {{ alertTitle }}</h4>
            {{ alertMessage }}
        </div>
        <div class="box box-primary">
            <form method="post" @submit.prevent="submit" @keydown="clearErrors($event.target.name)">
                <div class="box-header with-border">
                    <h3 class="box-title">Dades Personals</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-7">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <adminlte-input-text name="givenName" :form="form"></adminlte-input-text>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">

                        </div>

                        <div class="col-md-4">
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="todo">Altres accions</label>
                                <div id="todo">+ Identifiers</div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="overlay" v-show="loading">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="box-footer vertical-align-content">
                    <div>
                        Validation: <toggle-button @change="toogleValidation" :value="validation" :sync="true" :labels="true" class="mr"></toggle-button>
                    </div>
                    <div v-if="validation">
                        Strict: <toggle-button @change="toogleStrictValidation" :value="strictValidation" :sync="true" :labels="true" class="mr"></toggle-button>
                    </div>
                    <button type="button" class="btn mr" @click="confirmClear" v-if="!clearing">Clear</button>
                    <div v-else class="mr">
                        Sure? <i class="fa fa-check green" @click="clear"></i> <i class="fa fa-remove red" @click="clearing = false;" ></i>
                    </div>
                    <button type="submit" class="btn btn-primary" :disabled="form.submitting || form.errors.any()">
                        <template v-if="form.submitting"><i class="fa fa-refresh fa-spin"></i></template>
                        {{ action }}
                    </button>
                </div>
            </form>
        </div>
        <div>
            <h3>Form:</h3>
            {{ form }}
            <h3>Errors:</h3>
            {{ form.errors }}
        </div>
    </div>
</template>

<style>
    .vertical-align-content {
        display:flex;
        align-items:center;
        justify-content: flex-end
    }
    .mr {
        margin-right: 1em;
    }
    .red {
        color: red;
    }
    .green {
        color: green;
    }
</style>

<script>
  import ToggleButton from 'vue-js-toggle-button'
  import {FlashMixin, AlertMixin} from 'adminlte-vue'
  import Validation from './validation.js'
  // TODO agafar del paquet original acacha-forms!!!!!!!!
  import {UPDATE_ACTION} from './acacha-forms/vuex/constants.js'
  import { mapGetters } from 'vuex'
  import { AdminlteInputTextComponent } from 'acacha-adminlte-vue-forms'
  import Vue from 'vue'
  import Form, { FormsModule } from 'acacha-forms'

  const API_URI_ENDPOINT = '/api/v1/person'

  Vue.use(ToggleButton)

  const initialForm = new Form({
    givenName: ''
  })

  const AcachaForm = FormsModule(initialForm)

  export default {
    name: 'PersonalDataSubForm',
    components: { AdminlteInputTextComponent },
    mixins: [FlashMixin, AlertMixin, Validation],
    data () {
      return {
        clearing: false,
        lastStatusCode: null,
        lastStatusText: null,
        lastCreatedUser: null,
        message: ''
      }
    },
    computed: {
      lastCreatedUserFullName () {
        if (!this.lastCreatedUser) return ''
        let fullname = this.lastCreatedUser.givenName + ' ' + this.lastCreatedUser.surname1 + ' ' + this.lastCreatedUser.surname2
        return fullname.trim()
      },
      loading () {
        return this.$store.state.form_loading
      },
      action () {
        if (this.form.submitting) {
          if (this.$store.state.form_action === UPDATE_ACTION) {
            return 'Updating'
          } else {
            return 'Creating'
          }
        } else {
          if (this.$store.state.form_action === UPDATE_ACTION) {
            return 'Update'
          } else {
            return 'Create'
          }
        }
      },
      ...mapGetters({
        form: 'acacha-forms/form'
      })
    },
    methods: {
      submit () {
        let uri = API_URI_ENDPOINT
        let action = 'acacha-forms/post'
        if (this.$store.state.form_action === UPDATE_ACTION) {
          uri = API_URI_ENDPOINT + '/' + this.$store.state.form_resource_id
          action = 'acacha-forms/put'
        }
        this.$store.dispatch(action, uri).then(response => {
          this.lastStatusCode = response.status
          this.lastStatusText = response.statusText
          this.lastCreatedUser = response.data
          this.message = 'User created ok!'
          if (action === 'put') this.message = 'User modified ok!'
          let actionPart = 'added'
          if (action === 'put') actionPart = 'modified'
          let color = 'success'
          if (action === 'put') color = 'warning'
          this.flash(this.lastCreatedUserFullName + ' has been ' + actionPart + ' to database', this.message, color)
        }).catch(error => {
          if (error.response.status === 422) return
          this.flash('' + error, 'Oooppssss something went wrong!', 'danger', 'ban')
        })
      },
      confirmClear () {
        this.clearing = true
      },
      clear () {
        this.$store.dispatch('acacha-forms/resetFormAction')
        this.clearing = false
      },
      clearErrors (fieldName) {
        if (!fieldName) return
        this.$store.dispatch('acacha-forms/clearErrorAction', fieldName)
      }
    },
    created () {
      const store = this.$store
      if (!(store && store.state && store.state['acacha-forms'])) store.registerModule('acacha-forms', AcachaForm)
    }
  }
</script>

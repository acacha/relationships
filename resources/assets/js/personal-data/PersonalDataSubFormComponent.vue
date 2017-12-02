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
                            <adminlte-input-identifiers></adminlte-input-identifiers>
                        </div>
                        <div class="col-md-7">
                            <adminlte-input-fullnames></adminlte-input-fullnames>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group has-feedback">
                                <adminlte-input-text name="givenName"></adminlte-input-text>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <adminlte-input-text name="surname1"></adminlte-input-text>
                        </div>
                        <div class="col-md-3">
                            <adminlte-input-text name="surname2"></adminlte-input-text>
                        </div>
                        <div class="col-md-2">
                            <adminlte-input-gender>
                                <label slot="label">Gender</label>
                            </adminlte-input-gender>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <adminlte-input-location name="birthplace_id" placeholder="Select birthplace">
                                <label slot="label">Birth place</label>
                            </adminlte-input-location>
                        </div>

                        <div class="col-md-4">
                            <adminlte-input-date-mask name="birthdate"></adminlte-input-date-mask>
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

  const API_URI_ENDPOINT = '/api/v1/person'

  import ToggleButton from 'vue-js-toggle-button'
  Vue.use(ToggleButton)
  import Alert from './alert.js'
  import Flash from './flash.js'
  import Validation from './validation.js'

  import {UPDATE_ACTION} from './acacha-forms/vuex/constants.js'

  export default {
    name:'PersonalDataSubForm',
    mixins: [Alert, Flash, Validation],
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
      lastCreatedUserFullName(){
        if (!this.lastCreatedUser) return ''
        let fullname = this.lastCreatedUser.givenName + ' ' + this.lastCreatedUser.surname1 + ' ' + this.lastCreatedUser.surname2
        return fullname.trim()
      },
      loading() {
        return this.$store.state.form_loading
      },
      form() {
        return this.$store.state.form
      },
      action() {
        if (this.form.submitting) {
          if(this.$store.state.form_action === UPDATE_ACTION ) {
            return 'Updating';
          } else {
            return 'Creating';
          }
        } else {
          if(this.$store.state.form_action === UPDATE_ACTION ) {
            return 'Update';
          } else {
            return 'Create';
          }
        }
      }
    },
    methods: {
      submit() {
        var component = this
        let uri = API_URI_ENDPOINT
        let action = 'post'
        if ( this.$store.state.form_action === UPDATE_ACTION) {
          uri = API_URI_ENDPOINT + '/' + this.$store.state.form_resource_id
          action = 'put'
        }
        this.$store.dispatch(action,uri).then( response => {
          this.lastStatusCode = response.status
          this.lastStatusText = response.statusText
          this.lastCreatedUser = response.data
          this.message = 'User created ok!'
          if (action === 'put') this.message = 'User modified ok!'
          let actionPart = 'added'
          if (action === 'put') actionPart = 'modified'
          let color = 'success'
          if (action === 'put') color = 'warning'
          this.flash(this.lastCreatedUserFullName + ' has been ' + actionPart + ' to database', this.message, color);
        }).catch( error => {
          if (error.response.status === 422) return
          this.flash('' + error, 'Oooppssss something went wrong!', 'danger', 'ban');
        })
      },
      confirmClear() {
        this.clearing = true
      },
      clear(){
        this.$store.dispatch('resetFormAction')
        this.clearing = false
      },
      clearErrors (fieldName) {
        if ( !fieldName ) return
        this.$store.dispatch('clearErrorAction', fieldName)
      }
    },
    mounted() {
      this.$store.dispatch('clearOnSubmitAction')
      }
  }
</script>

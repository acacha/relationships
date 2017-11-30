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
                    <button type="button" class="btn mr" @click="testFlash">Flash</button>

                    <button type="button" class="btn mr" @click="confirmClear" v-if="!clearing">Clear</button>
                    <div v-else class="mr">
                        Sure? <i class="fa fa-check green" @click="clear"></i> <i class="fa fa-remove red" @click="clearing = false;" ></i>
                    </div>
                    <!--<div>-->
                        <!--Validation: <toggle-button @change="toogleValidation" :value="validation" :sync="true" :labels="true" class="mr"></toggle-button>-->
                    <!--</div>-->
                    <!--<div v-if="validation">-->
                        <!--Strict: <toggle-button @change="toogleStrictValidation" :value="strictValidation" :sync="true" :labels="true" class="mr"></toggle-button>-->
                    <!--</div>-->
                    <button type="submit" class="btn btn-primary" :disabled="form.submitting || form.errors.any()">
                        <template v-if="form.submitting"><i class="fa fa-refresh fa-spin"></i></template>
                        {{ action }}
                    </button>
                </div>
            </form>
        </div>

        <h4>Form</h4>
        <ul>
            <li>Identifier: {{form.identifier}}</li>
            <li>Identifier_id: {{form.identifier_id}}</li>
            <li>Identifier_type: {{form.identifier_type}}</li>
            <li>givenName: {{form.givenName}}</li>
            <li>Surname 1: {{form.surname1}}</li>
            <li>Surname 2: {{form.surname2}}</li>
            <li>Gender: {{form.gender}}</li>
            <li>Birthdate: {{form.birthdate}}</li>
            <li>Birthplace id: {{form.birthplace_id}}</li>
        </ul>
        <h4>Store</h4>
        <ul>
            <li> Loading: {{ $store.state.loading }}</li>
            <li> Action: {{ $store.state.action }}</li>
            <li> Person_id: {{ $store.state.person_id }}</li>
        </ul>
        <h4>Errors</h4>
        <ul>
            <li v-for="error in form.errors"> {{ error }}</li>
        </ul>
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

  import formStore from './acacha-forms/vuex/store'
  import Form from './acacha-forms/vuex/Form'
  import ToggleButton from 'vue-js-toggle-button'
  import Alert from './alert.js'
  Vue.use(ToggleButton)

  import {UPDATE_ACTION} from './acacha-forms/vuex/constants.js'

  let initialForm = new Form({
    identifier_id: '',
    identifier: '',
    identifier_type: 1,
    person_id: '',
    givenName: '',
    surname1: '',
    surname2: '',
    birthdate: '',
    birthplace_id: '',
    gender: ''
  })

  let store = formStore(initialForm)

  export default {
    store,
    mixins: [Alert],
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
        return this.$store.state.loading
      },
      form() {
        return this.$store.state.form
      },
      action() {
        if (this.form.submitting) {
          if(this.$store.state.action === UPDATE_ACTION ) {
            return 'Updating';
          } else {
            return 'Creating';
          }
        } else {
          if(this.$store.state.action === UPDATE_ACTION ) {
            return 'Update';
          } else {
            return 'Create';
          }
        }
      }
    },
    methods: {
      testFlash() {
        this.flash('Sergi Tur Badenas has been added to database','User created','success')
      },
      flash(message, title, color, icon) {
        if (typeof window.flash === "function") {
          window.flash(message, title, color, icon)
        } else {
          this.showAlert(message, title, color, icon)
        }
      },
      submit() {
        var component = this
        let uri = '/api/v1/person'
        let action = 'post'
        if ( this.$store.state.action === UPDATE_ACTION) {
          uri = '/api/v1/person/' + this.$store.state.person_id
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
      toogleValidation() {
//        this.validation = !this.validation
//        this.strictValidation= this.validation
      },
      toogleStrictValidation() {
//        this.strictValidation = !this.strictValidation
      },
      clearErrors (fieldName) {
        if ( !fieldName ) return
        this.$store.dispatch('clearErrorsAction', fieldName)
      }
    },
    mounted() {
      this.$store.dispatch('clearOnSubmitAction')
      }
  }
</script>

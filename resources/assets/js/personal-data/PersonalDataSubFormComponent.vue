<template>
    <div>
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
            <li>Person_id: {{form.person_id}}</li>
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
  Vue.use(ToggleButton)

  const initialForm = new Form({
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
    data () {
      return {
        clearing: false,
      }
    },
    computed: {
      loading() {
        return this.$store.state.loading
      },
      form() {
        return this.$store.state.form
      },
      action() {
        if (this.form.submitting) {
          if(this.$store.state.action === formStore.UPDATE_ACTION ) {
            return 'Updating';
          } else {
            return 'Creating';
          }
        } else {
          if(this.$store.state.action === formStore.UPDATE_ACTION ) {
            return 'Update';
          } else {
            return 'Create';
          }
        }
      }
    },
    methods: {
      submit() {
        this.$store.dispatch('post','/api/v1/person').then( response => {
          console.log('OK!!!!!!!!!!!!!!')
          console.log(response)
        }).catch( error => {
          console.log('Submit error: ' + error)
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
        this.$store.dispatch('clearErrorsAction', fieldName)
      }
    }
  }
</script>

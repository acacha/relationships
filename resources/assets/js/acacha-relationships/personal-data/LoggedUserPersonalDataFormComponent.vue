<template>
    <div>
        <adminlte-alert :alert="alert"></adminlte-alert>
        <form method="post" @submit.prevent="submit" @keydown="clearErrors($event.target.name)">
            <div class="row">
                <div class="col-md-4">
                    <adminlte-input-text name="givenName" :form-name="formName"></adminlte-input-text>
                </div>
                <div class="col-md-3">
                    <adminlte-input-text name="surname1" :form-name="formName"></adminlte-input-text>
                </div>
                <div class="col-md-3">
                    <adminlte-input-text name="surname2" :form-name="formName"></adminlte-input-text>
                </div>
                <div class="col-md-2">
                    <adminlte-input-gender :form-name="formName">
                        <label slot="label">Gender</label>
                    </adminlte-input-gender>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <adminlte-input-location name="birthplace_id" placeholder="Select birthplace" :form-name="formName">
                        <label slot="label">Birth place</label>
                    </adminlte-input-location>
                </div>
                <div class="col-md-4">
                    <adminlte-input-date-mask name="birthdate" :form-name="formName"></adminlte-input-date-mask>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" :disabled="isDisabled()">
                    <template v-if="form.submitting"><i class="fa fa-refresh fa-spin"></i></template>
                    {{ actionButton }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
  import {FlashMixin, DisabledSubmitMixin} from 'adminlte-vue'
  import { AdminlteInputTextComponent, AdminlteInputDateMaskComponent, AdminlteInputLocationComponent } from 'acacha-adminlte-vue-forms'
  import Form, { FormsModule, UsesAcachaForms, registerForm, ClearErrorsMixin, UPDATE_ACTION, CREATE_ACTION } from 'acacha-forms'
  import { InteractsWithUser } from 'acacha-users'
  import AdminlteInputGenderComponent from './adminlte/relationships/AdminlteInputGenderComponent.vue'
  import { getLoggedUserPerson } from '../api/LoggedUserPerson'

  const loggedUserPersonalDataForm = new Form({
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

  const API_ENDPOINT = '/api/v1/user/person'
  const ACACHA_FORM = FormsModule(loggedUserPersonalDataForm)
  const ACACHA_FORM_VUEX_MODULE = 'logged-user-personal-data-form'

  export default {
    name: 'LoggedUserPersonalDataForm',
    components: {
      AdminlteInputTextComponent,
      AdminlteInputDateMaskComponent,
      AdminlteInputLocationComponent,
      AdminlteInputGenderComponent
    },
    mixins: [FlashMixin, DisabledSubmitMixin, ClearErrorsMixin, UsesAcachaForms, InteractsWithUser],
    data () {
      return {
        lastStatusCode: null,
        lastStatusText: null,
        message: ''
      }
    },
    computed: {
      actionButton () {
        if (this.formAction === CREATE_ACTION) return 'Create'
        return 'Update'
      }
    },
    methods: {
      updateAction (action) {
        this.$store.dispatch(this.action('updateActionAction'), action)
      },
      updateResourceId (personId) {
        this.$store.dispatch(this.action('updateResourceIdAction'), personId)
      },
      fillForm () {
        getLoggedUserPerson().then(response => {
          if (response.data) {
            const person = response.data
            const fields = [
              {
                field: 'givenName',
                value: person.givenName
              },
              {
                field: 'surname1',
                value: person.surname1
              },
              {
                field: 'surname2',
                value: person.surname2
              },
              {
                field: 'birthdate',
                value: person.birthdate
              },
              {
                field: 'birthplace_id',
                value: person.birthplace_id
              },
              {
                field: 'gender',
                value: person.gender
              }
            ]
            this.updateForm(fields)
            this.updateResourceId(person.id)
            this.updateAction(UPDATE_ACTION)
          } else {
            this.updateAction(CREATE_ACTION)
          }
        }).catch(error => {
          console.log(error)
        })
      },
      submit () {
        let uri = API_ENDPOINT
        let action = 'post'
        if (this.formAction === UPDATE_ACTION) {
          action = 'put'
        }
        this.$store.dispatch(this.action(action), uri).then(response => {
          this.success('Your personal data is updated ok!')
          this.updateAction('put')
        }).catch(error => {
          if (error.response.status === 422) return
          this.flash('' + error, 'Oooppssss something went wrong!', 'danger', 'ban')
        })
      }
    },
    beforeCreate () {
      registerForm(this, ACACHA_FORM_VUEX_MODULE, ACACHA_FORM)
    }
  }
</script>

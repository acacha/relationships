<template>
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
                        <identifier-select @tag="identifierAdded" @selected="identifierSelected" :disabled="isLoading" :type="this.identifier_type" :identifier="form.identifier_id"></identifier-select>
                    </div>
                    <div class="col-md-7">
                        <fullname-select @selected="fullNameSelected" :disabled="isLoading" :identifier="form.identifier_id" :fullname="fullname"></fullname-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('givenName') }">
                            <label for="givenName">Given name</label>
                            <transition name="fade">
                                <span class="help-block" v-if="form.errors.has('givenName')" v-text="form.errors.get('givenName')"></span>
                            </transition>
                            <input type="text" class="form-control" id="givenName" placeholder="Name" name="givenName"
                                   v-model="form.givenName" :disabled="isLoading" @change="updateFullName">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('givenName') }">
                            <label for="surname1">Surname 1</label>
                            <transition name="fade">
                                <span class="help-block" v-if="form.errors.has('surname1')" v-text="form.errors.get('surname1')"></span>
                            </transition>
                            <input type="text" class="form-control" id="surname1" placeholder="Surname 1" name="surname1"
                                   v-model="form.surname1" :disabled="isLoading" @change="updateFullName">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('surname2') }">
                            <label for="surname2">Surname 2</label>
                            <transition name="fade">
                                <span class="help-block" v-if="form.errors.has('surname2')" v-text="form.errors.get('surname2')"></span>
                            </transition>
                            <input type="text" class="form-control" id="surname2" placeholder="Surname 2" name="surname2"
                                   v-model="form.surname2" :disabled="isLoading" @change="updateFullName">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <adminlte-input-gender
                                :disabled="isLoading"
                                :gender="form.gender ? form.gender : 'male'"
                                @change="genderHasBeenChanged"></adminlte-input-gender>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <adminlte-input-date-mask id="birthdate" :disabled="isLoading"
                                                  :date="form.birthdate" @change="birthDateHasBeenChanged">
                            <template slot="label">Birth date</template>
                        </adminlte-input-date-mask>
                    </div>

                    <div class="col-md-4">
                        <adminlte-input-location id="birthplace_id" :disabled="isLoading"
                                                 :location="form.birthplace_id ? form.birthplace_id : 1"
                                                 @change="birthPlaceHasBeenChanged"
                                                 name="birthplace_id">
                            <template slot="label">Birth place</template>
                        </adminlte-input-location>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="todo">Altres accions</label>
                            <div id="todo">+ Identifiers</div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h1>Form:</h1>
                        {{ form }}
                        <h1>Birthdate:</h1>
                        {{ form.birthdate }}
                    </div>
                </div>
            </div>
            <div class="overlay" v-show="isLoading">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" :disabled="isLoading">
                    <template v-if="isUpdatingExistingPerson">Update</template>
                    <template v-if="isInitial">Create</template>
                    <template v-if="isLoading"><i class="fa fa-refresh fa-spin"></i> Loading</template>
                </button>
            </div>
        </form>
    </div>
</template>

<script>

  import Form from 'acacha-forms'
  import { wait, LaravelDate } from '../utils'

  const STATUS_INITIAL = 0, STATUS_LOADING = 1, STATUS_UPDATING_EXISTING_PERSON = 2;

  export default {
    data: function () {
      return {
        currentStatus: STATUS_INITIAL,
        identifier_type: null,
        identifier: null,
        fullname : null,
        personId : null,
        form: new Form({ identifier_id: '',givenName: '', surname1: '', surname2: '', birthdate: '', birthplace_id: '', gender: '' }),
      }
    },
    computed: {
      isInitial() {
        return this.currentStatus === STATUS_INITIAL
      },
      isLoading() {
        return this.currentStatus === STATUS_LOADING
      },
      isUpdatingExistingPerson() {
        return this.currentStatus === STATUS_UPDATING_EXISTING_PERSON
      },
    },
    methods: {
      updateFullName() {
        this.fullname = {
          name: this.form.givenName + ' ' + this.form.surname1 + ' ' + this.form.surname2,
          identifier: this.identifier.value
        }
      },
      birthDateHasBeenChanged(newDate) {
        this.form.birthdate = newDate
      },
      birthPlaceHasBeenChanged(newBirthPlace) {
        this.form.birthplace_id = newBirthPlace.id
      },
      genderHasBeenChanged(newGender) {
        this.form.gender = newGender.value
      },
      fullNameSelected(fullname) {
        this.fetchPerson(fullname.id)
      },
      identifierSelected(identifier){
        this.fetchPerson(identifier.person_id)
      },
      identifierAdded(identifier) {
        this.identifier = identifier
        this.updateFullName()
      },
      mapPersonToForm(person) {
        this.form.identifier_id= person['identifier-id']
        this.identifier_type = person['identifier-type']
        this.form.givenName = person.givenName
        this.form.surname1 = person.surname1
        this.form.surname2 = person.surname2
        this.form.birthdate = person.birthdate
        this.form.birthplace_id = person.birthplace_id
        this.form.gender = person.gender
      },
      fetchPerson(personId, selectType) {
        this.currentStatus = STATUS_LOADING
        let url = '/api/v1/person/' + personId
        axios.get(url).then( response => {
          this.mapPersonToForm(response.data)
          this.currentStatus = STATUS_UPDATING_EXISTING_PERSON
        }).catch( (error) => {
          console.log(error)
        }).then( () => {
          this.personId = personId
        })
      },
      apiURL() {
        if (this.isUpdatingExistingPerson) return '/ap1/v1/person/' + this.personId
        return '/api/v1/person'
      },
      getMethod() {
        if (this.isUpdatingExistingPerson) return 'put'
        return 'post'
      },
      submit () {
        let API_URL = this.apiURL()
        let method = this.getMethod()
        this.form[method](API_URL)
          .then(response => {
            console.log(response.data)
            console.log('Ok!')
          })
          .catch(error => {
            console.log('Register error: ' + error)
          })
      },
      clearErrors (name) {
        this.form.errors.clear(name)
      }
    }
  }
</script>

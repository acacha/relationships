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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="givenName">Identifier</label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">DNI
                                        <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">DNI</a></li>
                                        <li><a href="#">Pasaport</a></li>
                                        <li><a href="#">NIE</a></li>
                                    </ul>
                                </div>
                                <input type="text" class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('givenName') }">
                            <label for="givenName">Given name</label>
                            <transition name="fade">
                                <span class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                            </transition>
                            <input type="text" class="form-control" id="givenName" placeholder="Name" name="givenName"
                                   v-model="form.name" autofocus>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="surname1">Surname 1</label>
                            <input type="text" class="form-control" id="surname1" placeholder="Surname 1">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="surname2">Surname 2</label>
                            <input type="text" class="form-control" id="surname2" placeholder="Surname 2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Birth date">Birth date</label>
                            <input type="text" class="form-control" id="Birth date" placeholder="Birth date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Birthplace">Birth Place</label>
                            <input type="text" class="form-control" id="Birthplace" placeholder="Birth place">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" class="form-control" id="gender" placeholder="Gender">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="todo">Altres accions</label>
                            <div id="todo">+ Identifiers</div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Save</button>
            </div>
        </form>
    </div>
</template>

<script>

  import Form from 'acacha-forms'

  export default {
    data: function () {
      return {
        form: new Form({ givenName: '', surname1: '', surname2: '', birthdate: '', birthplace_id: '', gender: '' })
      }
    },
    methods: {
      submit () {
        const API_URL = 'http://localhost:3000/users'
        this.form.post(API_URL)
          .then(response => {
            console.log('Ok!')
          })
          .catch(error => {
            console.log('Register error: ' + error)
          })
      },
      clearErrors (name) {
        this.form.errors.clear(name)
      }
    },
    mounted() {
      console.log('Component personal data subform mounted.')
    }
  }
</script>

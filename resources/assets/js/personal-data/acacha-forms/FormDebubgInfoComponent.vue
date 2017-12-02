<template>
    <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Debug info</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
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
                <li>Form disable validation: {{form.disable_validation}}</li>
                <li>Form disable strict validation: {{form.disable_strict_validation}}</li>
            </ul>
            <h4>Store</h4>
            <ul>
                <li> Loading: {{ $store.state.form_loading }}</li>
                <li> Action: {{ $store.state.form_action }}</li>
                <li> Resource id: {{ $store.state.form_resource_id }}</li>
            </ul>
            <h4>Errors</h4>
            <ul>
                <li v-for="error in form.errors"> {{ error }}</li>
            </ul>
        </div>
    </div>

</template>

<style>

</style>

<script>

  import formStore from './vuex/store'
  import Form from './vuex/Form'

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
    gender: '',
  })

  let store = formStore(initialForm)

  export default {
    name: 'FormDebugInfo',
    store,
    data () {
      return {
        data: 'example'
      }
    },
    computed: {
      form () {
        return this.$store.state.form
      }
    }
  }
</script>

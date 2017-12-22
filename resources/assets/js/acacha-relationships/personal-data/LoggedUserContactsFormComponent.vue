<template>
    <div>
        <div class="form-group has-feedback" >
           <label>Contacts</label>
            <div class="row">
                <div class="col-md-6">
                    <logged-user-emails-form></logged-user-emails-form>
                </div>
                <div class="col-md-3">
                    <label>Phones</label>
                    <ul class="todo-list">
                        <li v-for="phone in phones">
                            <i class="fa fa-fw fa-phone"></i>
                            {{phone}}
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <label>Mobiles</label>
                    <ul class="todo-list">
                        <li v-for="mobile in mobiles">
                            <i class="fa fa-fw fa-mobile"></i>
                            {{mobile}}
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

const phones = [ '+34679525437', '+34650192821', '+349770640' ]
const mobiles = [ '+34679525437', '+34679525123', '+34674525443' ]

import LoggedUserEmailsForm from './LoggedUserEmailsFormComponent.vue'

export default {
  name: 'LoggedUserContactsForm',
  components: { LoggedUserEmailsForm },
  data () {
    return {
      phones: phones,
      mobiles: mobiles
    }
  }
}
</script>

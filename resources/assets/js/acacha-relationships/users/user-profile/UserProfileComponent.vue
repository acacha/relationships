<template>
    <div>
        <div class="row">
            <div class="col-md-3">
                <user-profile-info-box></user-profile-info-box>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#user" data-toggle="tab" aria-expanded="false">User</a></li>
                        <li><a href="#personal" data-toggle="tab" aria-expanded="false">Personal</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="user">
                            <logged-user-name-form></logged-user-name-form>
                            <hr>
                            <logged-user-email-form></logged-user-email-form>
                            <hr>
                            <logged-user-password-form></logged-user-password-form>
                        </div>
                        <div class="tab-pane" id="personal">
                            <logged-user-personal-data-form></logged-user-personal-data-form>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <logged-user-identifiers-form></logged-user-identifiers-form>
                                </div>
                                <div class="col-md-8">
                                    <logged-user-addresses-form></logged-user-addresses-form>
                                </div>
                            </div>
                            <hr>
                            <logged-user-contacts-form></logged-user-contacts-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <adminlte-flash-message></adminlte-flash-message>
    </div>
</template>

<script>
  import {
    UserProfileInfoBox,
    UserProfileStoreComponent,
    LoggedUserNameForm,
    LoggedUserEmailForm,
    LoggedUserPasswordForm } from 'acacha-users'
  import { AdminlteFlashMessageComponent } from 'adminlte-vue'
  import LoggedUserPersonalDataForm from '../../personal-data/LoggedUserPersonalDataFormComponent'
  import LoggedUserIdentifiersForm from '../../personal-data/LoggedUserIdentifiersFormComponent'
  import LoggedUserAddressesForm from '../../personal-data/LoggedUserAddressesFormComponent'
  import LoggedUserContactsForm from '../../personal-data/LoggedUserContactsFormComponent.vue'

  import { mapGetters } from 'vuex'

  export default {
    extends: UserProfileStoreComponent,
    name: 'UserProfile',
    components: {
      UserProfileInfoBox,
      LoggedUserNameForm,
      LoggedUserEmailForm,
      LoggedUserPasswordForm,
      LoggedUserPersonalDataForm,
      LoggedUserIdentifiersForm,
      LoggedUserAddressesForm,
      LoggedUserContactsForm,
      AdminlteFlashMessageComponent
    },
    computed: {
      ...mapGetters({
        user: 'acacha-users/user'
      })
    },
    created () {
      this.$store.dispatch('acacha-users/getUser', true)
    }
  }
</script>
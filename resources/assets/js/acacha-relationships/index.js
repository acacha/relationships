import AdminlteVue from 'adminlte-vue'
import Vue from 'vue'
import { config } from './config/relationships'
import PersonProfilePhotoComponent from './profile-photo/PersonProfilePhotoComponent.vue'
import PersonProfilePhotoFormComponent from './personal-data/PersonProfilePhotoFormComponent.vue'
import PersonalDataSubFormComponent from './personal-data/PersonalDataSubFormComponent.vue'
import PersonalDataFormComponent from './personal-data/PersonalDataFormComponent.vue'
import FormDebugInfoComponent from './personal-data/acacha-forms/FormDebugInfoComponent.vue'
import AdminlteInputGenderComponent from './personal-data/adminlte/relationships/AdminlteInputGenderComponent.vue'
import AdminlteInputFullnamesComponent from './personal-data/adminlte/relationships/AdminlteInputFullnamesComponent.vue'
import AdminlteInputIdentifiersComponent from './personal-data/adminlte/relationships/AdminlteInputIdentifiersComponent.vue'

// Register components
Vue.component('person-profile-photo', PersonProfilePhotoComponent)
Vue.component('person-profile-photo-form', PersonProfilePhotoFormComponent)
Vue.component('personal-data-subform', PersonalDataSubFormComponent)
Vue.component('personal-data-form', PersonalDataFormComponent)
Vue.component('form-debug-info', FormDebugInfoComponent)

// Adminlte
Vue.component('adminlte-input-gender', AdminlteInputGenderComponent)
Vue.component('adminlte-input-fullnames', AdminlteInputFullnamesComponent)
Vue.component('adminlte-input-identifiers', AdminlteInputIdentifiersComponent)

Vue.use(AdminlteVue)

window.acacha_relationships = {}
window.acacha_relationships.config = config

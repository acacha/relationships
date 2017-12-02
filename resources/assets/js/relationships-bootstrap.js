// Vuex
import Vuex from 'vuex'

Vue.use(Vuex)

// Register components
Vue.component('person-profile-photo', require('./profile-photo/PersonProfilePhotoComponent.vue'));
Vue.component('person-profile-photo-form', require('./personal-data/PersonProfilePhotoFormComponent.vue'));
Vue.component('personal-data-subform', require('./personal-data/PersonalDataSubFormComponent.vue'));
Vue.component('personal-data-form', require('./personal-data/PersonalDataFormComponent.vue'));
Vue.component('form-debug-info', require('./personal-data/acacha-forms/FormDebubgInfoComponent.vue'));

//Adminlte
Vue.component('adminlte-input-text',        require('./personal-data/adminlte/AdminlteInputTextComponent.vue'));
Vue.component('adminlte-input-date-mask',   require('./personal-data/adminlte/AdminlteInputDateMaskComponent.vue'));
Vue.component('adminlte-input-location',    require('./personal-data/adminlte/AdminlteInputLocationComponent.vue'));
Vue.component('adminlte-input-gender',      require('./personal-data/adminlte/relationships/AdminlteInputGenderComponent.vue'));
Vue.component('adminlte-input-fullnames',   require('./personal-data/adminlte/relationships/AdminlteInputFullnamesComponent.vue'));
Vue.component('adminlte-input-identifiers', require('./personal-data/adminlte/relationships/AdminlteInputIdentifiersComponent.vue'));

Vue.component('adminlte-input-identifiers', require('./personal-data/adminlte/relationships/AdminlteInputIdentifiersComponent.vue'));

import { config } from './config/relationships'

window.acacha_relationships = {}
window.acacha_relationships.config = config
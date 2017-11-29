// Vuex
import Vuex from 'vuex'

Vue.use(Vuex)

// Register components
Vue.component('person-profile-photo', require('./profile-photo/PersonProfilePhotoComponent.vue'));
// Vue.component('personal-data-form', require('./personal-data/PersonalDataFormComponent.vue'));
Vue.component('personal-data-subform', require('./personal-data/PersonalDataSubFormComponent.vue'));
// Vue.component('identifier-input', require('./personal-data/IdentifierInputComponent.vue'));
// Vue.component('identifier-select', require('./personal-data/IdentifierSelectComponent.vue'));
// Vue.component('fullname-select', require('./personal-data/FullnameSelectComponent.vue'));
//
// Vue.component('adminlte-input-date-mask', require('./personal-data/AdminlteInputDateMask.vue'));
// Vue.component('adminlte-input-gender', require('./personal-data/AdminlteInputGender.vue'));
// Vue.component('adminlte-input-location', require('./personal-data/AdminlteInputLocation.vue'));

//Adminlte
Vue.component('adminlte-input-text',        require('./personal-data/adminlte/AdminlteInputTextComponent.vue'));
Vue.component('adminlte-input-gender',      require('./personal-data/adminlte/AdminlteInputGenderComponent.vue'));
Vue.component('adminlte-input-date-mask',   require('./personal-data/adminlte/AdminlteInputDateMaskComponent.vue'));
Vue.component('adminlte-input-location',    require('./personal-data/adminlte/AdminlteInputLocationComponent.vue'));
Vue.component('adminlte-input-fullnames',   require('./personal-data/adminlte/AdminlteInputFullnamesComponent.vue'));
Vue.component('adminlte-input-identifiers', require('./personal-data/adminlte/AdminlteInputIdentifiersComponent.vue'));

import { config } from './config/relationships'

window.acacha_relationships = {}
window.acacha_relationships.config = config
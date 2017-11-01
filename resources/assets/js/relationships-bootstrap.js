// Register components
Vue.component('person-profile-photo', require('./profile-photo/PersonProfilePhotoComponent.vue'));
Vue.component('personal-data-form', require('./personal-data/PersonalDataFormComponent.vue'));
Vue.component('personal-data-subform', require('./personal-data/PersonalDataSubFormComponent.vue'));
Vue.component('identifier-input', require('./personal-data/IdentifierInputComponent.vue'));
Vue.component('identifier-select', require('./personal-data/IdentifierSelectComponent.vue'));
Vue.component('fullname-select', require('./personal-data/FullnameSelectComponent.vue'));

Vue.component('adminlte-input-date-mask', require('./personal-data/AdminlteInputDateMask.vue'));
Vue.component('adminlte-input-gender', require('./personal-data/AdminlteInputGender.vue'));
Vue.component('adminlte-input-location', require('./personal-data/AdminlteInputLocation.vue'));

import { config } from './config/relationships'

window.acacha_relationships = {}
window.acacha_relationships.config = config
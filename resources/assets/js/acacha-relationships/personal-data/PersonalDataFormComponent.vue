<template>
    <div id="personal_data">

        <form-debug-info></form-debug-info>

        <personal-data-subform></personal-data-subform>

        <div class="row">
            <div class="col-md-3">
                <person-profile-photo-form></person-profile-photo-form>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Adreces</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="Adress">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" style="width: 100%;">
                                            <option selected="selected">C/</option>
                                            <option>Avd/</option>
                                            <option>Rambla</option>
                                            <option>Todo</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="number">Number</label>
                                    <input type="text" class="form-control" id="number" placeholder="Num">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="floor">Floor</label>
                                    <input type="text" class="form-control" id="floor" placeholder="Floor">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="door">Door</label>
                                    <input type="text" class="form-control" id="door" placeholder="Door">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="postalcode">Postal Code</label>
                                    <input type="text" class="form-control" id="postalcode" placeholder="Code">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" id="location" placeholder="Location">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success pull-right">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Contactes</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" id="mobile" placeholder="Mobile">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Save</button>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Extra info</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea rows="4" cols="50" class="form-control" id="notes">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aliquid amet aperiam autem cum dolorem excepturi, exercitationem facilis in labore minus modi nihil quod repellendus, saepe sequi temporibus veritatis voluptatum.</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Save</button>
            </div>
        </div>
    </div>
</template>

<script>

  import formStore from './acacha-forms/vuex/store'
  import Form from './acacha-forms/vuex/Form'

  import PersonalDataSubForm from './PersonalDataSubFormComponent.vue'
  import PersonalProfilePhotoForm from './PersonProfilePhotoFormComponent.vue'

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
    store,
    components: {PersonalDataSubForm, PersonalProfilePhotoForm}
  }
</script>

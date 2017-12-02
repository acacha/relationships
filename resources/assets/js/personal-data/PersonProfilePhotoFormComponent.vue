<template>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">User Photo</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <person-profile-photo :id="person_id" :logged-user="false"></person-profile-photo>
        </div>
    </div>
</template>

<style>

</style>

<script>
  import ProfilePhoto from '../profile-photo/PersonProfilePhotoComponent.vue'

  export default {
    name: 'PersonProfilePhotoForm',
    components: {ProfilePhoto},
    computed: {
      person_id() {
        return this.$store.state.form_resource_id
      }
    }
  }
</script>

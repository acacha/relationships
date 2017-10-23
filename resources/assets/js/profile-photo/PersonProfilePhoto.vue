<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <img ref='photoImage' class="profile-user-img img-responsive img-circle"
                     :src="photoPath" alt="User photo" @click="upload" @error="errorOnPhoto" >
            </div>
            <div class="col-md-12">
                <div class="btn-toolbar btn-block" role="toolbar">
                    <form role="form" class="form" onsubmit="return false;">
                        <div class="btn-group input-block-level">
                            <button class="btn btn-primary image-upload upload-button" :disabled="isSaving" @click="upload">
                                <label for="file-input">
                                    <b>
                                        <i class="fa fa-refresh fa-spin fa-lg" v-if="isSaving || isRemoving"></i>
                                        <i class="fa fa-check text-green fa-lg" v-if="isSuccess || isSuccessRemoving"></i>
                                        <i class="fa fa-close text-red fa-lg" v-if="isFailed"></i>
                                        <template v-if="isInitial">Upload</template>
                                        <template v-if="isSaving">Uploading</template>
                                        <template v-if="isSuccess">Uploaded</template>
                                        <template v-if="isSuccessRemoving">Removed</template>
                                        <template v-if="isFailed || isLoadingFailed">Error</template>
                                        <template v-if="isRemoving">Removing</template>
                                        <template v-if="isFailedRemoving">Error</template>
                                        <template v-if="isLoadingPhotos">Loading</template>
                                    </b>
                                </label>
                                <input type="file" name="file" id="file-input" ref="photo" accept="image/*" :disabled="isSaving"
                                       @change="photoChange"/>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger btn-large dropdown-toggle dropdown-button" data-toggle="dropdown" :disabled="isRemoving || isInitialError">
                                    <label for="todo">
                                        <b><span class="caret"></span></b>
                                    </label>
                                    <input type="hidden" name="dummy" id="todo"/>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="#" @click="remove">Remove</a></li>
                                    <li><a href="#" @click="manage" data-toggle="modal" data-target="#manage-photos-modal">Manage photos</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <div class="modal fade" role="document" id="manage-photos-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Manage photos</h4>
                        </div>
                        <div class="modal-body">
                            <ul class="users-list clearfix" v-if="!isLoadingPhotos">
                                <li v-for="(photo,index) in photos">
                                    <img ref='photoUpdateImage' :src="'/photos/' + photo.id" alt="User Image" @dblclick="update(index)">
                                    <form role="form" class="form" onsubmit="return false;">
                                        <input type="file" name="file" ref="photoUpdate" accept="image/*"
                                               @change="photoUpdateChange( photo, index, $event)" style="display: none;">
                                    </form>

                                    <i class="fa fa-check text-green fa-lg" v-if="index === 0"></i><span v-if="index === 0">Main</span><span v-else>Old</span>
                                    <a class="users-list-name" href="#" :title="photo.path">{{ photo.origin }}</a>
                                    <span class="users-list-date" title="Updated at">{{ photo.updated_at }}</span>
                                    <span class="users-list-date" title="Created at">{{ photo.created_at }}</span>

                                    <i class="fa fa-refresh fa-spin fa-lg" v-if="photoBeingRemoved === photo.id"></i>
                                    <span v-if="photoBeingConfirmed === photo.id">
                                        Sure? <i class="fa fa-check green" @click="removePhoto(photo, index)"></i> <i class="fa fa-remove red" @click="photoBeingConfirmed = null;" ></i>
                                    </span>
                                    <i class="fa fa-remove fa-lg red" @click="confirmRemovePhoto(photo)" v-if="photoBeingConfirmed != photo.id && photoBeingRemoved != photo.id"></i>

                                </li>
                            </ul>
                            <div v-else><i class="fa fa-refresh fa-spin fa-lg"></i> Loading photos...</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
</template>

<style>

    .image-upload > input
    {
        display: none;
    }
    .input-block-level {
        display: inline;
        width: 100%;
    }
    .upload-button {
        display: inline;
        width: calc(100% - 70px);
        min-width: 70px;
    }
    .dropdown-button  {
        display: inline;
        min-width: 70px;
    }
    .red {
        color: red;
    }
    .green {
        color: green;
    }
</style>

<script>

  import defaultMalePhoto from './assets/defaultmale.png'
  import defaultFemalePhoto from './assets/defaultfemale.png'
  import {fetchLoggedUser} from '../mixins/fetchLoggedUser'
  import { wait, checkImage } from '../utils'

  const STATUS_INITIAL = 0, STATUS_INITIAL_ERROR = 1, STATUS_SAVING = 2, STATUS_SUCCESS = 3, STATUS_FAILED = 4,
    STATUS_REMOVING = 5, STATUS_REMOVE_FAILED = 6, STATUS_REMOVING_SUCCESS = 7, STATUS_LOADING_PHOTOS = 8,
    STATUS_LOADING_FAILED = 9;

    export default {
    mixins: [
      fetchLoggedUser
    ],
    data() {
      return {
        user: null,
        personId: null,
        photoPath: defaultMalePhoto,
        currentStatus: null,
        photos: [],
        photoBeingRemoved: null,
        photoBeingConfirmed: null
      }
    },
    props: {
      gender: {
        validator: function (value) {
          return ['male','female'].includes(value)
        },
        default: 'male'
      },
      id: {
        type: Number,
        default: null
      },
      userId: {
        type: Number,
        default: null
      }
    },
    computed: {
      isInitial() {
        return this.currentStatus === STATUS_INITIAL || this.currentStatus === STATUS_INITIAL_ERROR
      },
      isInitialError() {
        return this.currentStatus === STATUS_INITIAL_ERROR
      },
      isSaving() {
        return this.currentStatus === STATUS_SAVING
      },
      isRemoving() {
        return this.currentStatus === STATUS_REMOVING
      },
      isSuccess() {
        return this.currentStatus === STATUS_SUCCESS
      },
      isSuccessRemoving() {
        return this.currentStatus === STATUS_REMOVING_SUCCESS
      },
      isFailed() {
        return this.currentStatus === STATUS_FAILED
      },
      isFailedRemoving() {
        return this.currentStatus === STATUS_REMOVE_FAILED
      },
      isLoadingPhotos() {
        return this.currentStatus === STATUS_LOADING_PHOTOS
      },
      isLoadingFailed() {
        return this.currentStatus === STATUS_LOADING_FAILED
      }
    },
    watch: {
      personId(newPersonId) {
        this.updatePhotoUrl(newPersonId)
      }
    },
    mounted() {
      this.reset()
      this.showDefaultPhoto()
      this.setPersonIdValue()
    },
    methods: {
      updatePhotoUrl(personId) {
        this.photoPath = '/person/' + personId + '/photo?timestamp=' + new Date().getTime()
        if (this.currentStatus === STATUS_INITIAL_ERROR) this.currentStatus === STATUS_INITIAL
      },
      showDefaultPhoto() {
        this.gender === 'female' ? this.photoPath = defaultFemalePhoto : this.photoPath = defaultMalePhoto
      },
      errorOnPhoto() {
        this.currentStatus = STATUS_INITIAL_ERROR
        this.showDefaultPhoto()
      },
      setPersonIdValue() {
        if ( ! this.personId ) {
          var component = this
          this.fetchLoggedUser().then(function (response) {
            let user = response.data
            component.user = user.id
            if (user.person) {
              component.personId = user.person.id
            }
          }).catch(function (error) {
            console.log(error);
          });
        }
      },
      upload() {
        this.$refs.photo.click()
      },
      update(index) {
        this.$refs.photoUpdate[index].click()
      },
      photoUpdateChange(photo, index, event) {
        var target = event.target || event.srcElement;
        if (target.value.length != 0) {
          //Preview it
          this.previewOnManagePhotos(index)

          // handle input photo changes
          const formData = new FormData()
          formData.append('file', this.$refs.photoUpdate[index].files[0])

          // save it
          this.saveUpdate(photo,formData)
        }
      },
      photoChange(event) {
        var target = event.target || event.srcElement;
        if (target.value.length != 0) {
          // handle input photo changes
          const formData = new FormData()
          formData.append('file', this.$refs.photo.files[0])

          //Preview it
          this.preview()

          // save it
          this.save(formData)
        }
      },
      preview() {
        if (this.$refs.photo.files && this.$refs.photo.files[0]) {
          var reader = new FileReader();
          var component = this
          reader.onload = function (e) {
            component.$refs.photoImage.setAttribute('src', e.target.result);
          }

          reader.readAsDataURL(this.$refs.photo.files[0]);
        }
      },
      previewOnManagePhotos(index) {
        if (this.$refs.photoUpdate[index].files && this.$refs.photoUpdate[index].files[0]) {
          var reader = new FileReader();
          var component = this
          reader.onload = function (e) {
            component.$refs.photoUpdateImage[index].setAttribute('src', e.target.result);
          }
          reader.readAsDataURL(this.$refs.photoUpdate[index].files[0]);
        }
      },
      updatePhotoStateFromJsonResponse(photo, jsonResponse) {
        let photoToUpdate = this.photos[this.photos.indexOf(photo)]
        photoToUpdate.path = jsonResponse.path
        photoToUpdate.origin = jsonResponse.origin
        photoToUpdate.storage = jsonResponse.storage
        photoToUpdate.updated_at = jsonResponse.updated_at
      },
      saveUpdate(photo, formData) {
        this.currentStatus = STATUS_SAVING
        let updatePhotoURL = '/api/v1/photos/' + photo.id

        var component = this
        var config = {
          onUploadProgress: function(progressEvent) {
            var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
          }
        }
        axios.post(updatePhotoURL, formData, config)
          .then(function (res) {
            component.currentStatus = STATUS_SUCCESS
            //Update vue component state
            component.updatePhotoStateFromJsonResponse(photo, res.data)
          })
          .catch(function (error) {
            console.log(error)
            component.currentStatus = STATUS_FAILED
          })
      },
      save(formData) {
        this.currentStatus = STATUS_SAVING
        let uploadPhotoURL = '/api/v1/user/' + this.user + '/photo'
        if ( this.personId ) uploadPhotoURL = '/api/v1/person/' + this.personId + '/photo'

        var component = this
        var config = {
          onUploadProgress: function(progressEvent) {
            var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
          }
        }

        axios.post(uploadPhotoURL, formData, config)
          .then(function (res) {
            component.currentStatus = STATUS_SUCCESS
            // If person_id is null update after succesfully adding a photo
            component.personId = res.data.person_id
          })
          .catch(function (error) {
            console.log(error)
            component.currentStatus = STATUS_FAILED
          })
      },
      reset() {
        this.personId = this.id
        this.user = this.userId
        this.currentStatus = STATUS_INITIAL
        this.uploadError = null
      },
      remove() {
        this.currentStatus = STATUS_REMOVING
        let deletePhotoURL = '/api/v1/user/' + this.user + '/photo'
        if ( this.personId ) deletePhotoURL = '/api/v1/person/' + this.personId + '/photo'
        let component = this
        axios.delete(deletePhotoURL)
          .then(function (res) {
            component.currentStatus = STATUS_REMOVING_SUCCESS
            component.updatePhotoUrl(component.personId)
          })
          .catch(function (error) {
            console.log(error)
            component.currentStatus = STATUS_REMOVE_FAILED
          })
      },
      manage() {
        this.currentStatus = STATUS_LOADING_PHOTOS
        let showPhotosURL = '/api/v1/user/' + this.user + '/photos'
        if ( this.personId ) showPhotosURL = '/api/v1/person/' + this.personId + '/photos'
        let component = this
        axios.get(showPhotosURL)
          .then(function (res) {
              component.photos = res.data
              component.currentStatus = STATUS_INITIAL
            }).catch(
          function (error) {
            console.log(error)
            component.currentStatus = STATUS_LOADING_FAILED
          }
        ).then()
      },
      confirmRemovePhoto(photo) {
        this.photoBeingConfirmed = photo.id
      },
      removePhoto(photo, index) {
        this.photoBeingRemoved = photo.id
        this.photoBeingConfirmed = null
        let removePhotoURL = '/api/v1/photos/' + photo.id
        let component = this
        axios.delete(removePhotoURL)
          .then(function (res) {
          component.photos.splice(component.photos.indexOf(photo), 1)
          component.currentStatus = STATUS_INITIAL
            if (index === 0 ) component.updatePhotoUrl(component.personId)
        }).catch(
          function (error) {
            console.log(error)
            component.currentStatus = STATUS_REMOVING_FAILED
          }
        ).then(function() {
          component.photoBeingRemoved = null
        })
      },
    }
  }
</script>

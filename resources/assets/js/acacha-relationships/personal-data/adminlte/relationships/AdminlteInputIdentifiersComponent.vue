<template>
    <div class="form-group has-feedback" :class="{ 'has-error': internalForm.errors.has(name) }">
        <transition name="fade">
            <label key="error" class="help-block" v-if="internalForm.errors.has(name)" v-text="internalForm.errors.get(name)"></label>
            <slot name="label" v-else>
                <label key="regular" :for="id">{{placeholder}}</label>
            </slot>
        </transition>
        <div class="input-group">
            <div class="input-group-btn">
                <button id="identifierType" type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                    {{ identifierTypeName }}
                    <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                    <li v-for="identifierType in identifierTypes" @click="updateIdentifierType(identifierType)"><a href="#">{{ identifierType.name }}</a></li>
                </ul>
            </div>
            <multiselect
                    id="identifier"
                    placeholder="Select identifier"
                    :taggable="true"
                    @tag="addIdentifier"
                    tag-placeholder="Add this as new identifier"
                    :value="identifier"
                    @select="updateIdentifier"
                    track-by="id"
                    :options="identifiers"
                    :custom-label="customLabel"
                    :loading="loading"
                    >
            </multiselect>
        </div>

    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
  import Multiselect from 'vue-multiselect'
  import axios from 'axios'
  import FetchPerson from './FetchPerson'
  import FetchPersonUpdateForm from './FetchPersonUpdateForm'
  import UpdateForm from './UpdateForm'
  import { FormComponent } from 'acacha-adminlte-vue-forms'

  export default {
    name: 'AdminlteInputIdentifiersComponent',
    components: {Multiselect},
    mixins: [ FormComponent, FetchPerson, FetchPersonUpdateForm, UpdateForm ],
    data () {
      return {
        loading: false,
        identifiers: [],
        identifierTypes: []
      }
    },
    computed: {
      identifierTypeName () {
        return this.identifier_type ? this.identifier_type.name : ''
      },
      identifier () {
        return this.identifierObject()
      },
      identifier_type () {
        return this.identifierTypeObject()
      }
    },
    methods: {
      identifierObject () {
        return this.identifiers.find((identifier) => {
          return identifier.id == this.$store.state['acacha-forms'].form.identifier_id // eslint-disable-line
        })
      },
      identifierTypeObject () {
        return this.identifierTypes.find((identifierType) => {
          return identifierType.id == this.$store.state['acacha-forms'].form.identifier_type // eslint-disable-line
        })
      },
      customLabel ({ value, type_name }) { // eslint-disable-line
        return `${value} - ${type_name}`   // eslint-disable-line
      },
      updateIdentifier (identifier) {
        if (identifier) {
          this.$store.dispatch('acacha-forms/clearErrorsAction', this.name)
          if (identifier.id !== -1) { // -1 New identifier -> no person associated -> avoid search
            this.fetchPersonAndUpdateForm(identifier.person_id)
          }
        }
      },
      addIdentifier (newIdentifier) {
        const identifier = {
          id: -1,
          person_id: -1,
          type_id: this.identifier_type.id,
          type_name: this.identifier_type.name,
          value: newIdentifier
        }
        if (this.identifiers[0].id === -1) {
          this.identifiers.shift()
        }
        this.identifiers.splice(0, 0, identifier)
        this.$store.dispatch('acacha-forms/updateFormFieldAction', {
          field: 'identifier',
          value: newIdentifier
        })
        this.$store.dispatch('acacha-forms/updateFormFieldAction', {
          field: 'identifier_id',
          value: -1
        })
        this.$store.dispatch('acacha-forms/clearErrorsAction', this.name)
        this.$emit('tag', identifier)
      },
      updateIdentifierType (identifierType) {
        let id = identifierType ? identifierType.id : ''
        this.$store.dispatch('acacha-forms/updateFormFieldAction', {
          field: 'identifier_type',
          value: id
        })
      },
      fetchIdentifiers () {
        let url = '/api/v1/identifier'
        axios.get(url).then((response) => {
          this.identifiers = response.data
        }).catch((error) => {
          console.log(error)
        })
      },
      fetchIdentifierTypes () {
        let url = '/api/v1/identifierType'
        this.loading = true
        axios.get(url).then((response) => {
          this.identifierTypes = response.data
          this.setDefaultSelectedIdentifierType()
        }).catch((error) => {
          console.log(error)
        }).then(() => {
          this.loading = false
        })
      },
      setDefaultSelectedIdentifierType () {
        if (this.selected) {
          this.identifierType = this.identifierTypes.find((identifierType) => {
            return identifierType.name === this.selected
          })
          if (this.identifierType !== undefined) return
        }
        this.identifierType = this.identifierTypes[0]
      }
    },
    props: {
      name: {
        type: String,
        default: 'identifier'
      }
    },
    mounted () {
      this.fetchIdentifierTypes()
      this.fetchIdentifiers()
    }
  }
</script>

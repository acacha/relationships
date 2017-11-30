<template>
    <div class="form-group">
        <label for="identifier">Identifier</label>
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
                    :loading="loading">
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

  export default {
    name: 'AdminlteInputIdentifiersComponent',
    components: {Multiselect},
    mixins: [ FetchPerson, FetchPersonUpdateForm, UpdateForm ],
    data () {
      return {
        loading: false,
        identifiers: [],
        identifierTypes: [],
      }
    },
    computed: {
      identifierTypeName() {
        return this.identifier_type ? this.identifier_type.name : ''
      },
      identifier() {
        return this.identifierObject()
      },
      identifier_type() {
        return this.identifierTypeObject()
      }
    },
    methods: {
      identifierObject() {
        return this.identifiers.find((identifier) => {
          return identifier.id == this.$store.state.form.identifier_id
        })
      },
      identifierTypeObject() {
        return this.identifierTypes.find((identifierType) => {
          return identifierType.id == this.$store.state.form.identifier_type
        })
      },
      customLabel({ value, type_name}) {
        return `${value} - ${type_name}`
      },
      updateIdentifier(identifier) {
        if (identifier) {
          if (identifier.id !== -1) // -1 New identifier -> no person associated -> avoid search
            this.fetchPersonAndUpdateForm(identifier.person_id)
        }
      },
      addIdentifier(newIdentifier) {
        const identifier = {
          id : -1,
          person_id: -1,
          type_id: this.identifier_type.id,
          type_name: this.identifier_type.name,
          value: newIdentifier
        }
        if ( this.identifiers[0].id === -1 ){
          this.identifiers.shift()
        }
        this.identifiers.splice(0,0,identifier)
        this.$store.dispatch('updateFormFieldAction', {
          field : 'identifier',
          value : newIdentifier
        })
        this.$store.dispatch('updateFormFieldAction', {
          field : 'identifier_id',
          value : -1
        })
        this.$emit('tag', identifier)
      },
      updateIdentifierType(identifierType) {
        let id = identifierType ? identifierType.id : ''
        this.$store.dispatch('updateFormFieldAction', {
          field : 'identifier_type',
          value : id
        });

      },
      fetchIdentifiers() {
        let url = '/api/v1/identifier'
        axios.get(url).then((response) => {
          this.identifiers = response.data
        }).catch((error) => {
          console.log(error)
        })
      },
      fetchIdentifierTypes() {
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
      setDefaultSelectedIdentifierType() {
        if ( this.selected ) {
          this.identifierType = this.identifierTypes.find((identifierType) => {
            return identifierType.name === this.selected
          })
        if (this.identifierType !== undefined) return
        }
        this.identifierType = this.identifierTypes[0];
      }
    },
    mounted() {
      this.fetchIdentifierTypes()
      this.fetchIdentifiers()
    }
  }
</script>

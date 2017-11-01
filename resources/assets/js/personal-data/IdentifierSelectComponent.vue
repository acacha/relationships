<!-- Vue component -->
<template>
    <div class="form-group">
        <label for="identifier">Identifier</label>
        <div class="input-group">
            <div class="input-group-btn">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                    {{ identifierTypeName }}
                    <span class="fa fa-caret-down"></span></button>
                <ul class="dropdown-menu">
                    <li v-for="identifierType in identifierTypes" @click="selectIdentifierType(identifierType)"><a href="#">{{ identifierType.name }}</a></li>
                </ul>
            </div>
            <multiselect id="identifier" v-model="value" :options="identifiers" label="value" :custom-label="customLabel"
                         :taggable="true" @tag="addIdentifier" @select="identifierHasBeenSelected"
                         placeholder="Select identifier"
                         tag-placeholder="Add this as new identifier"
                         :disabled="disabled" :loading="loading"></multiselect>
        </div>
    </div>
</template>

<script>
  import Multiselect from 'vue-multiselect'

  export default {
    components: { Multiselect },
    data () {
      return {
        value: null,
        loading: false,
        identifiers: [],
        identifierType : null,
        identifierTypes: []
      }
    },
    computed: {
      identifierTypeName: function () {
        return this.identifierType ? this.identifierType.name : ''
      }
    },
    props: {
      selected: {
        type: String,
        required: false
      },
      disabled: {
        type: Boolean,
        default: false
      },
      identifier: {
        default: null
      },
      type: {
        default: null
      }
    },
    watch: {
      identifier: function(newVal, oldVal) {
        this.updateIdentifier(newVal)
      },
      type: function(newVal,oldVal) {
        this.updateIdentifierType(newVal)
      }
    },
    methods: {
      updateIdentifier(id) {
        this.value = this.findIdentifierById(id)
        this.updateIdentifierType(this.value.type_id)
      },
      findIdentifierById(id){
        return this.identifiers.find((identifierType) => {
          return identifierType.id === id
        })
      },
      updateIdentifierType(id) {
        this.identifierType = this.findIdentifierType(id)
      },
      findIdentifierType(id) {
        return this.identifierTypes.find((identifierType) => {
          return identifierType.id === id
        })
      },
      identifierHasBeenSelected(identifier) {
        this.identifierType = identifier.type
        this.$emit('selected',identifier)
      },
      customLabel({ value, type_name}) {
        return `${value} - ${type_name}`
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
      selectIdentifierType(identifierType) {
        this.identifierType = identifierType
        if (this.value) {
          this.value.type = identifierType
          this.value.type_id = identifierType.id
          this.value.type_name = identifierType.name

          let id = this.identifiers.find((identifier) => {
            return identifier.id === this.value.id
          })

          id.type = identifierType
          id.type_id = identifierType.id
          id.type_name = identifierType.name
        }
      },
      fetchIdentifiers() {
        let url = '/api/v1/identifier'
        axios.get(url).then((response) => {
          this.identifiers = response.data
        }).catch((error) => {
          console.log(error)
        })
      },
      addIdentifier(newIdentifier) {
        const identifier = {
          value: newIdentifier,
          type_id: this.identifierType.id,
          type: this.identifierType,
          type_name: this.identifierType.name
        }
        this.identifiers.push(identifier)
        this.value = identifier
        this.$emit('tag', identifier)
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

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

</style>
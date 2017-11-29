import changeCase from 'change-case'

let getTitleCaseName = function () {
  return changeCase.titleCase(this.name)
}

export default {
  data: function () {
    return {
      internalForm: this.form || this.$store.state.form
    }
  },
  methods: {
    updateFormField(value,field) {
      field = field || this.name;
      this.$store.dispatch('updateFormFieldAction', {
        field : field,
        value : value
      });
    },
  },
  props: {
    name: {
      type: String,
      required: true
    },
    form: {
      type: Object,
      required: false
    },
    id: {
      type: String,
      default: function() {
        return this.name
      }
    },
    placeholder: {
      type: String,
      default: getTitleCaseName
    },
  }
}
export default {
  methods: {
    updateForm(person) {
      const fields = [
        {
          field: 'identifier',
          value: person['identifier-value']
        },
        {
          field: 'identifier_id',
          value: person.identifier_id
        },
        {
          field: 'identifier_type',
          value: person['identifier-type']
        },
        {
          field: 'givenName',
          value: person.givenName || ''
        },
        {
          field: 'surname1',
          value: person.surname1 || ''
        },
        {
          field: 'surname2',
          value: person.surname2 || ''
        },
        {
          field: 'birthdate',
          value: person.birthdate
        },
        {
          field: 'birthplace_id',
          value: person.birthplace_id
        },
        {
          field: 'gender',
          value: person.gender || ''
        }
      ]
      this.$store.dispatch('updateFormAction', fields)
    }
  }
}
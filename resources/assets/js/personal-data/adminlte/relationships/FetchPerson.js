export default {
  methods: {
    fetchPerson(personId) {
      let url = '/api/v1/person/' + personId
      return axios.get(url)
    }
  }
}
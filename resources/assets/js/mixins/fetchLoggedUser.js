export const fetchLoggedUser = {
  methods: {
    fetchLoggedUser() {
      return axios.get('/api/user_relationships')
    },
  }
}

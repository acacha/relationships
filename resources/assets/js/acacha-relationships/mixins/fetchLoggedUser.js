const RELATIONSHIPS_USER_URI = '/api/v1/relationships/user'

export const fetchLoggedUser = {
  methods: {
    fetchLoggedUser() {
      return axios.get(RELATIONSHIPS_USER_URI)
    },
  }
}

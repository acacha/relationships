import axios from 'axios'

const getLoggedUserPerson = () => {
  return axios.get('/api/v1/user/person')
}

export {
  getLoggedUserPerson
}

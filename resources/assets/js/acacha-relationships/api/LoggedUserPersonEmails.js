import axios from 'axios'

const fetchLoggedUserPersonEmails = () => {
  return axios.get('/api/v1/user/person/emails')
}

const addLoggedUserPersonEmail = (fields) => {
  return axios.post('/api/v1/user/person/email', fields)
}

const removeLoggedUserPersonEmail = (id) => {
  return axios.delete('/api/v1/user/person/email/' + id)
}

const updateLoggedUserPersonEmail = (email) => {
  return axios.put('/api/v1/user/person/email/' + email.id, { email: email.value.trim() })
}

export {
  fetchLoggedUserPersonEmails,
  addLoggedUserPersonEmail,
  removeLoggedUserPersonEmail,
  updateLoggedUserPersonEmail
}

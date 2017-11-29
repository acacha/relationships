import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default function(form) {

  const initialForm = form

  return new Vuex.Store({
      state: {
        form: form,
      },
      mutations: {
        updateForm: function (state, {field, value}) {
          Object.assign(state.form, {
            [field]: value
          });
        },
        startProcessing (state) {
          state.form.startProcessing()
        },
        onSuccess (state) {
          state.form.onSuccess()
        },
        onFail (state, error) {
          state.form.onFail(error)
        },
        clear (state) {
          state.form = initialForm
        },
      },
      actions: {
        post(context, payload) {
          return context.dispatch('submit',{
            requestType: 'post',
            url: payload
          })
        },
        submit(context, payload) {
          context.commit('startProcessing')

          return new Promise((resolve, reject) => {
            context.state.form.configureAxios()
            axios[payload.requestType](payload.url, context.state.form.data())
              .then(response => {
                context.commit('onSuccess')
                resolve(response)
              })
              .catch(error => {
                context.commit('onFail', error)
                reject(error)
              })
          })
        }
      },
      strict: debug
    })
}
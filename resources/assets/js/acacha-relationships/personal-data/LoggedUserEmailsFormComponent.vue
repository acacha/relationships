<template>
    <div>
        <label>Emails</label>

        <ul class="todo-list">
            <li>
                <form method="post" @submit.prevent="add()">
                    <div class="input-group input-group-sm">
                        <input type="email" id="newEmail" name="email" placeholder="Add an email here..." v-model="newEmail"
                               class="form-control" @keyup.enter.prevent="add()">
                        <span class="input-group-btn">
                      <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-fw fa-plus"></i></button>
                    </span>
                    </div>
                </form>
            </li>
            <li v-for="email in emails" :key="email.id" :class="{ editing: email.id == editing }">
                <div class="view">
                    <i class="fa fa-fw fa-envelope"></i>
                    <span @dblclick="initEdit(email)">
                    {{email.value}}
                </span>
                    <div class="tools">
                        <i class="fa fa-edit green" @click="initEdit(email)" ></i>
                        <i class="fa fa-trash-o" @click="confirmRemove(email.id)" v-if="!(confirmingRemove === email.id)"></i>
                        <template v-else>
                            <i class="fa fa-check green" @click="remove(email)" v-if="!(removing  === email.id)"></i><i class="fa fa-refresh fa-spin" v-else></i> <i class="fa fa-remove red" @click="cancelConfirmRemove()" ></i>
                        </template>
                    </div>
                </div>
                <input v-focus type="email" id="editEmail" name="email" v-model="email.value"
                       class="form-control edit" @keyup.enter="edit(email)" @keyup.esc="cancelEdit(email)">
            </li>
        </ul>
    </div>
</template>

<style>
    .red {
        color: #dd4b39;
    }
    .green {
        color: #196c4b;
    }

    .todo-list li .edit {
        display: none;
    }

    .todo-list li.editing .view {
        display: none;
    }

    .todo-list li.editing .edit {
        display: block;
    }
</style>

<script>

import {
  fetchLoggedUserPersonEmails,
  addLoggedUserPersonEmail,
  updateLoggedUserPersonEmail,
  removeLoggedUserPersonEmail } from '../api/LoggedUserPersonEmails'
import { FlashMixin } from 'adminlte-vue'

export default {
  name: 'LoggedUserEmailsForm',
  mixins: [FlashMixin],
  data () {
    return {
      emails: [],
      removing: null,
      confirmingRemove: null,
      editing: null,
      submittingEdit: false,
      newEmail: '',
      beforeEditCache: ''
    }
  },
  methods: {
    add () {
      if (this.newEmail) {
        addLoggedUserPersonEmail({ email: this.newEmail.trim() }).then(response => {
          this.emails.push({ id: response.data.id, value: this.newEmail })
          this.newEmail = ''
        }).catch(error => {
          if (error.response.status === 422) {
            if (error.response.data.errors) {
              this.flash(error.response.data.errors.email[0], error.response.data.message, 'danger', 'ban')
            } else {
              this.flash(error.response.data.message, 'Oooppssss something went wrong!', 'danger', 'ban')
            }
            return
          }
          this.flash('' + error, 'Oooppssss something went wrong!', 'danger', 'ban')
        })
      }
    },
    initEdit (email) {
      this.beforeEditCache = email.value
      this.editing = email.id
    },
    cancelEdit: function (email) {
      this.editing = null
      email.value = this.beforeEditCache
    },
    edit (email) {
      if (this.beforeEditCache === email.value) {
        this.editing = null
        return
      }
      this.submittingEdit = true
      updateLoggedUserPersonEmail(email).then(response => {
        this.submittingEdit = false
        this.editing = null
      }).catch(error => {
        console.log(error)
        this.flash('' + error, 'Oooppssss something went wrong!', 'danger', 'ban')
      })
    },
    confirmRemove (id) {
      this.confirmingRemove = id
    },
    cancelConfirmRemove () {
      this.confirmingRemove = null
    },
    remove (email) {
      this.removing = email.id
      removeLoggedUserPersonEmail(email.id).then(response => {
        this.emails.splice(this.emails.indexOf(email), 1)
        this.confirmingRemove = null
        this.removing = null
      }).catch(error => {
        console.log(error)
        this.flash('' + error, 'Oooppssss something went wrong!', 'danger', 'ban')
      })
    }
  },
  directives: {
    'focus': function (el) {
      el.focus()
    }
  },
  created () {
    fetchLoggedUserPersonEmails().then(response => {
      this.emails = response.data
    }).catch(error => {
      console.log(error)
    })
  }
}
</script>

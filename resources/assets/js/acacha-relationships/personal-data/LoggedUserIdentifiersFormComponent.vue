<template>
    <div>
        <div class="form-group has-feedback" >
           <label>Identifiers</label>
            <ul class="todo-list">
                <li v-for="identifier in identifiers">
                    <i class="fa fa-fw fa-child" style="color:red;"></i>
                    {{identifier.type}} | {{identifier.value}}
                    <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

const identifiers = [
  {
    id: 1,
    type: 'NIF',
    value: '14268002K'
  },
  {
    id: 2,
    type: 'NIF',
    value: '47623636C'
  },
  {
    id: 3,
    type: 'Passport',
    value: 'AS231312A'
  }
]

export default {
  name: 'LoggedUserIdentifiersForm',
  data () {
    return {
      identifiers
    }
  }
}
</script>

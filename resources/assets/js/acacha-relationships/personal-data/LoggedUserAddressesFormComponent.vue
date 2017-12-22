<template>
    <div>
        <div class="form-group has-feedback" >
           <label>Addresses</label>
            <ul class="todo-list">
                <li v-for="address in addresses">
                    <i class="fa fa-fw fa-home"></i>
                    {{address.fullname}}
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

const mockedAddresses = [
  {
    id: 1,
    name: '',
    fullname: 'Alcanyiz 26 4t 2a 43500 TORTOSA TARRAGONA CATALUNYA',
    type: '',
    number: '',
    floor: '',
    floor_number: '',
    location: '',
    province_id: '',
    country_code: ''
  },
  {
    id: 2,
    name: '',
    fullname: 'Parellades 76 3t 2a 53400 SITGES BARCELONA CATALUNYA',
    type: '',
    number: '',
    floor: '',
    floor_number: '',
    location: '',
    province_id: '',
    country_code: ''
  }
]

export default {
  name: 'LoggedUserAddressesForm',
  data () {
    return {
      addresses: mockedAddresses
    }
  }
}
</script>

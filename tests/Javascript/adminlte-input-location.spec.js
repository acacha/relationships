import { TransitionGroupStub, TransitionStub, shallow } from 'vue-test-utils'

import expect from 'expect'
import AdminlteInputLocation from '../../../relationships/resources/assets/js/personal-data/AdminlteInputLocation.vue'
import moxios from 'moxios'

describe('AdminlteInputLocation', () => {
  let component

  const locations = [
    {
      id: 1,
      name: 'TORTOSA',
      postalcode: 43500
    },
    {
      id: 2,
      name: 'Aldea',
      postalcode: 43896
    }
  ]

  beforeEach(() => {
    moxios.install()
    component = shallow(AdminlteInputLocation)
  })

  afterEach(() => {
    moxios.uninstall()
  })

  it('contains default label', () => {
    expect(component.html()).toContain('Location')
  })

  it('label can be setted', () => {
    const component = shallow(AdminlteInputLocation, {
      slots: {
        label: '<div>Birth place</div>'
      }
    })

    expect(component.html()).toContain('Birth place')
  })

  it('locations are set ok', done => {
    component.setProps({ location: 1 })

    moxios.stubRequest('/api/v1/location', {
      status: 200,
      response: locations
    });

    moxios.wait(() => {
      expect(component.vm.locations).toBe(locations)
      expect(component.vm.internalLocation).toBe(locations[0])

      done();
    });
  })

})
import { shallow } from 'vue-test-utils'
import expect from 'expect'
import IdentifierSelect from '../../../relationships/resources/assets/js/personal-data/IdentifierSelectComponent.vue'
import moxios from 'moxios'
import axios from 'axios'

describe('IdentifierSelect', () => {

  let component

  const PASSPORT = {
    id: 2,
    name: 'Passport',
  }

  const identifierTypes = [
    PASSPORT,
    {
      id: 2,
      name: 'Passport',
    },
    {
      id: 3,
      name: 'NIE',
    }
  ]

  const identifiers = [
    {
      id: 1,
      value: '56531534H',
      type_id: 1,
      type_name: 'NIF',
      person_id: 1
    },
    {
      id: 2,
      value: 'Z7493495P',
      type_id: 3,
      type_name: 'NIE',
      person_id: 2
    },
    {
      id: 3,
      value: 'YU3581707',
      type_id: 2,
      type_name: 'Passport',
      person_id: 3
    },
  ]

  beforeEach(() => {
    moxios.install(axios)
    component = shallow(IdentifierSelect)

  })

  afterEach(() => {
    moxios.uninstall(axios)
  })

  it('contains default label', () => {
    expect(component.html()).toContain('Identifier')
  })

  it('label can be setted', () => {
    const component = shallow(IdentifierSelect, {
      slots: {
        label: '<div>Cool id</div>'
      }
    })

    expect(component.html()).toContain('Cool id')
  })

  it('identifier types are set ok', done => {
    // component.setProps({ location: 1 })

    moxios.stubRequest('/api/v1/identifierType', {
      status: 200,
      response: identifierTypes
    });

    moxios.wait(() => {
      expect(component.vm.identifierTypes).toBe(identifierTypes)
      expect(component.vm.identifierType).toBe(identifierTypes[0])
      expect(component.vm.identifierTypeName).toBe(identifierTypes[0].name)
      see(identifierTypes[0].name,'button#identifierType')
      done();
    });
  })

  it('identifier types are set ok with selected', done => {
    component.setProps({ selected: 'Passport' })

    moxios.stubRequest('/api/v1/identifierType', {
      status: 200,
      response: identifierTypes
    });

    moxios.wait(() => {
      expect(component.vm.identifierTypes).toBe(identifierTypes)
      expect(component.vm.identifierType).toBe(identifierTypes[1])
      see(identifierTypes[1].name,'button#identifierType')
      done();
    });
  })

  it('identifiers are set ok', done => {
    // component.setProps({ location: 1 })

    moxios.stubRequest('/api/v1/identifier', {
      status: 200,
      response: identifiers
    });

    moxios.wait(() => {
      expect(component.vm.identifiers).toBe(identifiers)
      done();
    });
  })

  it('identifier types are changed ok', () => {
    component.vm.selectIdentifierType(PASSPORT)
    expect(component.vm.identifierType).toBe(PASSPORT)
  })

// Helper Functions

  let see = (text, selector) => {
    let wrap = selector ? component.find(selector) : component;

    expect(wrap.html()).toContain(text);
  };

  let type = (text, selector) => {
    let node = component.find(selector);

    node.element.value = text;
    node.trigger('input');
  };

  let click = selector => {
    component.find(selector).trigger('click');
  };

})
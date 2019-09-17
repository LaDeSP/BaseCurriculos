import Vue from 'vue'
import { extend } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';
import { ValidationProvider } from 'vee-validate';
import { ValidationObserver } from 'vee-validate';

extend('required', {
  ...required,
  message: 'This field is required'
});
extend('email', {...email, message: 'Email válido please'} );
extend('secret', {
  validate: value => value === 'example',
  message: 'This is not the magic word'
});
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
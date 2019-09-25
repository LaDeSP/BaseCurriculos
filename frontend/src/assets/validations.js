import Vue from 'vue'
import { extend } from 'vee-validate';
import { required, email, numeric, digits, max, min } from 'vee-validate/dist/rules';
import { ValidationProvider } from 'vee-validate';
import { ValidationObserver } from 'vee-validate';
import { localize } from 'vee-validate';

extend('required', {...required});
extend('email', {...email} );
extend('numeric', {...numeric} );
extend('digits', {...digits} );
extend('max', {...max} );
extend('min', {...min} );

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

localize('pt_BR', {
    messages: {
      required: 'Esse campo é obrigatório.',
      email: 'Digite email válido.',
      numeric: 'Digite apenas números.',
      min: 'Digite {length} caracteres.',
      max: 'Digite no máximo {length} caracteres.'
    }
  });
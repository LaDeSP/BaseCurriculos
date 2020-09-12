import Vue from 'vue'
import { extend } from 'vee-validate';
import { required, email, numeric, digits, max, min, min_value, max_value, integer, regex, required_if, confirmed } from 'vee-validate/dist/rules';
import { ValidationProvider } from 'vee-validate';
import { ValidationObserver } from 'vee-validate';
import { localize } from 'vee-validate';

extend('required', {...required});
extend('email', {...email} );
extend('numeric', {...numeric} );
extend('digits', {...digits} );
extend('max', {...max} );
extend('min', {...min} );
extend('min_value', {...min_value} );
extend('max_value', {...max_value} );
extend('integer', {...integer} );
extend('regex', {...regex} );
extend('required_if', {...required_if} );
extend('confirmed', {...confirmed} );


Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

localize('pt_BR', {
    messages: {
      required: 'Esse campo é obrigatório.',
      email: 'Digite um email válido.',
      numeric: 'Digite apenas números.',
      min: 'Digite {length} caracteres.',
      max: 'Digite no máximo {length} caracteres.',
      digits: 'O {_field_} precisa de {length} caracteres.',
      min_value: 'O valor mínimo é {min}.',
      integer: 'O valor não pode ser fracionário.',
      max_value: 'O valor máximo é {max}.',
      regex: 'Valor inválido.',
      required_if: 'Esse campo é obrigatório.',
      confirmed: 'Confirmação se difere da senha.'
    }
  });
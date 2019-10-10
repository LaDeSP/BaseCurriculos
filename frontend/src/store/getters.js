const isLoggedIn = state => !!state.auth.token;
const authStatus = state => state.auth.status;

const pessoaFisica = state => {

}

const pessoaJuridica = state => {

}

export default {
  isLoggedIn,
  authStatus,
  pessoaFisica,
  pessoaJuridica
};
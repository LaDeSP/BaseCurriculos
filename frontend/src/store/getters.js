const isLoggedIn = state => !!state.auth.token;
const authStatus = state => state.auth.status;

const pessoaFisica = state => {

}

const pessoaJuridica = state => {

}

const permissaoDoUsuario = state =>{
  return state.auth.user.role
}
export default {
  isLoggedIn,
  authStatus,
  pessoaFisica,
  pessoaJuridica,
  permissaoDoUsuario
};
const auth_success = (state, {authData}) => {
    state.auth.status = 'success'
    state.auth.token = authData.token
    state.auth.user = authData.user
    
    console.log('auth_usccess', authData.user)
  };
const auth_error = (state) => {
    state.status = 'error'
  };
const logout = (state) => {
    state.status = ''
    state.token = ''
  };
  
  export default {
    auth_success,
    auth_error,
    logout
  };
const auth_success = (state, {payload}) => {
    state.auth.status = 'success'
    state.auth.token = payload.token
    state.auth.user = payload.user
    
    console.log('auth_usccess', payload.token)
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
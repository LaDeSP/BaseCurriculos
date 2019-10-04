const isLoggedIn = state => !!state.auth.token;
const authStatus = state => state.auth.status;

export default {
  isLoggedIn,
  authStatus
};
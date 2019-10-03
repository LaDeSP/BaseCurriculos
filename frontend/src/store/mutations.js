const PROP1_UPDATED = (state, payload) => {
    state.someObj.prop1 = payload;
  };
  
  const PROP2_UPDATED = (state, payload) => {
    state.someObj.prop2 = payload;
  };
  
  export default {
    PROP1_UPDATED,
    PROP2_UPDATED,
  };
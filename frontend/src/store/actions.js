const actionOne = (context) => {
    context.commit('PROP1_UPDATED', payload);
  };
  
  const actionTwo = (context) => {
    context.commit('PROP2_UPDATED', payload);
  };
  
  export default {
    actionOne,
    actionTwo,
  };
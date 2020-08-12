export default class Utils{
    persistData(payload){
      // NOTA: Não salvei como objeto com JSON.stringfy pois o encript não seria feito dessa forma.
      localStorage.setItem('usr', payload.user.name) //username
      localStorage.setItem('usid', payload.user.id) //user id
      localStorage.setItem('@', payload.user.email) //email
      localStorage.setItem('lvl', payload.user.role) //auth level role
      localStorage.setItem('sDel', payload.user.deleted_at) //softDeleted
    }
}
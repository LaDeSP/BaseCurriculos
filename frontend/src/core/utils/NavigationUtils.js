export default class NavigationUtils {
    constructor(router){
      this.router = router
    }

    goToHome(){
      this.router.push({path: '/'})
    }

    goToError(error){
      console.log('aki', error)
      this.router.push({path: '/error', query: {error}})
    }
    
}
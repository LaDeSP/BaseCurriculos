export default class NavigationUtils {
    constructor(router){
        this.router = router
    }

    goToHome(){
        this.router.push({path: '/'})
    }
    
}
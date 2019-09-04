<template>

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
              <router-link to="/" class="navbar-brand">Estágio</router-link>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ">
                  <router-link class="nav-item nav-link" to="/login">Login</router-link>
                </div>
              </div>
              <!--  <div v-if="isLogged == true">-->
              <form class="navbar-nav form-inline my-2 my-lg-0">
                <router-link class="nav-item nav-link" to="/logout">Logout</router-link> 
              </form>
              <!--  </div> -->
            </nav>

</template>
<script>
    module.exports = {
        data(){
            return {
                isLogged: ''
            }
        },
        created(){
          const isLogged = localStorage.getItem('isLogged');
          
         
         // this.isLogged = isLogged
        }
    }
</script>

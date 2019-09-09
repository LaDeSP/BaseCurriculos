<template>

</template>

<script>
  //  import store from '../store'
    export default {
        mounted () {
            //remove token
            localStorage.removeItem('token')
            //seta isLoggedIn pra falso
           // store.commit('logoutUser')
            //redireciona pro login
            this.$router.push({ name: 'login' })
        }
    }
</script>
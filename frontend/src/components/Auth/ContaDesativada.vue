<template>
  <div>
    <h1>Sua conta se encontra desativada no momento. Deseja reativar ela?</h1>
    <button @click="activate" class="btn btn-lg btn-success">Reativar Conta</button>
    <button @click="logout" class="btn btn-lg btn-danger">Sair</button>
  </div>
</template>

<script>

    export default {
        methods:{
        activate(){
            this.$store.dispatch('activateAccount')
            .then(() => {
                this.$router.push('/dashboard')
            })
        },
        logout(){       
            this.$store.dispatch('logout')
            .then(() => {
                this.$router.push('/')
            })
        }  
        },
    }
</script>

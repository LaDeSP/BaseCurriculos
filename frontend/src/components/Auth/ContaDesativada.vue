<template>
  <div class="container">
      <div class="card">
        <div class="card-body">
          <h3>Sua conta se encontra desativada no momento.</h3>
          <h3>Deseja reativá-la?</h3>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-6">
              <div class="d-flex flex-row-reverse"><button @click="activate" class="btn btn-lg btn-success">Reativar Conta</button></div>
            </div>
            <div class="col-6">
              <div class="d-flex flex-row"><button @click="logout" class="btn btn-lg btn-danger">Sair</button></div>
            </div>
          </div>
        </div>
      </div>
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

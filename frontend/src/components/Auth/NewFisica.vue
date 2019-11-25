<template>
<div class="col-lg-12">
  <div class="container-fluid fix-form-modal">
  <div class="row  justify-content-center">
      <ValidationObserver v-slot="{ invalid }">
        <form>
          <div v-if="notificacoes">
            <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                {{notificacao[0]}}
            </span>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label for="name" >Nome Completo <a class="color-red">*</a></label>
              <ValidationProvider name="name" rules="required|max:250">
                  <div slot-scope="{ errors }">
                    <input type="text" name="name" class="form-control" v-model="name" maxlength="250" required='autofocus'>
                    <p class="color-red">{{ errors[0] }}</p>
                  </div>
              </ValidationProvider>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="form-group">
              <label for="cpf">CPF <a class="color-red">*</a></label>
              <ValidationProvider name="cpf" rules="required|numeric|digits:11">
                  <div slot-scope="{ errors }">
                    <input type="text" class="form-control" name="cpf" v-model="cpf" maxlength="11" minlength="11" required='autofocus'>
                    <p class="color-red">{{ errors[0] }}</p>
                  </div>
              </ValidationProvider>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="form-group">
                  <label for="email">Email <a class="color-red">*</a></label>
                <ValidationProvider name="email" rules="required|email|max:250">
                    <div slot-scope="{ errors }">
                      <input type="email" name="email" class="form-control" v-model="email" maxlength="250" required='autofocus'>
                      <p class="color-red">{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="form-group">
              <span for="password">Senha <a class="color-red">*</a></span>
              <ValidationProvider name="password" rules="required|min:8|max:30">
                <div slot-scope="{ errors }">
                  <input type="password" id="password" name="password" class="form-control" v-model="password" maxlength="30" minlength="8">
                  <p class="color-red">{{ errors[0] }}</p>
                </div>
              </ValidationProvider>
            </div>
          </div>
          <hr>
          <button :disabled="invalid" v-on:keyup.enter="register" @click.prevent="register" type="submit" class="btn btn-success btn-lg">Cadastrar</button>
            <!-- <router-link to="/login" class="btn btn-default">Voltar</router-link> -->
        </form>
      </ValidationObserver>
    </div>
  </div>
</div>


</template>

<script>

    export default {

        data(){
            return{

                name:'',
                email: '',
                cpf: '',
                password: '',
                role: 'FISICA',
                notificacoes: [],


            }
        },
        methods: {

            register(){
              let newFisicaData = {
                name: this.name,
                email: this.email,
                cpf: this.cpf,
                password: this.password,
                role: this.role
              }

              this.$store.dispatch('newFisica', newFisicaData)
              .then( response => { 
                if(response.error  != undefined){
                  this.notificacoes = response.error;
                }
                else{
                  this.$router.push({ name: 'dashboard-fisica', params:{cadastrou: true} })
                }
              
              })
              .catch(error => console.log(error))

            }
        },
    }
</script>

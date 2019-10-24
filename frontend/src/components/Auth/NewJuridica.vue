<template>
<div class="col-lg-12">
  <div class="container-fluid fix-form-modal">
    <div class="row justify-content-center">
        <ValidationObserver v-slot="{ invalid }">
            <form>
              <div v-if="notificacoes">
                  <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                      {{notificacao[0]}}
                  </span>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="name">Nome <a class="color-red">*</a></label>
                  <ValidationProvider name="name" rules="required|max:50">
                      <div slot-scope="{ errors }">
                        <input type="text" name="name" class="form-control" v-model="name" maxlength="50" required='autofocus'>
                        <p class="color-red">{{ errors[0] }}</p>
                      </div>
                  </ValidationProvider>
                  </div>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                    <label for="cnpj">CNPJ <a class="color-red">*</a></label>
                    <ValidationProvider name="cnpj" rules="required|numeric|digits:14">
                        <div slot-scope="{ errors }">
                           <input type="text" class="form-control" name="cnpj" v-model="cnpj" maxlength="14" minlength="14" required='autofocus'>
                            <p class="color-red">{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>
                </div>
              </div>

                <div class="col-sm-12">
                  <div class="form-group">
                    <label  for="ramo">Ramo <a class="color-red">*</a></label>
                    <ValidationProvider name="ramo" rules="required|max:50">
                          <div slot-scope="{ errors }">
                            <input type="ramo" name="ramo" class="form-control" v-model="ramo" maxlength="50" required='autofocus'>
                            <p class="color-red">{{ errors[0] }}</p>
                          </div>
                      </ValidationProvider>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="email">Email <a class="color-red">*</a></label>
                    <ValidationProvider name="email" rules="required|email|max:50">
                      <div slot-scope="{ errors }">
                        <input type="email" name="email" class="form-control" v-model="email" maxlength="50" required='autofocus'>
                        <p class="color-red">{{ errors[0] }}</p>
                      </div>
                    </ValidationProvider>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="password">Senha <a class="color-red">*</a></label>
                    <ValidationProvider name="password" rules="required|min:8|max:30">
                      <div slot-scope="{ errors }">
                        <input type="password" name="password" class="form-control" v-model="password" minlength="8" maxlength="30" required='autofocus'>
                        <p class="color-red">{{ errors[0] }}</p>
                      </div>
                    </ValidationProvider>
                  </div>
                </div>
                <hr>
                <button :disabled="invalid" v-on:keyup.enter="register" @click.prevent="register" type="submit" class="btn btn-success btn-lg">Cadastrar</button>
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
                password: '',
                ramo: '',
                cnpj: '',
                role: 'JURIDICA',
                notificacoes: []


            }
        },
        methods: {

             register(){
              let newJuridicaData = {
                name: this.name,
                email: this.email,
                cnpj: this.cnpj,
                password: this.password,
                ramo: this.ramo,
                role: this.role
              }

              this.$store.dispatch('newJuridica', newJuridicaData)
               .then( response => { 
                if(response.error  != undefined){
                  this.notificacoes = response.error;
                }
                else{
                  this.$router.push({ name: 'dashboard-juridica' })
                }juridica
              
              })
              .catch(error => console.log(error))
              
            }
        },
    }
</script>

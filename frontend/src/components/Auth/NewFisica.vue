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
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" for="name">Nome Completo *</span>
                </div>
                <ValidationProvider name="name" rules="required|max:50">
                  <input type="text" name="name" class="form-control" v-model="name" maxlength="50" required='autofocus'>
                    <!-- <div slot-scope="{ errors }"><p>{{ errors[0] }}</p></div> -->
                </ValidationProvider>
              </div>
            </div>
          </div>

          <br>
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" for="cpf">CPF *</span>
                </div>
                <ValidationProvider name="cpf" rules="required|numeric|digits:11">
                  <input type="text" class="form-control" name="cpf" v-model="cpf" maxlength="11" minlength="11" required='autofocus'>
                    <!-- <div slot-scope="{ errors }"><p>{{ errors[0] }}</p></div> -->
                </ValidationProvider>
              </div>
            </div>
          </div>
          <br>
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" for="email">Email *</span>
                </div>
                <ValidationProvider name="email" rules="required|email|max:50">
                  <input type="email" name="email" class="form-control" v-model="email" maxlength="50" required='autofocus'>
                    <!-- <div slot-scope="{ errors }"><p>{{ errors[0] }}</p></div> -->
                </ValidationProvider>
              </div>
            </div>
          </div>
          <br>
          <div class="col-sm-12">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" for="password">Senha *</span>
                </div>
                <ValidationProvider name="password" rules="required|min:8|max:30">
                  <input type="password" id="password" name="password" class="form-control" v-model="password" maxlength="30" minlength="8">
                    <!-- <div slot-scope="{ errors }"><p>{{ errors[0] }}</p></div> -->
                </ValidationProvider>
              </div>
            </div>
          </div>
          <br>
          <br>
          <hr>
          <button :disabled="invalid" @click.prevent="register" type="submit" class="btn btn-success btn-lg">Cadastrar</button>
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
                password: '',
                cpf: '',
                role: 'FISICA',
                notificacoes: [],


            }
        },
        methods: {

            register(){

                this.axios.post('http://localhost:8000/api/pfisicas',

                    {

                        email: this.email,
                        password: this.password,
                        name: this.name,
                        cpf: this.cpf,
                        role: this.role
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => {
                            if(response.data.error  != undefined){
                                this.notificacoes = response.data.error;
                                return;
                            }
                            this.$session.start(),
                            this.$session.set('jwt', response.data.token),
                            this.$session.set('name', response.data.name),
                            this.$session.set('role', response.data.role),
                            this.$session.set('user_id', response.data.user_id)
                            this.$router.push({ name: 'dashboard-fisica' })
                        }
                    )
                    .catch(
                        (error) => console.log(error)
                    );
            }
        },
    }
</script>

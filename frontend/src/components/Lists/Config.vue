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
              <span for="newPassword">Nova Senha</span>
              <ValidationProvider name="newPassword" rules="min:8|max:30">
                <div slot-scope="{ errors }">
                  <input type="password" id="newPassword" name="newPassword" class="form-control" v-model="newPassword" maxlength="30" minlength="8">
                  <p class="color-red">{{ errors[0] }}</p>
                </div>
              </ValidationProvider>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="form-group">
              <span for="password">Senha</span>
              <ValidationProvider name="password" rules="required_if:newPassword|min:8|max:30">
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
                email: this.$store.state.auth.user.email,
                cpf: this.$store.state.pessoaFisica.cpf,
                password: '',
                cnpj: this.$store.state.pessoaJuridica.cnpj,
                role: this.$store.state.auth.user.role,
                newPassword: '',
                notificacoes: [],


            }
        }
    }
</script>

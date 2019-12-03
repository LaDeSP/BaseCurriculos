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

          <div class="col-sm-12" v-if="role=='FISICA'">
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

          <div class="col-sm-12" v-if="role=='JURIDICA'">
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
              <span for="newPassword">Nova Senha</span>
              <ValidationProvider name="newPassword" rules="min:8|max:30" vid="newPassword">
                <div slot-scope="{ errors }">
                  <input type="password" id="newPassword" name="newPassword" class="form-control" v-model="newPassword" maxlength="30" minlength="8">
                  <small>Só precisa ser preenchido se for trocar de senha. Não é obrigatório.</small>
                  <p class="color-red">{{ errors[0] }}</p>
                </div>
              </ValidationProvider>
            </div>
          </div>

          <div class="col-sm-12" v-if="newPassword != ''" ><!--isso tava no a -->
            <div class="form-group">
              <span for="password">Senha Atual <a class="color-red">*</a></span>
              <ValidationProvider name="password" rules="required|min:8|max:30"><!--required_if aqui se eele tiver direto sem aquele v-if-->
                <div slot-scope="{ errors }">
                  <input type="password" id="password" name="password" class="form-control" :disabled="newPassword==''" v-model="password" maxlength="30" minlength="8">
                  <!--<small>Só precisa ser preenchido quando há uma nova senha. Não é obrigatório em outros casos. Não causa efeito nenhum se preenchido sem nova senha.</small>-->
                  <p class="color-red">{{ errors[0] }}</p>
                </div>
              </ValidationProvider>
            </div>
          </div>


          <hr>
          <div class="d-flex justify-content-center">
            <button :disabled="invalid" v-on:keyup.enter="register" @click.prevent="update" type="submit" class="btn btn-success btn-lg">Atualizar</button>
          </div>

        </form>
      </ValidationObserver>
      <Modal v-if="isModalSuccess" @close="closeModal">
        <template v-slot:header></template>
        <template v-slot:body>
              <b-alert show variant="success">
                <h1>Dados atualizados com sucesso!</h1>
            </b-alert>
        </template>
      </Modal>
    </div>
  </div>
</div>


</template>

<script>
  import {mapActions} from 'vuex';
  import Modal from '../Utils/ModalOld';
  import { BAlert } from 'bootstrap-vue';

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
        isModalSuccess: false,

      }
    },
    components:{
      Modal, BAlert
    },

    methods: {
      update(){
        if(this.role=='FISICA'){
          let attUserFisica = {
            email: this.email,
            cpf: this.cpf,
            password: this.password,
            newPassword: this.newPassword
          }

          this.$store.dispatch('updateUserFisica', attUserFisica)
          .then( response => { 
            if(response.error  != undefined){
              this.notificacoes = response.error;
            }
            else{
              this.isModalSuccess = true;
              this.notificacoes = [];
              this.password = '';
              this.newPassword = '';
            }
          
          })
          .catch(error => console.log(error))
        }
        else if(this.role=='JURIDICA'){
          let attUserJuridica = {
            email: this.email,
            cnpj: this.cnpj,
            password: this.password,
            newPassword: this.newPassword
          }

          this.$store.dispatch('updateUserJuridica', attUserJuridica)
          .then( response => { 
            if(response.error  != undefined){
              this.notificacoes = response.error;
            }
            else{
              this.isModalSuccess = true;
              this.notificacoes = [];
              this.password = '';
              this.newPassword = '';
            }
          
          })
          .catch(error => console.log(error))
        }

      },
      ...mapActions([
        'loadFisica', 'loadJuridica' 
      ]),
      closeModal(){
        this.isModalSuccess = false;
      },

    },
    created() {
      this.loadFisica();
      this.loadJuridica();
    }

  }
</script>

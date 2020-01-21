<template>
  <span v-if="isFetching">
    <br><br><br>
    <div class="container">
      <center>
        <h1>Carregando...<span class="fas fa-spinner fa-pulse"></span></h1>
      </center>
    </div>
  </span>
  <span v-else>
    <div class="col-lg-12" >
      <div class="row justify-content-center mb-3">
        <div v-if="this.dataCompleted">
          <card>
            <template v-slot:card-header>
              <div class="row justify-content-center">
                <div div class="col-md-12">
                  <div class="btn-group">
                    <router-link to="/dashboard" class="btn btn-outline-secondary btn-md btn-block"><i class="fas fa-home"></i> Home</router-link>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-center">
                <img class="quadrado icon-profile" :src=path>
              </div>
            </template>
            <template v-slot:card-body>
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <h4><strong>Informações da Empresa</strong></h4>
                  <ul>
                    <li> <strong>Nome da Empresa</strong>: {{displayPessoaJuridica.razao}}</li>
                    <li> <strong>CNPJ</strong>: {{displayPessoaJuridica.cnpj}}</li>
                    <li> <strong>Rua</strong>: {{displayPessoaJuridica.rua}}</li>
                    <li v-if="typeof displayPessoaJuridica.numero !== 'undefined' || null"><strong>Número</strong>:{{displayPessoaJuridica.numero}}</li>
                    <li v-if="typeof displayPessoaJuridica.complemento !== 'undefined' || null"><strong>Complemento</strong>:{{displayPessoaJuridica.complemento}}</li>
                    <li> <strong>Bairro</strong>: {{displayPessoaJuridica.bairro}}</li>
                    <li> <strong>Cidade</strong>: {{displayPessoaJuridica.cidade}}</li>
                    <li> <strong>CEP</strong>: {{displayPessoaJuridica.cep}}</li>

                    <li> <strong>Telefone Fixo</strong>: {{displayPessoaJuridica.fixo}}</li>
                    <li> <strong>Telefone Celular</strong>: {{displayPessoaJuridica.celular}}</li>
                  </ul>
                  <h4><strong>Redes Sociais</strong></h4>
                  <ul>
                    <li v-if="typeof displayPessoaJuridica.facebook !== 'undefined' || null">Facebook: {{displayPessoaJuridica.facebook}}</li>
                    <li v-if="typeof displayPessoaJuridica.twitter !== 'undefined' || null">Twitter: {{displayPessoaJuridica.twitter}}</li>
                    <li v-if="typeof displayPessoaJuridica.linkedin !== 'undefined' || null">Linkedin: {{displayPessoaJuridica.linkedin}}</li>
                    <li v-if="typeof displayPessoaJuridica.site !== 'undefined' || null">Site: {{displayPessoaJuridica.site}}</li>
                  </ul>
                </div>
              </div>
            </template>
            <template v-slot:card-footer>
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-sm-6 d-flex justify-content-center" >
                      <router-link to="/add-juridica" class="btn btn-md btn-warning">Editar Informações</router-link>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-center" >
                      <button @click="showModal" class="btn btn-md btn-danger">Desativar Conta</button>
                      <Modal v-show="isModalWarning" @close="closeModal">
                        <template v-slot:header>
                          <h3>Desativar Conta</h3>
                        </template>
                        <template v-slot:body>
                          <h2 class="text-center">Tem certeza de que deseja<span style="color: #ff0000"><strong> desativar</strong></span> sua conta?</h2>
                          <h4 class="text-center">Sentiremos sua falta :(</h4>
                        </template>
                        <template v-slot:footer>
                          <button @click="deactivate" class="btn btn-lg btn-danger">Desativar Conta</button>
                          <button @click="closeModal" class="btn btn-lg btn-secondary">Voltar</button>
                        </template>
                      </Modal>
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </card>
        </div>
        <div v-else>
          <h4>Você ainda não completou suas informações... Que tal fazer isso agora?</h4>
          <NewJuridicaData></NewJuridicaData>
        </div>
      </div>
    </div>
  </span>
</template>

<script>
  import {mapActions, mapGetters, mapState} from 'vuex';
  import Modal from '../Utils/Modal.vue';
  import NewJuridicaData from '../Create/NewJuridicaData.vue';
  import painel from '../Utils/Painel';
  import card from '../Utils/Card';

  export default {
    data() {
      return {
        isModalWarning: false,
        path:this.$store.state.upload.path,
      }
    },

    components: {NewJuridicaData, Modal,painel,card},

    methods: {
      ...mapActions([
        'loadJuridica'
      ]),

      showModal(){
        this.isModalWarning = true;
      },

      closeModal(){
        this.isModalWarning = false;
      },

      deactivate(){
        this.$store.dispatch('deactivateAccount')
        .then(response => {
            this.$router.push({ name: 'login' })
        }).catch(error => console.log(error))
      }
    },

    computed: {
      ...mapGetters([
        'dataCompleted', 'displayPessoaJuridica'
      ]),

      ...mapState(['isFetching']),
    },

    async created(){
      if(this.dataCompleted){
        await this.loadJuridica();
      }
    },

    watch: {
      async displayPessoaFisica() {
          await this.loadJuridica();
      }
    }
  }
</script>




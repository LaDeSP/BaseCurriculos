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
        <div v-if="dataCompleted">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#info" role="tab" aria-controls="nav-home" aria-selected="true">Informações Pessoais</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Curriculo</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="info" role="tabpanel">
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
                      <h4>Informações Pessoais</h4>
                      <ul>
                        <li> <strong>Nome Completo</strong>: {{displayPessoaFisica.nome}}</li>
                        <li> <strong>Data de Nascimento</strong>: {{displayPessoaFisica.nascimento | dateFormat}}</li>
                        <li> <strong>Gênero</strong>: {{displayPessoaFisica.genero}}</li>
                        <li> <strong>Estado Civil</strong>: {{displayPessoaFisica.estadoCivil}}</li>
                        <li> <strong>CPF</strong>: {{displayPessoaFisica.cpf}}</li>
                        <li> <strong>Rua</strong>: {{displayPessoaFisica.rua}}</li>
                        <li v-if="typeof displayPessoaFisica.numero !== 'undefined' || null"><strong>Número</strong>: {{displayPessoaFisica.numero}}</li>
                        <li v-if="typeof displayPessoaFisica.complemento !== 'undefined' || null"><strong>Complemento</strong>: {{displayPessoaFisica.complemento}}</li>
                        <li> <strong>Bairro</strong>: {{displayPessoaFisica.bairro}}</li>
                        <li> <strong>Cidade</strong>: {{displayPessoaFisica.cidade}}</li>
                        <li> <strong>CEP</strong>: {{displayPessoaFisica.cep}}</li>
                        <li> <strong>País de Nacionalidade</strong>: {{displayPessoaFisica.cep}}</li>
                        <li> <strong>Telefone Fixo</strong>: {{displayPessoaFisica.fixo}}</li>
                        <li> <strong>Telefone Celular</strong>: {{displayPessoaFisica.celular}}</li>
                      </ul>
                      <h4>Redes Sociais</h4>
                      <ul>
                        <li v-if="typeof displayCurriculo.facebook !== 'undefined' || null">Facebook: {{displayCurriculo.facebook}}</li>
                        <li v-if="typeof displayCurriculo.twitter !== 'undefined' || null">Twitter: {{displayCurriculo.twitter}}</li>
                        <li v-if="typeof displayCurriculo.linkedin !== 'undefined' || null">Linkedin: {{displayCurriculo.linkedin}}</li>
                        <li v-if="typeof displayCurriculo.site !== 'undefined' || null">Site: {{displayCurriculo.site}}</li>
                      </ul>
                    </div>
                  </div>
                </template>
                <template v-slot:card-footer>
                  <div class="row justify-content-center">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-6 d-flex justify-content-start" >
                          <router-link to="/new-curriculo" class="btn btn-md btn-warning">Editar Informações</router-link>
                        </div>
                        <div class="col-6 d-flex justify-content-end" >
                          <button @click="showModal" class="btn btn-md btn-danger">Desativar Conta</button>
                          <Modal v-show="isModalWarning" @close="closeModal">
                            <template v-slot:header>
                              <h3>Desativar Conta</h3>
                            </template>
                            <template v-slot:body>
                              <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>deletar</strong></span> sua conta?</h2>
                              <h4 class="text-center">Sentiremos sua falta :(</h4>
                            </template>
                            <template v-slot:footer>
                              <button @click="deactivate" class="btn btn-md btn-danger">Desativar Conta</button>
                              <button @click="closeModal" class="btn btn-md btn-secondary">Voltar</button>
                            </template>
                          </Modal>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
              </card>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <Curriculo></Curriculo>
            </div>
          </div>
        </div>
        <div v-else>
          <h4>Você ainda não completou suas informações... Que tal fazer isso agora?</h4>
          <NewCurriculo></NewCurriculo>
        </div>
      </div>
    </div>
  </span>
</template>

<script>
  import {mapActions, mapGetters, mapState} from 'vuex';
  import moment from 'moment'
  import Curriculo from './Curriculo.vue';
  import Modal from '../Utils/Modal.vue';
  import NewCurriculo from '../Create/NewCurriculo.vue';
  import card from '../Utils/Card';
  export default {
    data() {
      return {
        isModalWarning: false,
        path:this.$store.state.upload.path,
      }
    },

    components: {
      Curriculo, NewCurriculo, Modal,card
    },

    methods: {
      ...mapActions([
        'loadFisica'
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
        'dataCompleted', 'displayPessoaFisica', 'displayCurriculo'
      ]),

      ...mapState(['isFetching']),
    },

    filters:{
      dateFormat: function(value){
        if (value) {
          return moment(String(value)).format('DD/MM/YYYY')
        }
      }
    },

    async created(){
      if(this.dataCompleted){
        await this.loadFisica();
      }
    },

    watch: {
      async displayPessoaFisica() {
        await this.loadFisica();
      }
    }
  }
</script>

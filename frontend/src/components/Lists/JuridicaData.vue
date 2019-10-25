<template>
<div>

  <div class="row justify-content-center">
    <div div class="col-7">
      <div class="btn-group">
        <router-link to="/dashboard-juridica" class="btn btn-primary btn-lg btn-block"><i class="fas fa-arrow-left"></i>Voltar</router-link>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-7">
      <div v-if="this.dataCompleted">
        <painel>
          <template v-slot:panel-heading>
            <div class="container d-flex justify-content-center">
              <img class="rounded-circle icon-profile" :src=path>
            </div>
          </template>
          <template v-slot:panel-body>
            <h4> <strong>Informações da Empresa</strong></h4>
            <ul>
              <li> <strong>Nome da Empresa</strong>: {{displayPessoaJuridica.razao}}</li>
              <li> <strong>CNPJ</strong>: {{displayPessoaJuridica.cnpj}}</li>
              <li> <strong>Ramo</strong>: {{displayPessoaJuridica.ramo}}</li>
              <li> <strong>Rua</strong>: {{displayPessoaJuridica.rua}}</li>
              <li v-if="typeof displayPessoaJuridica.numero !== 'undefined' || null"><strong>Número</strong>:{{displayPessoaJuridica.numero}}</li>
              <li v-if="typeof displayPessoaJuridica.numero !== 'undefined' || null"><strong>Complemento</strong>:{{displayPessoaJuridica.complemento}}</li>
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
          </template>
          <template v-slot:panel-footer>
            <div class="row">
              <div class="col-md-8 float-left" >
                <router-link to="/add-juridica" class="btn btn-lg btn-warning">Editar Informações</router-link>
              </div>
              <div class="col-md-4 float-right" >
                <button @click="showModal" class="btn btn-lg btn-danger">Deletar Conta</button>
              </div>
            </div>
          </template>
        </painel>
      </div>
      <div v-else>
          <h4>Você ainda não completou suas informações... Que tal fazer isso agora?</h4>
          <NewJuridicaData></NewJuridicaData>
      </div>
      <Modal v-show="isModalWarning" @close="closeModal">
        <template v-slot:header>
          <h3>Deletar Conta</h3>
        </template>
        <template v-slot:body>
          <h2 class="text-center">Tem certeza de que deseja<span style="color: #ff0000"><strong>deletar</strong></span>sua conta?</h2>
          <h4 class="text-center">Sentiremos sua falta :(</h4>
        </template>
        <template v-slot:footer>
          <button @click="onDelete" class="btn btn-lg btn-danger">Sim, quero deletar minha conta</button>
          <button @click="closeModal" class="btn btn-lg btn-success">Vou dar mais uma chance para vocês...</button>
        </template>
      </Modal>
    </div>
  </div>
</div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
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
            onDelete(){
                this.$store.dispatch('deleteJuridica')
                .then(response => {
                   //console.log(response)
                    this.$router.push({ name: 'login' })
                }).catch(error => console.log(error))

            }
        },
        computed: {
            ...mapGetters([
                'dataCompleted', 'displayPessoaJuridica'
            ]),
        },

        async created(){
          if(this.dataCompleted){
            await this.loadJuridica();
          }
            console.log('dataCompleted', this.dataCompleted)
            console.log(this.displayPessoaJuridica)
        },
        watch: {
            async displayPessoaFisica() {
                await this.loadJuridica();
            }
        }
    }
</script>




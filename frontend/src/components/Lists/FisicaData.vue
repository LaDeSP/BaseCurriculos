<template>
  <div class="row justify-content-center">
      <div class="col-md-7">
            <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">

                <div v-if="dataCompleted">
                <h2>Informações Pessoais</h2>
                <ul> 
                    <h4> <strong>Nome Completo</strong>: {{displayPessoaFisica.nome}}</h4>
                    <li> <strong>Data de Nascimento</strong>: {{displayPessoaFisica.nascimento | dateFormat}}</li>
                    <li> <strong>Gênero</strong>: {{displayPessoaFisica.genero}}</li>
                    <li> <strong>Estado Civil</strong>: {{displayPessoaFisica.estadoCivil}}</li>
                    <li> <strong>CPF</strong>: {{displayPessoaFisica.cpf}}</li>
                    <li> <strong>Rua</strong>: {{displayPessoaFisica.rua}}</li>
                    <li v-if="typeof displayPessoaFisica.numero !== 'undefined' || null">Número: {{displayPessoaFisica.numero}}</li>
                    <li v-if="typeof displayPessoaFisica.numero !== 'undefined' || null">Complemento: {{displayPessoaFisica.complemento}}</li>
                    <li> <strong>Bairro</strong>: {{displayPessoaFisica.bairro}}</li>
                    <li> <strong>Cidade</strong>: {{displayPessoaFisica.cidade}}</li>
                    <li> <strong>CEP</strong>: {{displayPessoaFisica.cep}}</li>
                    <li> <strong>País de Nacionalidade</strong>: {{displayPessoaFisica.cep}}</li>
                    <li> <strong>Telefone Fixo</strong>: {{displayPessoaFisica.fixo}}</li>
                    <li> <strong>Telefone Celular</strong>: {{displayPessoaFisica.celular}}</li>
                </ul>
            
                <hr>

                    <Curriculo></Curriculo>

                    <div class="panel-footer">
                        <router-link to="/new-curriculo" class="btn btn-lg btn-warning">Editar Informações</router-link>
                        <router-link to="/DashFIS" tag="button" class="btn btn-lg btn-default ">Voltar</router-link>
                        <button @click="showModal" class="btn btn-lg btn-danger">Deletar Conta</button>
                        <Modal v-show="isModalWarning" @close="closeModal">
                            <template v-slot:header><h3>Deletar Conta</h3></template>
                            <template v-slot:body>
                                <h2 class="text-center">Tem certeza de que deseja  
                                    <span style="color: #ff0000"><strong>deletar</strong></span> 
                                    sua conta?</h2>
                                <h4 class="text-center">Sentiremos sua falta :(</h4>

                            </template>
                            <template v-slot:footer>
                            <div class="modal-footer">
                                <button @click="onDelete" class="btn btn-lg btn-danger">Sim, quero deletar minha conta</button>
                                <button @click="closeModal" class="btn btn-lg btn-success">Vou dar mais uma chance para vocês...</button>
                            </div>
                            </template>
                        </Modal>
                    </div>
                </div>
                <div v-else>
                    <h4>Você ainda não completou suas informações... Que tal fazer isso agora?</h4>
                    <NewCurriculo></NewCurriculo>
                </div>

            </div>
        </div>
      </div>
  </div>

</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import moment from 'moment'
    import Curriculo from './Curriculo.vue';
    import Modal from '../Utils/Modal.vue';
    import NewCurriculo from '../Create/NewCurriculo.vue';
    export default {
        data() {
            return {
                isModalWarning: false,
            }
        },
        components: {Curriculo, NewCurriculo, Modal},
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
            onDelete(){
                this.$store.dispatch('deleteFisica')
                .then(response => {
                   //console.log(response)
                    this.$router.push({ name: 'login' })
                }).catch(error => console.log(error))  
  
            }
        },
        computed: {
            ...mapGetters([
                'dataCompleted', 'displayPessoaFisica'
            ]),
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
            console.log('dataCompleted', this.dataCompleted)
        },
        watch: {
            async displayPessoaFisica() {
                await this.loadFisica();
            }
        }
    }
</script>
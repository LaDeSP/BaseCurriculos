<template>
    <div class="row justify-content-center">
     <div class="col-md-9">
      <painel>
        <template v-slot:panel-head>
          <h2>Candidaturas</h2>
        </template>
      </painel>
      <div class="row" v-if="permissaoDoUsuario === 'JURIDICA'">
        <div v-if="!toggle">
            <div v-for="show in pageOfItems" :key="show.id" :id="show.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="label label-info ">Vaga: {{show.vaga.titulo}}</span></h3>
                    </template>
                    <template v-slot:card-body>
                    <p>Cargo: {{show.vaga.cargo}}</p>
                    <p>Detalhes: {{show.vaga.descricao}}</p>
                    </template>
                    <template v-slot:card-footer>
                        <button @click="vagaDaCandidatura(show.vagas_id)" class="btn btn-sm btn-success">Ver Candidatos</button>
                    </template>
                </Card>
            </div>
            <jw-pagination :items="vagasCandidaturas" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <div v-else>
            <div>
                <button @click="toggle = false" class="btn btn-sm btn-outline-secondary">Voltar</button>
            </div>
            <div v-for="show in pageOfItems" :key="show.id" :id="show.id">
              <List>
                <template v-slot:list-header>
                    <h3 class="mb-1" style="color: #4E73DF;">{{show.curriculo.fisica.user.name}}</h3>
                </template>
                <template v-slot:list-body>
                    <p class="mb-1"><strong>Objetivos:</strong> {{show.curriculo.objetivos}}</p>
                    <p class="mb-1"><strong>Pretensão Salarial:</strong> {{show.curriculo.pretensao}}</p>
                </template>
                <template v-slot:list-footer>
                  <button @click="showModal(show.id)" class="btn btn-sm btn-default">Ver mais</button>
                  
                  <Modal v-if="isModalShowMore" @close="closeModal">
                        <template v-slot:header><h3>Detalhes do Candidato</h3></template>
                        <template v-slot:body>
                            
                         <h4>Informações Pessoais</h4>
                        <ul>
                            <li> <strong>Nome Completo</strong>: {{candidatoById[0].curriculo.fisica.user.name}}</li>
                            <li> <strong>Data de Nascimento</strong>: {{candidatoById[0].curriculo.fisica.data_nascimento | dateFormat}}</li>
                            <li> <strong>Gênero</strong>: {{candidatoById[0].curriculo.fisica.genero}}</li>
                            <li> <strong>Estado Civil</strong>: {{candidatoById[0].curriculo.fisica.estado_civil}}</li>
                            <li> <strong>CPF</strong>: {{candidatoById[0].curriculo.fisica.cpf}}</li>
                          
                        </ul>
                        <h4>Redes Sociais</h4>
                        <ul>
                            <li v-if="typeof candidatoById[0].curriculo.fisica.contato.facebook !== 'undefined' || null">Facebook: {{candidatoById[0].curriculo.fisica.contato.facebook}}</li>
                            <li v-if="typeof candidatoById[0].curriculo.fisica.contato.twitter !== 'undefined' || null">Twitter: {{candidatoById[0].curriculo.fisica.contato.twitter}}</li>
                            <li v-if="typeof candidatoById[0].curriculo.fisica.contato.linkedin !== 'undefined' || null">Linkedin: {{candidatoById[0].curriculo.fisica.contato.linkedin}}</li>
                            <li v-if="typeof candidatoById[0].curriculo.fisica.contato.site !== 'undefined' || null">Site: {{candidatoById[0].curriculo.fisica.contato.site}}</li>
                        </ul>
                        <h4>Currículo</h4>
                            <ul>
                                <li>Objetivos: {{candidatoById[0].curriculo.objetivos}}</li>
                                <li>Área de Atuação: {{candidatoById[0].curriculo.area.tipo}}</li>
                                <li>Pretensão Salarial: {{candidatoById[0].curriculo.pretensao}}</li>
                                <li>Formação Acadêmica: {{candidatoById[0].curriculo.escolaridade}}</li>
                                <li>Histórico Profissional: {{candidatoById[0].curriculo.historicoProfissional}}</li>
                                <li>Qualificações: {{candidatoById[0].curriculo.qualificacoes}}</li>
                            </ul>
                        </template>
                        <template v-slot:footer>
                         <!-- <button @click="closeModal" class="btn btn-sm btn-outline-default">Voltar</button>
                          <button @click="reject" class="btn btn-sm btn-outline-danger">Recusar</button> -->
                          <div v-if="show.status === 'EM AGENDAMENTO'">
                            <router-link v-bind:to="'/agenda/' + candidatoById[0].id" tag="button" class="btn btn-sm btn-info">Reagendar</router-link>
                          </div>
                          <div v-else>
                            <button @click="newAgenda(show.id)" class="btn btn-sm btn-info">Agendar Entrevista</button>
                          </div>
                        </template>
                  </Modal>
                  </template>
                </List>
              </div>
              <jw-pagination :items="candidaturasByVaga" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
      </div>
      <div v-else>
          <div v-for="show in pageOfItems" :key="show.id" :id="show.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="label label-info ">Vaga: {{show.vaga.titulo}}</span></h3>
                    </template>
                    <template v-slot:card-body>
                    <p>Status: {{show.status}}</p>
                    <p>Cargo: {{show.vaga.cargo}}</p>
                    <p>Detalhes: {{show.vaga.descricao}}</p>
                    </template>
                    <template v-slot:card-footer>
                        <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Desistir</button>
                    </template>
                </Card>
            </div>
            <jw-pagination :items="displayCandidaturas" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
      </div>
    </div>
  </div>
</template>


<script>
    import Card from '../Utils/CardsVagas';
    import List from '../Utils/List';
    import Modal from '../Utils/Modal';
    import Curriculo from '../Lists/Curriculo';
    import NewAgenda from '../Create/NewAgenda';
    import {mapGetters, mapActions, mapState} from 'vuex';
    import painel from '../Utils/Painel';
    import moment from 'moment'
    import JwPagination from 'jw-vue-pagination';
    const customLabels = {
        first: 'Primeira',
        last: 'Última',
        previous: 'Anterior',
        next: 'Próxima'
    };

    export default {
        data(){
            return{

                candidaturas: [],
                toggle: false,
                agendamento: false,
                isModalShowMore: false,
                vaga_id: 0,
                candidato_id: 0,
                pageOfItems: [],
                customLabels
            }
        },
        components: {NewAgenda, Card, List, Modal,painel, JwPagination},
        methods: {
            onChangePage(pageOfItems) {
                // update page of items
                this.pageOfItems = pageOfItems;
            },
            ...mapActions([
                'loadCandidaturas', 
            ]),

             showModal(candidato_id){
                 this.isModalShowMore = true;
                 this.candidato_id = candidato_id;
            },

            closeModal(){
              this.isModalWarning = false;
              this.isModalShowMore = false;
            },

            vagaDaCandidatura(vaga_id){
                this.toggle = true;
                this.vaga_id = vaga_id;
            },

            newAgenda(candidato_id){
                this.$session.set('candidato_id', candidato_id);
                this.$router.push({ name: 'new-agenda'})
            },

            updateAgenda(candidato_id){
                this.$session.set('updateAgenda', candidato_id);
                this.$router.push({ name: 'new-agenda'})
            }
        },

        computed: {
            ...mapGetters([
                'displayCandidaturas', 'permissaoDoUsuario', 
                'displayCandidaturasByVaga', 'displayCandidatoById',
            ]),
            ...mapState([
                'vagasCandidaturas', 
            ]),
            candidaturasByVaga() {
                return this.displayCandidaturasByVaga(this.vaga_id)
            },
            candidatoById() {
                return this.displayCandidatoById(this.candidato_id)
            },
        },

        filters:{
            dateFormat: function(value){
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY')
                }
            }
        },

        async created(){
            await this.loadCandidaturas();
        },

    }
</script>

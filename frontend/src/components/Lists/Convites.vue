<template>
<span v-if="isFetching == true">
  <br>
  <br>
  <br>
  <div class="container">
    <center><h1>
        Carregando...  <span class="fas fa-spinner fa-pulse"></span>
    </h1></center>
  </div>
</span>
<span v-else>
  <div class="row justify-content-center" v-if="permissaoDoUsuario === 'FISICA'">
      <div class="col-md-9">
      <div class="d-flex flex-row">
        <div class="p-2">
          <router-link v-bind:to="'/dashboard/'"  tag="button" class="btn btn-md btn-outline-secondary"><i class="fas fa-home fa-sm"></i> Home</router-link>
        </div>
      </div>
      <center><h2>Meus Convites</h2></center>
      <div v-if="displayConvites.length==0">
        <div class="container">
          <center><h1>Você ainda não tem convites.</h1></center>
        </div>
      </div>

        <div class="card-deck" v-else>
            <div class="col-lg-12">
                <div class="row">
                    <Card class="col-sm-6 column" v-for="convite in pageOfItems" :key="convite.id" :id="convite.id">
                        <template v-slot:card-header>
                        <h3><span class="label label-info " style="color: #4E73DF;">{{convite.vaga.titulo}}</span></h3>
                        </template>
                        <template v-slot:card-body>
                            <p class="mb-1"><strong>Cargo:</strong> {{convite.vaga.cargo}}</p>
                            <p class="mb-1"><strong>Área de Atuação:</strong> {{convite.vaga.area}}</p>
                            <p class="mb-1"><strong>Jornada de Trabalho:</strong> {{convite.vaga.jornada}}</p>
                        </template>
                        <template v-slot:card-footer>
                            <button @click="showModal('else', convite.vaga.id)" class="btn btn-sm btn-default">Ver mais</button>
                            <button @click="resposta('RECUSOU', convite.vaga.id)" class="btn btn-danger btn-sm btn-outline-default">Recusar</button>
                            <button @click="resposta('ACEITOU', convite.vaga.id)" class="btn btn-primary btn-sm btn-outline-default">Aceitar</button>
                            <Modal v-if="isModalShowMore" @close="closeModal">
                                <template v-slot:header><h3>Detalhes da Vaga</h3></template>
                                <template v-slot:body>
                                    <h3 class="mb-1" style="color: #4E73DF;">{{vagaById[0].titulo}}</h3>
                                    <strong>Descrição:</strong> {{vagaById[0].descricao}}
                                    <strong>Cargo: </strong>{{vagaById[0].cargo}}
                                    <strong>Área de Atuação:</strong> {{vagaById[0].area.tipo}}
                                    <strong>Jornada de Trabalho: </strong>{{vagaById[0].jornada}}
                                    <strong>Salário:</strong> {{vagaById[0].salario}}
                                    <strong>Benefícios: </strong>{{vagaById[0].beneficio}}
                                    <strong>Requisitos:</strong> {{vagaById[0].requisito}}
                                </template>
                                <template v-slot:footer>
                                    <button @click="closeModal" class="btn btn-sm btn-outline-default">Voltar</button>
                                    <button @click="resposta('RECUSOU', vagaById[0].id)" class="btn btn-danger btn-sm btn-outline-default">Recusar</button>
                                    <button @click="resposta('ACEITOU', vagaById[0].id)" class="btn btn-primary btn-sm btn-outline-default">Aceitar</button>
                                </template>
                            </Modal>
                        </template>
                    </Card>

                </div>
            </div>
        </div>
        <div v-if="displayConvites.length > 10">
             <jw-pagination :items="displayConvites" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <div class="display-none" v-else>
            <jw-pagination :items="displayConvites" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <Modal v-if="isModalAccept" @close="closeModal">
            <template v-slot:header></template>
            <template v-slot:body>
                 <b-alert show variant="success">
                    <h1>Você aceitou o convite! Sua candidatura foi criada. Vá para a candidaturas para vê-la.</h1>
                    <p>A empresa irá entrar em contato.</p>
                </b-alert>
            </template>
        </Modal>
        <Modal v-if="isModalRefuse" @close="closeModal">
            <template v-slot:header></template>
            <template v-slot:body>
                 <b-alert show variant="warning">
                    <h1>Você recusou o convite!</h1>
                </b-alert>
            </template>
        </Modal>
    </div>
  </div>
  <div v-else>
  <div class="row justify-content-center">
      <div class="col-md-9">
        <div v-if="!toggle">
            <h2><router-link v-bind:to="'/dashboard/'"  tag="button" class="btn btn-md btn-outline-secondary"><i class="fa fa-home"></i> Home</router-link><center>Convites</center></h2>
        </div>
        <div v-else>
            <h2><router-link v-bind:to="'/dashboard/'"  tag="button" class="btn btn-md btn-outline-secondary"><i class="fa fa-home"></i> Home</router-link><center>Convidados</center></h2>
        </div>
        <div v-if="displayVagasThatHaveConvites.length == 0">
          <div class="container justify-content-center">
            <h2>Não há nenhum convite por enquanto! </h2>
          </div>
        </div>
        <div v-if="!toggle">
          <div class="card-deck">
            <div class="col-12">
              <div class="row">
              <Card class="col-sm-6  column" v-for="show in pageOfItems" :key="show.id" :id="show.id">
                    <template v-slot:card-header>
                      <h3><span class="badge badge-info ">Vaga: {{show.vaga.titulo}}</span></h3>
                    </template>
                    <template v-slot:card-body>
                    <strong>Cargo</strong>: {{show.vaga.cargo}}
                    <strong>Detalhes</strong>: {{show.vaga.descricao}}
                    </template>
                    <template v-slot:card-footer>
                        <button @click="vagaDoConvite(show.vagas_id)" class="btn btn-sm btn-success">Ver Convites</button>
                    </template>
              </Card>
            </div>
            </div>
            </div>
            <div class="row justify-content-center">
              <div class="trocaPagina" v-if="displayVagasThatHaveConvites.length > 10">
                <jw-pagination :items="displayVagasThatHaveConvites" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
              </div>
              <div class="trocaPagina display-none" v-else>
                <jw-pagination :items="displayVagasThatHaveConvites" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
              </div>
            </div>
        </div>
        <div v-else>
            <button @click="toggle = false" class="btn btn-lg btn-outline-secondary"><i class="fas fa-long-arrow-alt-left"></i> Voltar</button>
            <br>
            <br>
            <div class="list-group" v-for="show in pageOfItems" :key="show.id" :id="show.id">
                <List class="mb-4" style="width: 60rem; height:15rem;">
                    <template v-slot:list-header>
                        <h3 class="mb-1" style="color: #4E73DF;">{{show.curriculo.fisica.user.name}}
                            <span v-if="show.resposta == 'AGUARDANDO'">
                                <span class="badge badge-warning">AGUARDANDO</span>
                            </span>
                            <span v-if="show.resposta == 'CANCELADO'">
                                <span class="badge badge-danger">VOCÊ CANCELOU ESSE CONVITE</span>
                            </span>
                            <span v-if="show.resposta == 'RECUSOU'">
                                <span class="badge badge-warning">RECUSOU</span>
                            </span>
                            <span v-if="show.resposta == 'ACEITOU'">
                                <span class="badge badge-success">ACEITOU</span>
                            </span>
                        </h3>
                    </template>
                    <template v-slot:list-body>
                        <div v-if="show.resposta == 'ACEITOU'">
                            <small>Uma candidatura foi criada. Vá para candidaturas para agendar uma entrevista.</small>
                        </div>
                        <p class="mb-1"><strong>Objetivos:</strong> {{show.curriculo.objetivos}}</p>
                        <p class="mb-1"><strong>Pretensão Salarial:</strong> {{show.curriculo.pretensao}}</p>
                    </template>
                    <template v-slot:list-footer>

                        <button @click="showModalJuridica('showMore', show.id)" class="btn btn-sm btn-default">Ver mais</button>
                        <button v-if="show.resposta == 'AGUARDANDO'" @click="cancela(show.id)" class="btn btn-danger btn-sm btn-default">Cancelar Convite</button>
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
                                    <li v-if="typeof candidatoById[0].curriculo.fisica.contato.facebook !== 'undefined' || null"><strong>Facebook</strong>: {{candidatoById[0].curriculo.fisica.contato.facebook}}</li>
                                    <li v-if="typeof candidatoById[0].curriculo.fisica.contato.twitter !== 'undefined' || null"><strong>Twitter</strong>: {{candidatoById[0].curriculo.fisica.contato.twitter}}</li>
                                    <li v-if="typeof candidatoById[0].curriculo.fisica.contato.linkedin !== 'undefined' || null"><strong>Linkedin</strong>: {{candidatoById[0].curriculo.fisica.contato.linkedin}}</li>
                                    <li v-if="typeof candidatoById[0].curriculo.fisica.contato.site !== 'undefined' || null"><strong>Site</strong> {{candidatoById[0].curriculo.fisica.contato.site}}</li>
                                </ul>
                                <h4>Currículo</h4>
                                    <ul>
                                        <li><strong>Objetivos</strong>: {{candidatoById[0].curriculo.objetivos}}</li>
                                        <li><strong>Área de Atuação</strong>: {{candidatoById[0].curriculo.area.tipo}}</li>
                                        <li><strong>Pretensão Salarial</strong>: {{candidatoById[0].curriculo.pretensao}}</li>
                                        <li><strong>Formação Acadêmica</strong>: {{candidatoById[0].curriculo.escolaridade}}</li>
                                        <li><strong>Histórico Profissional</strong>: {{candidatoById[0].curriculo.historicoProfissional}}</li>
                                        <li><strong>Qualificações</strong>: {{candidatoById[0].curriculo.qualificacoes}}</li>
                                    </ul>
                                </template>
                                <template v-slot:footer>
                                    <button v-if="show.resposta == 'AGUARDANDO'" @click="cancela(show.id)" class="btn btn-danger btn-sm btn-default">Cancelar Convite</button>
                                </template>
                        </Modal>
                    </template>
                </List>
            </div>
            <div class="row justify-content-center">
                <div class="trocaPagina" v-if="convitesByVaga.length > 4">
                    <jw-pagination :items="convitesByVaga" @changePage="onChangePage" :pageSize="4" :labels="customLabels"></jw-pagination>
                </div>
                <div class="trocaPagina display-none" v-else>
                    <jw-pagination :items="convitesByVaga" @changePage="onChangePage" :pageSize="4" :labels="customLabels"></jw-pagination>
                </div>
            </div>
            <Modal v-if="isModalRefuse" @close="closeModal">
                <template v-slot:header></template>
                <template v-slot:body>
                    <b-alert show variant="warning">
                        <h1>Você cancelou o convite!</h1>
                    </b-alert>
                </template>
            </Modal>
        </div>
        </div>
      </div>
    </div>
</span>
</template>

<script>
import Card from '../Utils/Card';
import Modal from '../Utils/ModalOld';
import List from '../Utils/List';
import { mapActions, mapGetters, mapState } from 'vuex';
import JwPagination from 'jw-vue-pagination';
import { BAlert } from 'bootstrap-vue'
import moment from 'moment'

const customLabels = {
    first: 'Primeira',
    last: 'Última',
    previous: 'Anterior',
    next: 'Próxima'
};

export default {
    data(){
        return{
            pageOfItems: [],
            customLabels,
            isModalWarning: false,
            isModalShowMore: false,
            isModalAccept: false,
            isModalError: false,
            isModalMultipleInvite: false,
            isModalRefuse: false,
            vaga_id: 0,
            toggle: false,
            candidato_id: 0,
        }
    },
    components: {Card, JwPagination, Modal, BAlert, List},

    computed:{
        ...mapState([
            'isFetching'
        ]),

        ...mapGetters([
            'displayConvites', 'permissaoDoUsuario', 'displayVagaById',
            'displayVagasThatHaveConvites', 'displayConvitesByVaga',
            'displayCandidatoByIdConvite'//tive que criar essa nova pq o antigo que maria fez usa candidatura. Qualquer coisa criar um mandando parametro e mudando isso em todo lugar que usa
        ]),

        vagaById(){
            return this.displayVagaById(this.vaga_id)
        },

        convitesByVaga() {
            return this.displayConvitesByVaga(this.vaga_id)
        },

        candidatoById() {
            return this.displayCandidatoByIdConvite(this.candidato_id)
        },
    },

    methods: {
        ...mapActions([
            'getConvites', 'loadVagasJuridica'
        ]),

        onChangePage(pageOfItems) {
            // update page of items
            this.pageOfItems = pageOfItems;
        },

        closeModal(){
            this.isModalWarning = false;
            this.isModalShowMore = false;
            this.isModalAccept = false;
            this.isModalError = false;
            this.isModalMultipleInvite = false;
            this.isModalRefuse = false;
        },

        showModal(modal, vaga_id){
            if(modal === 'warning'){
                this.isModalWarning = true;
                this.vaga_id = vaga_id;
            }
            else{
                this.isModalShowMore = true;
                this.vaga_id = vaga_id;
            }
        },

        showModalJuridica(modal, candidato_id){
            if(modal === 'showMore'){
                this.isModalShowMore = true;
                this.candidato_id = candidato_id;
            }
            else if(modal === 'warning'){
                this.isModalWarning = true;
                this.candidato_id = candidato_id;
            }
            else if(modal === 'desistencia'){
                this.isModalDesistencia = true;
                this.candidato_id = candidato_id;
            }
            else{
                this.isModalAgendamento = true;
                this.candidato_id = candidato_id;
            }
        },

        resposta(resposta, vaga_id){
            let requestConvite = {
                resposta: resposta,
                vaga_id: vaga_id
            }
            this.$store.dispatch('respondeConvite', requestConvite)
            .then(response => {
                this.isModalShowMore = false;
                if(resposta=='ACEITOU'){
                    this.isModalAccept = true;
                }
                else{
                    this.isModalRefuse = true;
                }

            }).catch(error => console.log(error))
        },

        cancela(convite_id){
            let cancelConvite = {
                convite_id: convite_id,
            }

            this.$store.dispatch('cancelaConvite', cancelConvite)
            .then(response => {
                this.isModalShowMore = false;
                this.isModalRefuse = true;
            }).catch(error => console.log(error))
        },

        vagaDoConvite(vaga_id){
            this.toggle = true;
            this.vaga_id = vaga_id;
        },
    },

    created(){
        this.getConvites();
        this.loadVagasJuridica();
    },

    filters:{
        dateFormat: function(value){
            if (value) {
                return moment(String(value)).format('DD/MM/YYYY')
            }
        }
    },
}

</script>

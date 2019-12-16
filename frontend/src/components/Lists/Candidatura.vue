<template>
<span v-if="isFetching">
 <center><h1>
    Carregando...  <span class="fas fa-spinner fa-pulse"></span>
 </h1></center>
</span>
<span v-else>
    <div class="row justify-content-center">
     <div class="col-md-9">
      <div v-if="permissaoDoUsuario === 'JURIDICA'">
        <div v-if="!toggle">
          <h2><router-link v-bind:to="'/dashboard/'"  tag="button" class="btn btn-md btn-outline-secondary"><i class="fa fa-home"></i> Home</router-link><center>Candidaturas</center></h2>
        </div>
        <div v-else>
          <h2><router-link v-bind:to="'/dashboard/'"  tag="button" class="btn btn-md btn-outline-secondary"><i class="fa fa-home"></i> Home</router-link><center>Candidatos</center></h2>
        </div>
        <br>
        <div v-for="candidatura in candidaturas" :key="candidatura.id">
            <div v-if="candidatura.status == 'CONTRATADO'">
               <!-- <router-link to="/" class="btn btn-sm btn-secondary">Histórico</router-link> -->
            </div>
        </div>
        <div v-if="displayVagasThatHaveCandidaturas.length == 0">
            <br><br><br><br><h2>Não há nenhuma candidatura por enquanto! </h2>
        </div>
        <div v-if="!toggle">
          <div class="card-group">
              <div class="col-lg-12">
                <div class="row">
                  <div v-for="show in pageOfItems" :key="show.id" :id="show.id" class="margin-bottom">
                    <Card class="col-sm-6 ml-1">
                        <template v-slot:card-header>
                          <h3 class="card-title" style="color: #4E73DF;">Vaga: {{show.vaga.titulo}}</h3>
                        </template>
                        <template v-slot:card-body>
                        <strong>Cargo</strong>: {{show.vaga.cargo}}<br>
                        <strong>Detalhes</strong>: {{show.vaga.descricao}}<br>
                        </template>
                        <template v-slot:card-footer>
                          <button @click="vagaDaCandidatura(show.vagas_id)" class="btn btn-sm btn-success">Ver Candidatos</button>
                        </template>
                    </Card>
                </div>
              </div>
          </div>
          </div>
            <div class="row justify-content-center">
              <div class="trocaPagina" v-if="displayVagasThatHaveCandidaturas.length > 10">
                <jw-pagination :items="displayVagasThatHaveCandidaturas" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
              </div>
              <div class="trocaPagina display-none" v-else>
                <jw-pagination :items="displayVagasThatHaveCandidaturas" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
              </div>
            </div>
        </div>
        <div v-else>
          <button @click="toggle = false" class="btn btn-md btn-outline-secondary"><i class="fas fa-long-arrow-alt-left"></i> Voltar</button>
          <br>
          <br>
            <div v-for="show in pageOfItems" :key="show.id" :id="show.id">
              <List style="width: 60rem; height:30rem;">
                <template v-slot:list-header>
                  <h3 class="mb-1" style="color: #4E73DF;">{{show.curriculo.fisica.user.name}}
                    <span v-if="show.status == 'EM AGENDAMENTO'">
                        <span class="badge badge-warning">EM AGENDAMENTO</span>
                    </span>
                    <span v-if="show.status == 'AGUARDANDO'">
                        <span class="badge badge-warning">AGUARDANDO</span>
                    </span>
                    <span v-if="show.status == 'ENTREVISTA CONFIRMADA'">
                        <span class="badge badge-success">ENTREVISTA CONFIRMADA</span>
                    </span>
                  </h3>
                </template>
                <template v-slot:list-body>
                    <br><strong>Objetivos:</strong> {{show.curriculo.objetivos}}<br><br>
                    <strong>Pretensão Salarial:</strong> {{show.curriculo.pretensao}}<br>
                </template>
                <template v-slot:list-footer>
                  <button @click="showModal('showMore', show.id)" class="btn btn-sm btn-default">Ver mais</button>

                  <span v-if="show.status === 'EM AGENDAMENTO' || show.status === 'ENTREVISTA CONFIRMADA'">
                    <router-link to="/agenda" tag="button" class="btn btn-sm btn-info">Ver agendamento</router-link>
                  </span>

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
                         <!-- <button @click="closeModal" class="btn btn-sm btn-outline-default">Voltar</button>
                          <button @click="reject" class="btn btn-sm btn-outline-danger">Recusar</button> -->
                          <div v-if="show.status === 'EM AGENDAMENTO'">
                            <!--<router-link v-bind:to="'/agenda/' + candidatoById[0].id" tag="button" class="btn btn-sm btn-info">Reagendar</router-link>-->
                            <router-link to="'/agenda/'" tag="button" class="btn btn-sm btn-info">Ver agendamento</router-link>
                          </div>
                          <div v-else-if="show.status === 'ENTREVISTA CONFIRMADA'">
                             <router-link v-bind:to="'/agenda/'" tag="button" class="btn btn-sm btn-info">Ver Agendamento</router-link>
                          </div>
                          <div v-else>
                            <button @click="newAgenda(show.id)" class="btn btn-sm btn-info">Agendar Entrevista</button>
                            <button @click="recusaCandidatura(show.id)" class="btn btn-sm btn-danger">Recusar Candidato</button>
                          </div>
                        </template>
                  </Modal>

                  </template>
                </List>
              </div>
              <div class="row justify-content-center">
              <div class="trocaPagina" v-if="candidaturasByVaga.length > 4">
                <jw-pagination :items="candidaturasByVaga" @changePage="onChangePage" :pageSize="4" :labels="customLabels"></jw-pagination>
              </div>
              <div class="trocaPagina display-none" v-else>
                <jw-pagination :items="candidaturasByVaga" @changePage="onChangePage" :pageSize="4" :labels="customLabels"></jw-pagination>
              </div>
              <Modal v-if="isModalRecusa" @close="closeModal">
                  <template v-slot:header> </template>
                  <template v-slot:body>
                      <b-alert show variant="success">
                          <h1>Você recusou o candidato com sucesso!</h1>
                      </b-alert>
                  </template>
              </Modal>
            </div>

        </div>
      </div>
      <div v-else>
                <div class="row">
          <div class="col-4">
            <router-link v-bind:to="'/dashboard/'"  tag="button" class="btn btn-md btn-outline-secondary"><i class="fa fa-home"></i> Home</router-link>
          </div>
          <div class="6">
            <h2 class="mb-4"><center><h2>Minhas Candidaturas</h2></center></h2>
          </div>
        </div>
          <div v-if="displayCandidaturas.length != 0">
                 <center class="bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                     <div class="btn-group" role="group" aria-label="Basic example">
                        <button @click="filterState = 'ALL'" type="button" class="btn btn-sm btn-outline-info">Todas</button>
                        <button @click="filterState = 'AGUARDANDO'" type="button" class="btn btn-sm btn-outline-warning">Aguardando</button>
                        <button @click="filterState = 'CONFIRMADAS'" type="button" class="btn btn-sm btn-outline-success">Confirmadas</button>
                        <button @click="filterState = 'CANCELADAS'" type="button" class="btn btn-sm btn-outline-danger">Canceladas</button>
                        <button @click="filterState = 'FINALIZADAS'" type="button" class="btn btn-sm btn-outline-primary">Finalizadas</button>
                        </div>
                     </div>
                </center>
                 <span v-if="filterState == 'AGUARDANDO' && pageOfItems.length == 0">
                  <br>
                  <br>
                  <div class="container">
                    <center><h3>Não há candidaturas aguardando. </h3></center>
                  </div>

                </span>
                <span v-else-if="filterState == 'CONFIRMADAS'&& pageOfItems.length == 0">
                  <br>
                  <br>
                  <div class="container">
                    <center><h3>Não há candidaturas com entrevistas confirmadas. </h3></center>
                  </div>
                </span>
                 <span v-else-if="filterState == 'CANCELADAS' && pageOfItems.length == 0">
                  <br>
                  <br>
                  <div class="container">
                    <center><h3>Não há candidaturas com entrevistas canceladas. </h3></center>
                  </div>
                </span>
                 <span v-else-if="filterState == 'FINALIZADAS' && pageOfItems.length == 0">
                  <br>
                  <br>
                  <div class="container">
                    <center><h3>Não há candidaturas finalizadas. </h3></center>
                  </div>
                </span>
               </div>
          <div class="row justify-content-center">
            <span v-if="displayCandidaturas.length == 0"><h3>Você ainda não fez nenhuma candidatura!</h3></span>
          </div>
          <div class="row">
          <div v-for="show in pageOfItems" :key="show.id" :id="show.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="badge badge-info ">Vaga: {{show.vaga.titulo}}</span>
                        <span v-if="show.status == 'ENTREVISTA CANCELADA'">
                            <span class="badge badge-danger">{{show.status}}</span>
                        </span>
                        <span v-if="show.status == 'ENTREVISTA CONFIRMADA'">
                            <span class="badge badge-success">{{show.status}}</span>
                        </span>
                         <span v-if="show.status == 'EM AGENDAMENTO'">
                            <span class="badge badge-warning">{{show.status}}</span>
                        </span>
                          <span v-if="show.status == 'AGUARDANDO'">
                            <span class="badge badge-warning">{{show.status}}</span>
                        </span>
                        <span v-if="show.status == 'RECUSADO'">
                            <span class="badge badge-danger">ENCERRADO</span>
                        </span>
                        <span v-if="show.status == 'CONTRATADO'">
                            <span class="badge badge-success">{{show.status}}</span>
                        </span>
                    </h3>
                    </template>
                    <template v-slot:card-body>
                    <ul>
                        <li><strong>Cargo</strong>: {{show.vaga.cargo}}</li>
                        <li><strong>Detalhes</strong>: {{show.vaga.descricao}}</li>
                        <span v-if="show.status == 'ENTREVISTA CANCELADA'">
                            <br>
                            <li>Sua entrevista foi cancelada.
                                <span v-if="show.agenda[0].observacao != null">
                                    A empresa fez a seguinte observação:
                                    <br><br>
                                    <i>"{{show.agenda[0].observacao}}"</i>
                                </span>
                                <span v-else>
                                    A empresa não fez observações.
                                </span>
                            </li>
                        </span>
                        <span v-if="show.status == 'ENTREVISTA CONFIRMADA'">
                            <br>
                            Sua entrevista com a empresa está marcada para o dia <strong>{{show.agenda[0].data | dateFormat}}</strong>,
                            às <strong>{{show.agenda[0].hora}}</strong>,
                            <span v-if="show.agenda[0].observacao != null">
                                com as seguintes observações:
                                <br><br>
                                <center><i>"{{show.agenda[0].observacao}}"</i></center>
                            </span>
                             <span v-else>
                                a empresa não fez observações.
                            </span>
                        </span>
                        <span v-if="show.status == 'RECUSADO'">
                         <br><span style="color:red; font-weight: bold;"> Infelizmente, a empresa decidiu não dar continuidade no seu processo de contratação. :( </span><br><br>
                            <span v-if="show.agenda[0].observacao != null">
                                Foi feita a seguinte observação:
                                <br><br>
                                <center><i>"{{show.agenda[0].observacao}}"</i></center>
                            </span>
                            <span v-else>
                                A empresa não fez observações.
                            </span>
                        </span>
                    </ul>
                    </template>
                    <template v-slot:card-footer>
                        <span v-if="show.status === 'EM AGENDAMENTO'">
                            <button @click="showModal('agendamento', show.id)" class="btn btn-sm btn-info">Ver agendamento</button>
                            <Modal v-if="isModalAgendamento" @close="closeModal">
                                <template v-slot:header><h3>Detalhes do Agendamento</h3></template>
                                <template v-slot:body>
                                  <div>
                                    <span v-if="agendaById[0].contraproposta == 'JURIDICA' || agendaById[0].contraproposta == null ">
                                        <h5>Referente à vaga "<strong>{{agendaById[0].candidatura.vaga.titulo}}</strong>":</h5>
                                        <h6>A empresa agendou uma entrevista para o dia <strong>{{agendaById[0].data | dateFormat}}</strong>, às <strong>{{agendaById[0].hora}}</strong>,
                                        com as seguintes observações: <br><center>"<i>{{agendaById[0].observacao}}</i>"</center>
                                        <br>
                                        O que deseja fazer?</h6>
                                    </span>
                                    <span v-else-if="agendaById[0].contraproposta == 'FISICA'">
                                        <h5>Referente à vaga "<strong>{{agendaById[0].candidatura.vaga.titulo}}</strong>":</h5>
                                        <h6>Você já fez uma contraproposta e agendou uma entrevista para o dia <strong>{{agendaById[0].data | dateFormat}}</strong>, às <strong>{{agendaById[0].hora}}</strong>,
                                        com as seguintes observações: <br><center>"<i>{{agendaById[0].observacao}}</i>"</center>
                                        <br>
                                        Aguarde a resposta da empresa!</h6>
                                    </span>
                                  </div>
                                </template>
                                <template v-slot:footer>
                                    <div v-if="agendaById[0].contraproposta != 'FISICA'">
                                       <button @click="showModal('warning', show.id)" class="btn btn-sm btn-danger">Cancelar</button>
                                            <Modal v-show="isModalWarning" @close="closeModal">
                                                <template v-slot:header>
                                                <h3>Cancelar Entrevista</h3>
                                                </template>
                                                <template v-slot:body>
                                                <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> essa entrevista?</h2>
                                                <center><br><h6>Você pode fazer uma observação para a empresa:</h6></center>
                                                <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                                                <br><h6 class="text-center">Essa ação não poderá ser desfeita!</h6>
                                                </template>
                                                <template v-slot:footer>
                                                    <button @click="cancelAgenda" class="btn btn-md btn-danger">Cancelar</button>
                                                    <button @click="closeModal" class="btn btn-md btn-outline-secondary">Voltar</button>
                                                </template>
                                            </Modal>

                                        <router-link v-bind:to="'/agenda/' + agendaById[0].candidatura_id " tag="button" class="btn btn-sm btn-primary">Fazer uma contraproposta</router-link>
                                        <button @click="confirmAgenda(agendaById[0].candidatura.id)" class="btn btn-sm btn-success">Agendar Entrevista</button>
                                    </div>
                                    <div v-else>
                                          <button @click="closeModal" class="btn btn-sm btn-primary">Certo!</button>
                                    </div>
                                </template>
                        </Modal>
                        </span>
                        <span v-if="show.status == 'ENTREVISTA CONFIRMADA'">
                             <button @click="showModal('warning', show.id)" class="btn btn-sm btn-danger">Cancelar</button>
                              <Modal v-show="isModalWarning" @close="closeModal">
                                <template v-slot:header>
                                    <h3>Cancelar Entrevista</h3>
                                </template>
                                <template v-slot:body>
                                    <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> essa entrevista?</h2>
                                    <br><h4>Faça uma observação para a empresa:</h4>
                                    <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                                    <br><h6 class="text-center">Essa ação não poderá ser desfeita!</h6>
                                </template>
                                <template v-slot:footer>
                                    <button @click="cancelAgenda" class="btn btn-md btn-danger">Cancelar</button>
                                    <button @click="closeModal" class="btn btn-md btn-outline-secondary">Voltar</button>
                                </template>
                            </Modal>
                        </span>
                        <span v-if="show.status == 'AGUARDANDO'">
                            <button @click="showModal('desistencia', show.id)" class="btn btn-sm btn-danger">Desistir</button>
                            <Modal v-show="isModalDesistencia" @close="closeModal">
                                <template v-slot:header>
                                <h3>Desistir da candidatura</h3>
                                </template>
                                <template v-slot:body>
                                    <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>desistir</strong></span> dessa vaga?</h2>
                                </template>
                                <template v-slot:footer>
                                      <button @click="deleteCandidatura(show.id)" class="btn btn-sm btn-danger">Desistir</button>
                                    <button @click="closeModal" class="btn btn-md btn-outline-secondary">Voltar</button>
                                </template>
                            </Modal>
                        </span>
                        <span v-if="show.status == 'ENTREVISTA CANCELADDA' || show.status == 'RECUSADDO'">
                            <center><button @click="deleteCandidatura(show.id)" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></center>
                        </span>
                    </template>
                </Card>
            </div>
      </div>
        <div class="row justify-content-center">
          <div class="trocaPagina" v-if="displayCandidaturas.length > 10">
            <jw-pagination :items="displayCandidaturas" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
          </div>
          <div class="trocaPagina display-none" v-else>
            <jw-pagination :items="isActive" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
          </div>
        </div>
        <Modal v-if="isModalEditouEntrevista" @close="closeModal">
          <template v-slot:header></template>
          <template v-slot:body>
              <b-alert show variant="success">
                  <h1>Entrevista editada com sucesso!</h1>
              </b-alert>
          </template>
        </Modal>
     </div>
   </div>
  </div>
</span>
</template>


<script>
    import Card from '../Utils/Card';
    import List from '../Utils/List';
    import Modal from '../Utils/Modal';
    import Curriculo from '../Lists/Curriculo';
    import NewAgenda from '../Create/NewAgenda';
    import {mapGetters, mapActions, mapState} from 'vuex';
    import painel from '../Utils/Painel';
    import moment from 'moment'
    import JwPagination from 'jw-vue-pagination';
    import { BAlert } from 'bootstrap-vue'

    const customLabels = {
        first: 'Primeira',
        last: 'Última',
        previous: 'Anterior',
        next: 'Próxima'
    };

    export default {
        data(){
            return{

                toggle: false,
                isModalShowMore: false,
                isModalAgendamento: false,
                isModalWarning: false,
                isModalDesistencia: false,
                isModalRecusa: false,
                vaga_id: 0,
                candidato_id: 0,
                observacao: '',
                pageOfItems: [],
                customLabels,
                filterState: 'ALL',
                isModalEditouEntrevista: false,
            }
        },
        components: {NewAgenda, Card, List, Modal,painel, JwPagination, BAlert},
        methods: {

            ...mapActions([
                'loadCandidaturas', 'loadAgenda'
            ]),

             onChangePage(pageOfItems) {
                // update page of items
                this.pageOfItems = pageOfItems;
            },

             showModal(modal, candidato_id){
                 if(modal === 'showMore'){
                    this.isModalShowMore = true;
                    this.candidato_id = candidato_id;
                 }else if(modal === 'warning'){
                    this.isModalWarning = true;
                    this.candidato_id = candidato_id;
                 }else if(modal === 'desistencia'){
                    this.isModalDesistencia = true;
                    this.candidato_id = candidato_id;
                 }else{
                    this.isModalAgendamento = true;
                    this.candidato_id = candidato_id;
                 }
            },

            closeModal(){
              this.isModalWarning = false;
              this.isModalShowMore = false;
              this.isModalAgendamento = false;
              this.isModalDesistencia = false;
              this.isModalRecusa = false;
              this.isModalEditouEntrevista = false;
            },

            vagaDaCandidatura(vaga_id){
                this.toggle = true;
                this.vaga_id = vaga_id;
            },

            newAgenda(candidato_id){
                this.$session.set('candidato_id', candidato_id);
                this.$router.push({ name: 'new-agenda'})
            },

            async confirmAgenda(candidatura_id){

                let candidatura = {
                    candidatura_id: candidatura_id
                }

                await this.$store.dispatch('confirmAgenda', candidatura)
                .then(response => {

                }).catch(error => console.log(error))
            },


            async deleteCandidatura(){

                await this.$store.dispatch('deleteCandidatura', this.candidato_id)
                .then(response => {

                }).catch(error => console.log(error))
            },

            async recusaCandidatura(candidatura_id){
                await this.$store.dispatch('recusaCandidatura', candidatura_id)
                .then(response => {
                  this.loadCandidaturas();
                  this.isModalRecusa = true;


                }).catch(error => console.log(error))
            },

            async cancelAgenda(){

                let cancelAgenda = {
                    observacao: this.observacao,
                    candidatura_id: this.candidato_id
                }

                await this.$store.dispatch('cancelAgenda', cancelAgenda)
                .then(response => {
                   this.isModalWarning = false;
                }).catch(error => console.log(error))
            }

        },

        computed: {
            ...mapGetters([
                'displayCandidaturas', 'permissaoDoUsuario',
                'displayCandidaturasByVaga', 'displayCandidatoById',
                'displayAgendaById', 'displayVagasThatHaveCandidaturas',
                'displayCandidaturasEmAgendamento', 'displayCandidaturasConfirmadas',
                'displayCandidaturasCanceladas', 'displayCandidaturasFinalizadas'
            ]),
            ...mapState([
                'vagasCandidaturas', 'candidaturas', 'isFetching'
            ]),
            candidaturasByVaga() {
                return this.displayCandidaturasByVaga(this.vaga_id)
            },
            candidatoById() {
                return this.displayCandidatoById(this.candidato_id)
            },
            agendaById() {
                return this.displayAgendaById(this.candidato_id)
            },
            isActive() {
                if(this.filterState === 'ALL'){
                     console.log('oi', this.filterState)
                     return this.displayCandidaturas
                }else if (this.filterState === 'AGUARDANDO') {
                    return this.displayCandidaturasEmAgendamento
                }else if(this.filterState === 'CONFIRMADAS'){
                    return this.displayCandidaturasConfirmadas
                }else if(this.filterState === 'CANCELADAS'){
                     return this.displayCandidaturasCanceladas
                }else if(this.filterState === 'FINALIZADAS'){
                     return this.displayCandidaturasFinalizadas
                }

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
            await this.loadAgenda();
            if (this.$route.params.editouEntrevista){
                this.isModalEditouEntrevista = true;
            }
        },

    }
</script>

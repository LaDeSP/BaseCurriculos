<template>
    <div class="row justify-content-center">
      <div class="col-md-9">
        <h2><router-link v-bind:to="'/dashboard/'"  tag="button" class="btn btn-lg btn-outline-secondary"><i class="fa fa-home"></i> Home</router-link><center>Entrevistas Agendadas</center></h2>
        <div v-if="permissaoDoUsuario === 'JURIDICA'">
          <div>
              <div v-if="displayAgenda.length == 0">
                  <strong><h3>Não há entrevistas agendadas</h3></strong>
              </div>
              <div v-for="show in pageOfItems" :key="show.id" :id="show.id">
                  <Card style="width: 30rem;">
                      <template v-slot:card-header>
                          <span v-if="notificacoes">
                              <span class="badge badge-success">
                                  {{notificacoes}}
                              </span>
                          </span>
                          <h3>
                              <span class="badge badge-info ">
                                  Candidato: {{show.candidatura.curriculo.fisica.user.name}}
                              </span>
                              <span v-if="show.candidatura.status == 'EM AGENDAMENTO'">
                                  <span class="badge badge-warning">{{show.candidatura.status}}</span>
                              </span>
                              <span v-if="show.candidatura.status == 'ENTREVISTA CANCELADA'">
                                  <span class="badge badge-danger">{{show.candidatura.status}}</span>
                              </span>
                              <span v-else-if="show.candidatura.status == 'ENTREVISTA CONFIRMADA'">
                                  <span class="badge badge-sm badge-success">CONFIRMADA</span>
                              </span>
                              <span v-if="show.candidatura.status == 'AGUARDANDO'">
                                  <span class="badge badge-warning">{{show.candidatura.status}}</span>
                              </span>
                          </h3>
                      </template>
                      <template v-slot:card-body>
                          <ul>
                              <li><strong>Vaga</strong>: {{show.candidatura.vaga.titulo}}</li>
                              <li><strong>Data</strong>: {{show.data | dateFormat}}</li>
                              <li><strong>Hora</strong>: {{show.hora}}</li>
                          <span v-if="show.candidatura.status == 'ENTREVISTA CANCELADA'">
                              <br>
                              <li>A entrevista foi cancelada.
                                  <span v-if="show.observacao != null">
                                      O candidato fez a seguinte observação:
                                      <br><br>
                                      <i>"{{show.observacao}}"</i>
                                  </span>
                                  <span v-else>
                                      O candidato não fez observações.
                                  </span>
                              </li>
                                  </span>
                                  <span v-else>
                                      <strong>Observação</strong>: {{show.observacao}} <br><br>
                                  </span>
                                  <span v-if="show.candidatura.status == 'ENTREVISTA CONFIRMADA' && getDateNow(show.data)">
                                      <strong>Notamos que a data de entrevista já passou. O candidato foi: </strong>
                                  </span>
                          </ul>
                      </template>
                      <template v-slot:card-footer>
                          <span v-if="show.candidatura.status == 'ENTREVISTA CONFIRMADA' && getDateNow(show.data)" >
                              <center>
                                  <button @click="confirmAgenda(show.candidatura.id, 'CONTRATADO')" class="btn btn-sm btn-success">Contratado</button>
                                  <button @click="showModal('warningRecusa', show.candidatura.id)" class="btn btn-sm btn-danger">Recusado</button>
                              </center>
                                <Modal v-show="isModalWarningRecusa" @close="closeModal">
                                  <template v-slot:header>
                                    <h3>Recusar Candidato</h3>
                                  </template>
                                  <template v-slot:body>
                                    <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>recusar</strong></span> esse candidato?</h2>
                                    <br><h4>Caso queira, faça uma observação para o candidato:</h4>
                                    <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                                    <br><h6 class="text-center">Essa ação não poderá ser desfeita!</h6>
                                  </template>
                                  <template v-slot:footer>
                                      <button @click="closeModal" class="btn btn-md btn-outline-secondary">Voltar</button>
                                      <button @click="cancelAgenda('RECUSADO')" class="btn btn-md btn-danger">Enviar</button>
                                  </template>
                                </Modal>
                          </span>
                          <span v-if="show.candidatura.status == 'ENTREVISTA CANCELADA'">
                              <center><button @click="deleteCandidatura(show.candidatura.id)" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></center>
                          </span>
                          <span v-if="show.candidatura.status != 'ENTREVISTA CONFIRMADA' && show.candidatura.status != 'ENTREVISTA CANCELADA'">
                              <span v-if="show.contraproposta == 'FISICA'">
                                  <button @click="confirmAgenda(show.candidatura.id)" class="btn btn-sm btn-success">Confirmar</button>
                              </span>
                              <router-link v-bind:to="'/agenda/' + show.candidatura.id" tag="button" class="btn btn-sm btn-primary">Fazer Contraproposta</router-link>
                          </span>
                          <span v-if="show.candidatura.status != 'ENTREVISTA CANCELADA' && !getDateNow(show.data)">
                              <button @click="showModal('warning', show.candidatura.id)" class="btn btn-sm btn-danger">Cancelar</button>
                          </span>
                                <Modal v-show="isModalWarning" @close="closeModal">
                                  <template v-slot:header>
                                    <h3>Cancelar Entrevista</h3>
                                  </template>
                                  <template v-slot:body>
                                    <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> essa entrevista?</h2>
                                    <br><h4>Faça uma observação para o candidato:</h4>
                                    <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                                    <br><h6 class="text-center">Essa ação não poderá ser desfeita!</h6>
                                  </template>
                                  <template v-slot:footer>
                                      <button @click="cancelAgenda" class="btn btn-md btn-danger">Cancelar</button>
                                      <button @click="closeModal" class="btn btn-md btn-outline-secondary">Voltar</button>
                                  </template>
                                </Modal>
                      </template>
                  </Card>
              </div>
          </div>
          <div class="row justify-content-center">
            <div class="trocaPagina" v-if="displayAgenda.length > 10">
              <jw-pagination :items="displayAgenda" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
            </div>
            <div class="trocaPagina display-none" v-else>
              <jw-pagination :items="displayAgenda" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
            </div>
          </div>
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

                notificacoes: '',
                candidaturas: [],
                isModalShowMore: false,
                isModalWarning: false,
                isModalWarningRecusa: false,
                pageOfItems: [],
                candidatura_id: 0,
                observacao: '',
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
                'loadAgenda'
            ]),

            showModal(modal, id){
                if(modal === 'showMore'){
                    this.isModalShowMore = true;
                    this.candidato_id = id;
                }else if(modal === 'warning'){
                    this.isModalWarning = true;
                    this.candidatura_id = id;
                }else{
                    this.isModalWarningRecusa = true;
                    this.candidatura_id = id;
                }
            },

            closeModal(){
              this.isModalWarning = false;
              this.isModalShowMore = false;
              this.isModalWarningRecusa = false;
            },

            vagaDaCandidatura(vaga_id){
                this.toggle = true;
                this.vaga_id = vaga_id;
            },

            async confirmAgenda(candidatura_id, contratado){

                let candidatura = {
                    candidatura_id: candidatura_id,
                    contratado: contratado
                }

                await this.$store.dispatch('confirmAgenda', candidatura)
                .then(response => {
                    if(response.notificacao  != undefined){
                        this.notificacoes = response.notificacao;
                    }
                }).catch(error => console.log(error))
            },

            async cancelAgenda(recusado){

                let cancelAgenda = {
                    observacao: this.observacao,
                    candidatura_id: this.candidatura_id,
                    recusa: recusado,
                }

                await this.$store.dispatch('cancelAgenda', cancelAgenda)
                .then(response => {
                   this.isModalWarning = false;
                }).catch(error => console.log(error))
            },

             async deleteCandidatura(candidatura_id){

                await this.$store.dispatch('deleteCandidatura', candidatura_id)
                .then(response => {
                  console.log('delete', response);
                }).catch(error => console.log(error))
            },

            getDateNow(data){
                let now = new Date();
                let date = now.getDate();
                let month = now.getMonth() + 1;
                let year = now.getFullYear();

                //let dateStr = year + '-' + month + '-' + date;
                let dateStr = '2020-12-13';
                var dateAgenda = Date.parse(data);
                var dateNow = Date.parse(dateStr);

                if(dateNow > dateAgenda){
                    return true
                }else{
                    return false
                }
            }
        },

        computed: {
            ...mapGetters([
                'permissaoDoUsuario', 'displayAgenda'
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
            await this.loadAgenda();
          //  console.log('datetime',this.getDateTimeNow());

        },

    }
</script>

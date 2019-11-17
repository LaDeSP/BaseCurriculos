<template>
    <div class="row justify-content-center">
     <div class="col-md-9">
      
      <h2>Entrevistas Agendadas</h2>
      <div class="row" v-if="permissaoDoUsuario === 'JURIDICA'">
        <div>
            <div v-if="displayAgenda.length == 0">
                <strong><h3>Não há entrevistas agendadas</h3></strong>
            </div>
            <div v-for="show in pageOfItems" :key="show.id" :id="show.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="badge badge-info ">Candidato: {{show.candidatura.curriculo.fisica.user.name}}</span>
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
                        <li>Vaga: {{show.candidatura.vaga.titulo}}</li>
                        <li>Data: {{show.data | dateFormat}}</li>
                        <li>Hora: {{show.hora}}</li>
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
                        Observação: {{show.observacao}}>
                    </span>
                    </ul>
                    </template>
                    <template v-slot:card-footer>
                        <span v-if="show.candidatura.status == 'ENTREVISTA CANCELADA'">
                            <center><button @click="deleteCandidatura(show.candidatura.id)" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></center>
                        </span>
                        <span v-if="show.candidatura.status != 'ENTREVISTA CONFIRMADA' && show.candidatura.status != 'ENTREVISTA CANCELADA'">
                            <span v-if="show.contraproposta == 'FISICA'">
                                <button @click="confirmAgenda(show.candidatura.id)" class="btn btn-sm btn-success">Confirmar</button>
                            </span>
                            <router-link v-bind:to="'/agenda/' + show.id" tag="button" class="btn btn-sm btn-info">Reagendar</router-link>
                        </span>
                        <span v-if="show.candidatura.status != 'ENTREVISTA CANCELADA'">
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
            <jw-pagination :items="displayAgenda" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
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

                candidaturas: [],
                isModalShowMore: false,
                isModalWarning: false,
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
                }else{
                    this.isModalWarning = true;
                    this.candidatura_id = id;
                    console.log('candidatura_id', this.candidatura_id);
                }
            },

            closeModal(){
              this.isModalWarning = false;
              this.isModalShowMore = false;
            },

            vagaDaCandidatura(vaga_id){
                this.toggle = true;
                this.vaga_id = vaga_id;
            },

            async confirmAgenda(candidatura_id){

                let candidatura = {
                    candidatura_id: candidatura_id
                }

                await this.$store.dispatch('confirmAgenda', candidatura)
                .then(response => {
                    console.log(response)
                }).catch(error => console.log(error))
            },

            async cancelAgenda(){

                let cancelAgenda = {
                    observacao: this.observacao,
                    candidatura_id: this.candidatura_id
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

        },

    }
</script>

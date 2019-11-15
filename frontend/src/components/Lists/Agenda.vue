<template>
    <div class="row justify-content-center">
     <div class="col-md-9">
      <painel>
        <template v-slot:panel-head>
          <h2>Entrevistas Agendadas</h2>
        </template>
      </painel>
      <h2>Entrevistas Agendadas</h2>
      <div class="row" v-if="permissaoDoUsuario === 'JURIDICA'">
        <div >
            <div v-for="show in pageOfItems" :key="show.id" :id="show.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="label label-info ">Candidato: {{show.candidatura.curriculo.fisica.user.name}}</span></h3>
                    </template>
                    <template v-slot:card-body>
                    <p>Vaga: {{show.candidatura.vaga.titulo}}</p>
                    <p>Data: {{show.data | dateFormat}}</p>
                    <p>Hora: {{show.hora}}</p>
                    <p>Observação: {{show.observacao}}</p>
                    </template>
                    <template v-slot:card-footer>
                        <router-link v-bind:to="'/agenda/' + show.id" tag="button" class="btn btn-sm btn-info">Reagendar</router-link>
                        <button @click="showModal('warning', show.id)" class="btn btn-sm btn-danger">Cancelar</button>
                              <Modal v-show="isModalWarning" @close="closeModal">
                                <template v-slot:header>
                                  <h3>Deletar Conta</h3>
                                </template>
                                <template v-slot:body>
                                  <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> essa entrevista?</h2>
                                  <h6 class="text-center">Essa ação não poderá ser desfeita!</h6>
                                </template>
                                <template v-slot:footer>
                                    <button @click="cancelAgenda" class="btn btn-md btn-danger">Sim</button>
                                    <button @click="closeModal" class="btn btn-md btn-success">Não</button>
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
                agenda_id: 0,
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
                    this.agenda_id = id;
                    console.log('agenda_id', this.agenda_id);
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

            updateAgenda(id){
                this.$session.set('updateAgenda', id);
                this.$router.push({ name: 'new-agenda'})
            },

            async cancelAgenda(){
                await this.$store.dispatch('cancelAgenda', this.agenda_id)
                .then(response => {
                   this.isModalWarning = false;
                }).catch(error => console.log(error))
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

        },

    }
</script>

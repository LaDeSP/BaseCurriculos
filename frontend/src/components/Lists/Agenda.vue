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
                    <p>Data: {{show.data | dateFormat}}</p>
                    <p>Hora: {{show.hora}}</p>
                    </template>
                    <template v-slot:card-footer>
                        <button @click="newAgenda(show.id)" class="btn btn-sm btn-info">Reagendar</button>
                        <button @click="cancelAgenda(show.id)" class="btn btn-sm btn-danger">Cancelar</button>
                    </template>
                </Card>
            </div>
            <jw-pagination :items="agenda" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
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
                'loadAgenda'
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

            newAgenda(id){
                this.$session.set('editarAgenda', id);
                this.$router.push({ name: 'new-agenda'})
            }
        },

        computed: {
            ...mapGetters([
                'permissaoDoUsuario', 
            ]),
            ...mapState([
                'agenda'
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
            console.log('agenda', this.$store.state.agenda)

        },

    }
</script>

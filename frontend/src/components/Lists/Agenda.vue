<template>
    <div class="row justify-content-center">
     <div class="col-md-9">
      <painel>
        <template v-slot:panel-head>
          <h2>Candidaturas</h2>
        </template>
      </painel>

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

            newAgenda(candidato_id){
                this.$session.set('candidato_id', candidato_id);
                this.$router.push({ name: 'new-agenda'})
            }
        },

        computed: {
            ...mapGetters([
                'displayCandidaturas', 'permissaoDoUsuario', 'displayCandidaturasByVaga', 'displayCandidatoById'
            ]),
            ...mapState([
                'vagasCandidaturas', 'agenda'
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
            await this.loadAgenda();
            console.log('agenda', this.$store.state.agenda)

        },

    }
</script>

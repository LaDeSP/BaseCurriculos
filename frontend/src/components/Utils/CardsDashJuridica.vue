<template>
<span v-if="isFetching || isRefreshingToken">
 <center><h1>
    Carregando...  <span class="fas fa-spinner fa-pulse"></span>
 </h1></center>
</span>
<span v-else>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-home fa-sm"></i> Home </h1>
  </div>
    <div class="row">
      <div class="col-xl-6 col-md-12 mb-8 margin-bottom">
        <card class="border-left-primary shadow h-100">
            <template v-slot:card-header class="py-3">
              <router-link to="/vagas" class="font-weight-bold text-primary text-uppercase mb-1">Minhas Vagas</router-link>
            </template>
            <template v-slot:card-body>
              <div class="row no-gutters align-items-center">
               <div class="col mr-2">
                  <center>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <h2>{{countVagas}}</h2>
                      <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                  </center>
               </div>
                <div class="col-auto">

                </div>
              </div>
            </template>
        </card>
      </div>
      <div class="col-xl-6 col-md-12 mb-8 margin-bottom">
        <card class="border-left-success shadow h-100">
          <template v-slot:card-header class="py-3">
            <router-link to="/candidaturas" class="font-weight-bold text-success text-uppercase mb-1">Candidaturas</router-link>
            </template>
            <template v-slot:card-body>
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <center>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <h2>{{count.candidaturas}}</h2>
                      <i class="fas fa-file"></i>
                    </div>
                  </center>
                </div>
              </div>
            </template>
        </card>
      </div>
      <div class="col-xl-6 col-md-12 mb-8 margin-bottom">
        <card class="border-left-warning shadow h-100">
          <template v-slot:card-header class="py-3">
            <router-link to="/convites" class="font-weight-bold text-warning text-uppercase mb-1">Convites</router-link>
            </template>
            <template v-slot:card-body>
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <center>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <h2>{{countConvites.convites}}</h2>
                      <i class="fas fa-envelope"></i>
                    </div>
                  </center>
                </div>
              </div>
            </template>
        </card>
      </div>
       <div class="col-xl-6 col-md-12 mb-8 margin-bottom">
        <card class="border-left-info shadow h-100">
          <template v-slot:card-header class="py-3">
            <router-link to="/agenda" class="font-weight-bold text-info text-uppercase mb-1">Agenda</router-link>
            </template>
            <template v-slot:card-body>
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <center>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <h2>{{countConvites.convites}}</h2>
                      <i class="fas fa-calendar-alt"></i>
                    </div>
                  </center>
                </div>
              </div>
            </template>
        </card>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 mb-4 margin-bottom">
        <card class="shadow mb-4">
            <template v-slot:card-header class="py-3">
              <h6 class="m-0 font-weight-bold text-primary">Processos em Andamento</h6>
            </template>
            <template v-slot:card-body>
              <div v-if="progressBar.length>0">
                <div v-for="vaga in pageOfItems" :key="vaga.id">
                  <h4 class="small font-weight-bold">"{{vaga.titulo}}" <span class="float-right"> De {{vaga.quantidade}} vagas faltam {{vaga.quantidade - vaga.quantidadeContratados}}</span></h4>
                  <div class="mb-4">
                    <b-progress :value="vaga.porcentagem" variant="success" :striped="striped"></b-progress>
                  </div>
                </div>
                <div class="d-flex justify-content-center withoutPreviusNext" v-if="progressBar.length > 3">
                  <jw-pagination :items="progressBar" @changePage="onChangePage" :pageSize="3" :labels="customLabels"></jw-pagination>
                </div>
                <div class="d-flex justify-content-center withoutPreviusNext display-none" v-else>
                  <jw-pagination :items="progressBar" @changePage="onChangePage" :pageSize="3" :labels="customLabels"></jw-pagination>
                </div>
              </div>
              <div v-else>
                <h3> Nenhuma Vaga Cadastrada </h3>
              </div>
            </template>
        </card>
      </div>
      <div class="col-lg-6 mb-6 margin-bottom">
        <card class="shadow mb-4 margin-bottom">
            <template v-slot:card-header class="py-3">
               <center><h6 class="font-weight-bold text-primary text-success  text-uppercase">Entrevistas</h6></center>
            </template>
            <template v-slot:card-body >
                <div class="row">
                  <div class="col-sm-6">
                    <div class=" font-weight-bold text-success text-uppercase mb-1">
                      <center>
                        <h6> <small>Confirmadas</small></h6>
                        <h1 class="float-none">{{count.candidaturasConfirmadas}} <i class="fas fa-check-circle"></i></h1>
                      </center>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class=" font-weight-bold text-warning text-uppercase mb-1">
                      <center>
                        <h6><small>Em agendamento</small></h6>
                        <h1 class="float-none">{{count.candidaturasEmAgendamento}}<span class="fas fa-spinner fa-pulse"></span></h1>
                      </center>
                    </div>
                  </div>
                </div>
            </template>
        </card>
      </div>
  </div>
</span>
</template>

<script>
  import card from '../Utils/Card';
  import {mapState, mapGetters, mapActions} from 'vuex';
import { BProgress } from 'bootstrap-vue'
import JwPagination from 'jw-vue-pagination';
  const customLabels = {
      next: '>',
      previous: '<',
  };


  export default{
    data() {
      return {
        vaga: null,
        candidato: null,
        data: '',
        hora: '',
        observacao: '',
        striped: true,
        pageOfItems: [],
        customLabels
      }
    },
    components:{
      card, BProgress, JwPagination
    },

    methods: {

      onChangePage(pageOfItems) {
        // update page of items
        this.pageOfItems = pageOfItems;
      },

       ...mapActions([
            'getVagasPorcentagem', 'loadCandidaturas', 'getConvites', 'loadVagasJuridica'
        ]),

      agendar(){

        let newAgendaData = {
          data: this.data,
          hora: this.hora,
          observacao: this.observacao,
          candidatura_id: this.candidato
        }

        this.$store.dispatch('newAgenda', newAgendaData)
        .then( response => {
          if(response.error  != undefined){
            this.notificacoes = response.error;
          }

        })
        .catch(error => console.log(error))
      }
    },

    computed:{
      ...mapState([
          'count', 'countVagas', 'vagasCandidaturas', 'countConvites', 
          'isFetching', 'isRefreshingToken'
      ]),
      ...mapGetters([
        'displayCandidaturas', 'progressBar'
      ]),
    },
    async created(){
      await this.getVagasPorcentagem();
      await this.getConvites();
      await this.loadCandidaturas();
      await this.loadVagasJuridica();
    }
  }

</script>


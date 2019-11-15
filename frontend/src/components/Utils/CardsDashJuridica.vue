<template>
<div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-home fa-sm"></i> Home </h1>
  </div>
    <div class="row">
      <div class="col-xl-6 col-md-12 mb-8">
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
      <div class="col-xl-6 col-md-12 mb-8">
        <card class="border-left-success shadow h-100">
          <template v-slot:card-header class="py-3">
            <router-link to="/candidaturas" class="font-weight-bold text-success text-uppercase mb-1">Candidaturas</router-link>
            </template>
            <template v-slot:card-body>
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <center>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <h2>{{countCandidaturas}}</h2>
                      <i class="fas fa-file"></i>
                    </div>
                  </center>
                </div>
              </div>
            </template>
        </card>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 mb-4">
        <card class="shadow mb-4">
            <template v-slot:card-header class="py-3">
              <h6 class="m-0 font-weight-bold text-primary">Processos em Andamento</h6>
            </template>
            <template v-slot:card-body>
              <h4 class="small font-weight-bold">"Panfletagem" <span class="float-right"> De 7 vagas falta 1</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 90%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold">"Gerente" <span class="float-right"> As vagas estão completas</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold"> "Encaixotador" <span class="float-right">As vagas estão completas</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold"> "Atendentes" <span class="float-right">De 5 vagas faltam 1</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-info" role="progressbar" style="width: 90%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                </div>
              </div>
              <h4 class="small font-weight-bold"> "Supervisor" <span class="float-right">As vagas estão completas</span></h4>
              <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                </div>
              </div>
            </template>
        </card>
      </div>
      <div class="col-lg-6 mb-6">
        <div class="row">
          <div class="col-sm-12">
            <div v-if="countCandidaturas > 0">
               <card>
                <template v-slot:card-header>
                  <h6 class="font-weight-bold text-primary text-success  text-uppercase mb-1">Agendar Entrevista</h6>
                </template>
                <template v-slot:card-body>
                  <div class="input-group">
                    <div class="input-group-predend">
                      <span class="input-group-text">Vaga:</span>
                    </div>
                  <select class="custom-select" name="vaga" v-model="vaga">
                      <option disabled value="">Selecione a vaga</option>
                      <option v-for="show in vagasCandidaturas" :key="show.id" :value="show.id">
                          {{show.vaga.titulo}}
                      </option>
                  </select>
                  </div>
                  <br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Candidato:</span>
                    </div>
                    <select :disabled="vaga == null" class="custom-select" name="candidato" v-model="candidato">
                      <option disabled value="">Selecione o candidato</option>
                      <option v-for="show in displayCandidaturas" :key="show.id" :value="show.id">
                          <span v-if="vaga == show.vaga.id">{{show.curriculo.fisica.user.name}}</span> 
                      </option>
                    </select>
                  </div>
                  <br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Data:</span>
                    </div>
                   <input type="date" class="form-control" name="data" v-model="data">
                  </div>
                  <br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Hora:</span>
                    </div>
                   <input type="time" name="hora" class="form-control" v-model="hora">
                  </div>
                   <br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Observação:</span>
                    </div>
                    <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                  </div>
                  <br>
                  <center><button @click.prevent="agendar" class="btn btn-primary"> Agendar</button></center>
                </template>
              </card>
            </div>
            <div v-else>
              <card>
                <template>
                  <h6 class="font-weight-bold text-primary text-success  text-uppercase mb-1">Não há candidatos ainda!</h6>
                </template>
                <template v-slot:card-body>
                  
                </template>
              </card>
            </div>
          </div>
        </div>
        <card class="shadow mb-4">
            <template v-slot:card-header class="py-3">
               <h6 class="font-weight-bold text-primary text-success  text-uppercase mb-1">Agendamentos</h6>
            </template>
            <template v-slot:card-body >
              <div class="container">
                <div class="row">
                  <div class="col-sm">
                    <div class=" font-weight-bold text-success text-uppercase mb-1">
                      <center>
                        <h5>Confirmados</h5>
                        <h1 class="float-none">{{countCandidaturasConfirmadas}} <i class="fas fa-check-circle"></i></h1>
                      </center>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class=" font-weight-bold text-warning text-uppercase mb-1">
                      <center>
                        <h5>Aguardando</h5>
                        <h1 class="float-none">{{countCandidaturasAguardando}} <span class="fas fa-spinner fa-pulse"></span></h1>
                      </center>
                    </div>
                  </div>
                </div>
              </div>
            </template>
        </card>
      </div>
  </div>
</div>
</template>

<script>
  import card from '../Utils/Card';
  import {mapState, mapGetters} from 'vuex';

  export default{
    data() {
      return {
        vaga: null,
        candidato: null,
        data: '',
        hora: '',
        observacao: '',
      }
    },
    components:{
      card
    },

    methods: {

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
            console.log('response', response);

        })
        .catch(error => console.log(error))
      }
    }, 

    computed:{
      ...mapState([
        'countVagas', 'countCandidaturas', 'countAgenda', 
        'countCandidaturasConfirmadas', 'countCandidaturasAguardando',
        'vagasCandidaturas'
      ]),
      ...mapGetters([
        'displayCandidaturas'
      ]),
    }
  }

</script>


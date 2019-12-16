<template>
<span v-if="isFetching == true || isRefreshingToken == true">
 <center><h1>
    Carregando...  <span class="fas fa-spinner fa-pulse"></span>
 </h1></center>
</span>
<span v-else>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-home fa-sm"></i> Home</h1>
  </div>
    <div class="row">
      <div class="col-xl-12 col-lg-12">
        <card class="border-left-primary shadow h-100">
            <template v-slot:card-header class="py-3">
              <center><router-link to="/candidaturas" class="font-weight-bold text-primary text-uppercase mb-1">Minhas Candidaturas</router-link></center>
            </template>
            <template v-slot:card-body>
              <div class="align-items-center">
                <template v-if="countCandidaturas == 0 || displayCandidaturas == 0">
                  <div class="container justify-content-center">
                    <h2>Nenhuma Candidatura Realizada!</h2>
                  </div>
                </template>
                <template v-else>
                  <div class="card-group">
                    <div class="col-lg-12">
                      <div class="row">
                        <Card class="col-sm-4 mb-2 ml-2" v-for="show in display3Candidaturas" :key="show.id">
                          <template v-slot:card-header >
                              <center><h5>{{show.vaga.titulo}}</h5></center>
                          </template>
                          <template v-slot:card-body>
                            <!-- <div class=" font-weight-bold text-success text-uppercase mb-1"></div>para o texto ficar verde -->
                            <div v-if="show.status === 'AGUARDANDO'"  class=" font-weight-bold text-warning text-uppercase">
                              <center><h5>{{show.status}}</h5><h1 class="float-none"> <span class="fas fa-spinner fa-pulse"></span></h1></center>
                            </div>
                            <div v-if="show.status === 'EM AGENDAMENTO'"  class=" font-weight-bold text-warning text-uppercase">
                              <center><h5>{{show.status}}</h5><h1 class="float-none"> <span class="fas fa-spinner fa-pulse"></span></h1></center>
                            </div>
                            <div v-if="show.status === 'ENTREVISTA CONFIRMADA'"  class=" font-weight-bold text-success text-uppercase">
                              <center><h5>{{show.status}}</h5><h1 class="float-none"> <span class="fas fa-check-circle"></span></h1></center>
                            </div>
                            <div v-if="show.status === 'RECUSADO'"  class=" font-weight-bold text-danger text-uppercase">
                              <center><h5>A empresa decidiu não dar continuidade no seu processo de contratação.</h5><h1 class="float-none"> <span class="fas fa-frown-open"></span></h1></center>
                            </div>
                            <div v-if="show.status === 'ENTREVISTA CANCELADA'"  class=" font-weight-bold text-danger text-uppercase">
                              <center><h5>{{show.status}}</h5><h1 class="float-none"> <span class="fas fa-calendar-times"></span></h1></center>
                            </div>
                            <div v-if="show.status === 'CONTRATADO'"  class=" font-weight-bold text-success text-uppercase">
                              <center><h5>{{show.status}}</h5><h1 class="float-none"> <span class="fas fa-smile"></span></h1></center>
                            </div>
                          </template>
                        </Card>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </template>
            <template v-slot:card-footer>
              <div v-if="countCandidaturas != 0 && displayCandidaturas != 0">
                <center><router-link to="/candidaturas" class="btn btn-lg btn-primary">Ver Mais <span class="fa fa-eye"></span></router-link></center>
              </div>
            </template>
        </card>
      </div>
    </div>
    <br>
    <div class="row align-content-center">
    <div class="col-6">
        <card class="border-left-warning shadow h-100">
          <template v-slot:card-header class="py-3">
            <center><router-link to="/convites" class="font-weight-bold text-warning text-uppercase card-title">Convites</router-link></center>
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
      </div>
    <br>

    <div v-if="isActive.length>0" class="margin-bottom">
      <center class="justify-content-center mb-4">
        <h2>Vagas que podem lhe interessar</h2>
      </center>

      <div class="card-deck">
        <div class="col-lg-12">
          <div class="row">
            <Card class="col-sm-6" v-for="vaga in pageOfItems" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
              <template v-slot:card-header>
                <h3 class="card-title" style="color: #4E73DF;">{{vaga.titulo}}</h3>
              </template>
              <template v-slot:thumbnail></template>
              <template v-slot:card-body>
                  <p class="card-text"><strong>Cargo:</strong> {{vaga.cargo}}</p>
                  <p class="card-text"><strong>Área de Atuação:</strong> {{vaga.area.tipo}}</p>
                  <p class="card-text"><strong>Jornada de Trabalho:</strong> {{vaga.jornada}}</p>
              </template>
              <template v-slot:card-footer>
                <button @click="showModal('else', vaga.id)" class="btn btn-sm btn-default">Ver mais</button>
                <template v-if="dataCompleted">
                    <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button>
                </template>
                <template v-else>
                  <router-link to="/new-curriculo" class="btn btn-sm btn-info">Preencha seu currículo para se candidatar!</router-link>
                </template>
                <Modal v-if="isModalShowMore" @close="closeModal">
                  <template v-slot:header><h3>Detalhes da Vaga</h3></template>
                  <template v-slot:body>
                    <h3 class="mb-1" style="color: #4E73DF;">{{vagaById[0].titulo}}</h3>
                    <br>
                    <p class="card-text"><strong>Descrição:</strong> {{vagaById[0].descricao}}</p>
                    <p class="card-text"><strong>Cargo: </strong>{{vagaById[0].cargo}}</p>
                    <p class="card-text"><strong>Área de Atuação:</strong> {{vagaById[0].area.tipo}}</p>
                    <p class="card-text"><strong>Jornada de Trabalho: </strong>{{vagaById[0].jornada}}</p>
                    <p class="card-text"><strong>Salário:</strong> {{vagaById[0].salario}}</p>
                    <p class="card-text"><strong>Benefícios: </strong>{{vagaById[0].beneficio}}</p>
                    <p class="card-text"><strong>Requisitos:</strong> {{vagaById[0].requisito}}</p>
                  </template>
                  <template v-slot:footer>
                    <button @click="closeModal" class="btn btn-sm btn-outline-default">Voltar</button>
                    <div v-if="dataCompleted">
                        <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button>
                    </div>
                    <div v-else>
                      <router-link to="/new-curriculo" class="btn btn-sm btn-info">Preencha seu currículo para se candidatar!</router-link>
                    </div>
                  </template>
                </Modal>
              </template>
            </Card>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="trocaPagina" v-if="isActive.length > 6">
          <jw-pagination :items="isActive" @changePage="onChangePage" :pageSize="6" :labels="customLabels"></jw-pagination>
        </div>
        <div class="trocaPagina display-none" v-else>
          <jw-pagination :items="isActive" @changePage="onChangePage" :pageSize="6" :labels="customLabels"></jw-pagination>
        </div>
      </div>
      <Modal v-if="isModalSuccess" @close="closeModal">
        <template v-slot:header></template>
        <template v-slot:body>
              <b-alert show variant="success">
                <h1>Candidatura realizada com sucesso!</h1>
            </b-alert>
        </template>
        </Modal>
    </div>
</span>
</template>

<script>
  import Card from '../Utils/Card';
  import Modal from '../Utils/ModalOld';
  import List from '../Utils/List';
  import painel from '../Utils/Painel';
 import { mapActions, mapGetters, mapState } from 'vuex';
 import JwPagination from 'jw-vue-pagination';
 import { BAlert } from 'bootstrap-vue'

  const customLabels = {
      first: 'Primeira',
      last: 'Última',
      previous: 'Anterior',
      next: 'Próxima'
  };

  export default{
    components:{
     Card, Modal, List,painel, JwPagination, BAlert
    },

    data(){
        return{
          vagas: [],
          vaga_id: 0,
          filterState: true,
          isModalWarning: false,
          isModalShowMore: false,
          isModalSuccess: false,
          pageOfItems: [],
          customLabels
        }
    },
        methods: {
          ...mapActions([
              'getVagasRecomendadas', 'loadCandidaturas', 'getConvites'
          ]),

          onChangePage(pageOfItems) {
            // update page of items
            this.pageOfItems = pageOfItems;
          },

          showModal(modal, vaga_id){
            if(modal === 'warning'){
              this.isModalWarning = true;
              this.vaga_id = vaga_id;
            }else{
              this.isModalShowMore = true;
              this.vaga_id = vaga_id;
            }
          },

          closeModal(){
              this.isModalWarning = false;
              this.isModalShowMore = false;
              if (this.isModalSuccess == true){
                this.getVagasRecomendadas();
                this.isModalSuccess = false;
              }
              this.isModalSuccess = false;
          },

          onCreate(){
              this.$session.set('editing', false);
              this.$router.push({ name: 'new-vaga'})
          },

          onEdit(vaga_id){
              this.$session.set('editing', true);
              this.$session.set('vaga_id', vaga_id);
              this.$router.push({ name: 'new-vaga'})
          },

          onRequest(id){
              let vaga_id = 0;
              if(this.vaga_id != 0){
                vaga_id = this.vaga_id;
              }else{
                vaga_id = id;
              }

              let requestVaga = {
                vaga_id: vaga_id,
                user_id: this.$store.state.auth.user.id
              }
              this.$store.dispatch('requestVagaDash', requestVaga)
              .then(response => {
                  this.isModalShowMore = false;
                  this.isModalSuccess = true;
              }).catch(error => console.log(error))
          },

          changeStatus(id, status){
              let newStatus = {
                vaga_id: id,
                status: status
              }

              this.$store.dispatch('changeStatusVaga', newStatus)
              .then(response => {

              }).catch(error => console.log(error))

          },

          async onDelete(){

              await this.$store.dispatch('deleteVaga', this.vaga_id)
              .then(response => {
                  this.isModalWarning = false;
              }).catch(error => console.log(error))
          },

          changeActiveButton(status){

            $('.btn-group').on('click', '.btn', function() {
                $(this).addClass('active').siblings().removeClass('active');
            });
            if(status === 'ativa'){
                this.filterState = true;
            }else{
                this.filterState = false;
            }
          }
        },

          computed:{
             isActive(){
                if(this.permissaoDoUsuario === 'FISICA'){
                    return this.displayVagasJuridica.filter((vaga) => {return vaga.status === 'ATIVA';})
                }else{
                    if(this.filterState === true){
                        return this.displayVagasJuridica.filter((vaga) => {return vaga.status === 'ATIVA'})
                    }else{
                        return this.displayVagasJuridica.filter((vaga) => {return vaga.status === 'INATIVA'})
                    }
              }
            },

            ...mapState([
              'countCandidaturas', 'candidaturas', 'countConvites', 'isFetching', 'isRefreshingToken'
            ]),

            display3Candidaturas(){

              return this.displayCandidaturas.slice(0,3)

            },

            ...mapGetters([
              'displayVagasJuridica', 'displayVagaById', 'permissaoDoUsuario',
              'dataCompleted', 'displayCandidaturas'
            ]),

            vagaById(){
              return this.displayVagaById(this.vaga_id)
            }

          },

          async created(){
            await this.loadCandidaturas();
            await this.getVagasRecomendadas();
            await this.getConvites();

          },
    }
</script>

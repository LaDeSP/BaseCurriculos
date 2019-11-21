<template>
<div>
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
              <div class="row no-gutters align-items-center">
                  <div class="h2 mb-0 font-weight-bold text-gray-900">
                    <div class="row no-gutters align-items-center">
                      <template v-if="countCandidaturas == 0 || displayCandidaturas == 0">
                        Nenhuma candidatura realizada!
                      </template>
                      <template v-else>
                          <div v-for="show in display3Candidaturas" :key="show.id">
                            <cardvagas style="width: 17rem;">
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
                                  <center><h5>{{show.status}}</h5><h1 class="float-none"> <span class="fas fa-frown-open"></span></h1></center>
                                </div>
                                <div v-if="show.status === 'ENTREVISTA CANCELADA'"  class=" font-weight-bold text-danger text-uppercase">
                                  <center><h5>{{show.status}}</h5><h1 class="float-none"> <span class="fas fa-calendar-times"></span></h1></center>
                                </div>
                                 <div v-if="show.status === 'CONTRATADO'"  class=" font-weight-bold text-success text-uppercase">
                                  <center><h5>{{show.status}}</h5><h1 class="float-none"> <span class="fas fa-smile"></span></h1></center>
                                 </div>
                              </template>
                            </cardvagas>
                        </div>
                      </template>
                    </div>

                  </div>

                <div class="col-auto">

                </div>
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

    <div class="container-fluid" v-if="isActive.length>0">
        <template v-if="permissaoDoUsuario === 'FISICA'">
          <h2>Vagas que podem lhe interessar</h2>
          <br>
          <div class="row justify-content-center">
            <div  v-for="vaga in pageOfItems" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
            <Card style="width: 20rem; height:5rem" class="igualdade">
              <template v-slot:card-header>
                  <h3 class="mb-1" style="color: #4E73DF;">{{vaga.titulo}}</h3>
              </template>
              <template v-slot:card-body>
                  <p class="mb-1"><strong>Cargo:</strong> {{vaga.cargo}}</p>
                  <p class="mb-1"><strong>Área de Atuação:</strong> {{vaga.area.tipo}}</p>
                  <p class="mb-1"><strong>Jornada de Trabalho:</strong> {{vaga.jornada}}</p>
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
          <div class="row justify-content-center">
            <div class="trocaPagina" v-if="isActive.length > 6">
              <jw-pagination :items="isActive" @changePage="onChangePage" :pageSize="6" :labels="customLabels"></jw-pagination>
            </div>
            <div class="trocaPagina display-none" v-else>
              <jw-pagination :items="isActive" @changePage="onChangePage" :pageSize="6" :labels="customLabels"></jw-pagination>
            </div>
          </div>
        </template>
    </div>
</div>
</template>

<script>
  import card from '../Utils/Card';
  import cardvagas from '../Utils/Cards-fisica';
  import Card from '../Utils/CardsVagas';
  import Modal from '../Utils/ModalOld';
  import List from '../Utils/List';
  import painel from '../Utils/Painel';
 import { mapActions, mapGetters, mapState } from 'vuex';
 import JwPagination from 'jw-vue-pagination';
  const customLabels = {
      first: 'Primeira',
      last: 'Última',
      previous: 'Anterior',
      next: 'Próxima'
  };

  export default{
    components:{
      card,cardvagas,Card, Modal, List,painel, JwPagination
    },

    data(){
        return{
          vagas: [],
          vaga_id: 0,
          filterState: true,
          isModalWarning: false,
          isModalShowMore: false,
          pageOfItems: [],
          customLabels
        }
    },
        methods: {
          ...mapActions([
              'getVagasRecomendadas', 'loadCandidaturas'
          ]),

          onChangePage(pageOfItems) {
            // update page of items
            this.pageOfItems = pageOfItems;
          },

          showModal(modal, vaga_id){
            if(modal === 'warning'){
              this.isModalWarning = true;
              this.vaga_id = vaga_id;
              console.log('show', this.vaga_id)
            }else{
              console.log('no show', vaga_id);
              this.isModalShowMore = true;
              this.vaga_id = vaga_id;
              console.log('kkkk', this.vagaById)

            }
          },

          closeModal(){
              this.isModalWarning = false;
              this.isModalShowMore = false;
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
                  console.log(response)
                  this.isModalShowMore = false;
                  this.getVagasRecomendadas();
              }).catch(error => console.log(error))
          },

          changeStatus(id, status){
              let newStatus = {
                vaga_id: id,
                status: status
              }

              this.$store.dispatch('changeStatusVaga', newStatus)
              .then(response => {
                  console.log(response)
              }).catch(error => console.log(error))

          },

          async onDelete(){

              await this.$store.dispatch('deleteVaga', this.vaga_id)
              .then(response => {
                  this.isModalWarning = false;
                  console.log('no metodo', response)
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
            console.log('filtersTATE', this.filterState);
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
              'countCandidaturas', 'candidaturas'
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

          },
    }
</script>

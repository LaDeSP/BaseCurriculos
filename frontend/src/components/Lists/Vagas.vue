<template>
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="row">
        <div class="col-md-9 float-left" >
           <template v-if="permissaoDoUsuario === 'JURIDICA'">
             <painel>
              <template v-slot:panel-head>
                <h2>Minhas Vagas</h2>
              </template>
             </painel>
           </template>
           <template v-else>
             <painel>
              <template v-slot:panel-head>
                <h2>Vagas</h2>
              </template>
             </painel>
           </template>
        </div>

        <template v-if="permissaoDoUsuario === 'JURIDICA'">
          <div class="col-md-3 float-right" >
            <div class="btn-group btn-group-sm">
              <button @click="onCreate" type="button" class="btn btn-primary"><h4>Criar Vaga <span><i class="fa fa-plus"></i></span></h4></button>
            </div>
          </div>
        </template>
      </div>
      <br>
       <template v-if="permissaoDoUsuario === 'JURIDICA'">
        <div class="d-flex flex-row bd-highlight mb-3">
          <div class="p-2 bd-highlight">
            <div class="btn-group btn-group-sm" role="group">
                <button @click="changeActiveButton('ativa')" type="button" class="active btn btn-outline-success">Vagas Ativas</button>
                <button @click="changeActiveButton" type="button" class="btn btn-outline-secondary">Vagas Inativas</button>
            </div>
          </div>
        </div>
      </template>
      <div class="row">
          <div  v-for="vaga in pageOfItems" :key="vaga.id" :id="vaga.id">
            <template v-if="permissaoDoUsuario === 'JURIDICA'">
              <Card style="width: 30rem;">
                <template v-slot:card-header>
                  <h3><span class="label label-info " style="color: #4E73DF;">{{vaga.titulo}}</span></h3>
                </template>
                <template v-slot:card-body>
                  <p><strong>Descrição:</strong> {{vaga.descricao}}</p>
                  <p><strong>Cargo:</strong> {{vaga.cargo}}</p>
                  <p><strong>Status:</strong> {{vaga.status}}</p>
                  <p><strong>Quantidade:</strong> {{vaga.quantidade}}</p>
                  <p><strong>Área de Atuação:</strong> {{vaga.area.tipo}}</p>
                  <p><strong>Salário:</strong> {{vaga.salario}}</p>
                  <p><strong>Jornada de Trabalho:</strong> {{vaga.jornada}}</p>
                  <p><strong>Benefícios:</strong> {{vaga.beneficio}}</p>
                  <p><strong>Requisitos:</strong> {{vaga.requisito}}</p>
                </template>
                <template v-slot:card-footer>
                  <div>
                    <button @click="onEdit(vaga.id)" class="btn btn-sm btn-warning">Editar</button>
                    <span v-if="filterState">
                        <button @click="changeStatus(vaga.id, 'INATIVA')" class="btn btn-sm btn-outline-secondary">Desativar</button>
                    </span>
                    <span v-else>
                        <button @click="changeStatus(vaga.id, 'ATIVA')" class="btn btn-sm btn-outline-success">Ativar</button>
                    </span>
                    <button @click="showModal('warning', vaga.id)" class="btn btn-sm btn-danger">Deletar</button>
                    <Modal v-show="isModalWarning" @close="closeModal">
                        <template v-slot:header><h3>Deletar Vaga</h3></template>
                        <template v-slot:body>
                            <h2 class="text-center">Tem certeza de que deseja
                                <span style="color: #ff0000"><strong>deletar</strong></span>
                                essa vaga?</h2>

                        </template>
                        <template v-slot:footer>
                        <div>
                            <button @click="onDelete" class="btn btn-lg btn-danger">Sim</button>
                            <button @click="closeModal" class="btn btn-lg btn-success">Não</button>
                        </div>
                        </template>
                    </Modal>
                  </div>
                </template>
              </Card>
            </template>
          </div>
          <jw-pagination :items="isActive" @changePage="onChangePage" :pageSize="10" :labels="customLabels" v-if="permissaoDoUsuario === 'JURIDICA'"></jw-pagination>
      </div>
      <template v-if="permissaoDoUsuario === 'FISICA'">
        <div  v-for="vaga in pageOfItems" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
        <List>
          <template v-slot:list-header>
              <h3 class="mb-1" style="color: #4E73DF;">{{vaga.titulo}}</h3>
          </template>
          <template v-slot:list-body>
              <p class="mb-1"><strong>Cargo:</strong> {{vaga.cargo}}</p>
              <p class="mb-1"><strong>Área de Atuação:</strong> {{vaga.area.tipo}}</p>
              <p class="mb-1"><strong>Jornada de Trabalho:</strong> {{vaga.jornada}}</p>
          </template>
          <template v-slot:list-footer>
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
                    <p class="mb-1"><strong>Descrição:</strong> {{vagaById[0].descricao}}</p>
                    <p class="mb-1"><strong>Cargo: </strong>{{vagaById[0].cargo}}</p>
                    <p class="mb-1"><strong>Área de Atuação:</strong> {{vagaById[0].area.tipo}}</p>
                    <p class="mb-1"><strong>Jornada de Trabalho: </strong>{{vagaById[0].jornada}}</p>
                    <p class="mb-1"><strong>Salário:</strong> {{vagaById[0].salario}}</p>
                    <p class="mb-1"><strong>Benefícios: </strong>{{vagaById[0].beneficio}}</p>
                    <p class="mb-1"><strong>Requisitos:</strong> {{vagaById[0].requisito}}</p>
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
          </List>
        </div>
        <jw-pagination :items="isActive" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
      </template>
    </div>
  </div>
</template>


<script>
  import Card from '../Utils/CardsVagas';
  import Modal from '../Utils/ModalOld';
  import List from '../Utils/List';
  import painel from '../Utils/Painel';
  import { mapActions, mapGetters } from 'vuex';
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

            vagas: [],
            vaga_id: 0,
            filterState: true,
            isModalWarning: false,
            isModalShowMore: false,
            pageOfItems: [],
            customLabels,

        }
    },
    components: {Card, Modal, List,painel, JwPagination},
        methods: {
          ...mapActions([
              'loadVagasJuridica'
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
              this.$store.dispatch('requestVaga', requestVaga)
              .then(response => {
                  console.log(response)
                  this.isModalShowMore = false;
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

            ...mapGetters([
              'displayVagasJuridica', 'displayVagaById', 'permissaoDoUsuario', 'dataCompleted'
            ]),

            vagaById(){
              return this.displayVagaById(this.vaga_id)
            }

          },

          created(){
            this.loadVagasJuridica();
          },
    }
</script>

<template>
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="row">
        <div class="col-md-10 float-left" >
          <div class="panel-heading"><h2> {{this.displayVagasJuridica}}Minhas Vagas</h2></div>
        </div>
        <div class="col-md-2 float-right" >
          <div class="btn-group btn-group-sm">
            <button @click="onCreate" type="button" class="btn btn-primary"><h4>Criar Vaga <span><i class="fa fa-plus"></i></span></h4></button>
          </div>
        </div>
      </div>
      <br>
      <div class="d-flex flex-row bd-highlight mb-3">
        <div class="p-2 bd-highlight">
          <div class="btn-group btn-group-sm" role="group">
              <button @click="changeActiveButton('ativa')" type="button" class="active btn btn-outline-success">Vagas Ativas</button>
              <button @click="changeActiveButton" type="button" class="btn btn-outline-secondary">Vagas Inativas</button>
          </div>
        </div>
      </div>
      <div class="row">
          <div  v-for="vaga in isActive" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
            <Card style="width: 30rem;">
              <template v-slot:card-header>
                <h3><span class="label label-info ">{{vaga.titulo}}</span></h3>
              </template>
              <template v-slot:card-body>
                <p>Local:{{vaga.local}}</p>
                  <p>Status:{{vaga.status}}</p>
                <p>Quantidade: {{vaga.quantidade}}</p>
                <p>Área de Atuação: {{vaga.area.tipo}}</p>
                <p>Salário: {{vaga.salario}}</p>
                <p>Jornada de Trabalho: {{vaga.jornada}}</p>
                <p>Benefícios: {{vaga.beneficio}}</p>
                <p>Requisitos: {{vaga.requisito}}</p>
              </template>
              <template v-slot:card-footer>
                <div v-if="permissaoDoUsuario === 'FISICA'">
                    <router-link v-bind:to="'' + vaga.id" tag="button" class="btn btn-sm btn-default">Ver mais</router-link>
                    <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button>
                </div>
                <div v-else>
                  <button @click="onEdit(vaga.id)" class="btn btn-sm btn-warning">Editar</button>
                  <span v-if="filterState">
                      <button @click="changeStatus(vaga.id, 'INATIVA')" class="btn btn-sm btn-outline-secondary">Desativar</button>
                  </span>
                  <span v-else>
                      <button @click="changeStatus(vaga.id, 'ATIVA')" class="btn btn-sm btn-outline-success">Ativar</button>
                  </span>
                  <button @click="showModal" class="btn btn-sm btn-danger">Deletar</button>
                  <Modal v-show="isModalWarning" @close="closeModal">
                      <template v-slot:header><h3>Deletar Vaga</h3></template>
                      <template v-slot:body>
                          <h2 class="text-center">Tem certeza de que deseja
                              <span style="color: #ff0000"><strong>deletar</strong></span>
                              essa vaga?</h2>

                      </template>
                      <template v-slot:footer>
                      <div class="modal-footer">
                          <button @click="onDelete(vaga.id)" class="btn btn-lg btn-danger">Sim</button>
                          <button @click="closeModal" class="btn btn-lg btn-success">Não</button>
                      </div>
                      </template>
                  </Modal>
                </div>
              </template>
            </Card>
          </div>
        </div>
    </div>
  </div>
</template>


<script>
  import Card from '../Utils/CardsVagas';
  import Modal from '../Utils/Modal';
  import { mapActions, mapGetters } from 'vuex';

    export default {
    data(){
        return{

            vagas: [],
            filterState: true,
            isModalWarning: false,
        }
    },
    components: {Card, Modal},
        methods: {
          ...mapActions([
              'loadVagasJuridica'
          ]),

          showModal(){
              this.isModalWarning = true;
          },

          closeModal(){
              this.isModalWarning = false;
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

          onRequest(vagaId){

              const vaga_id = vagaId;
              this.axios.post('http://localhost:8000/api/candidaturas?token=' + this.token,
                  {
                      vaga_id: vaga_id,
                      user_id: this.$session.get('user_id')
                  },
                  {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                  .then(
                      (response) => console.log(response),
                  )
                  .catch(
                      (error) => console.log(error),

                  );

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

          onDelete(id){

              this.$emit('vagaDeleted', id);

              this.axios.delete(this.uri + '/' + id + '?token=' + this.token)
                  .then(
                      response => console.log(response),
                  )
                  .catch(
                      error => console.log(error)
                  );

              this.$store.dispatch('deleteFisica')
              .then(response => {
                  //console.log(response)
                  this.$router.push({ name: 'login' })
              }).catch(error => console.log(error))

          },

        onVagaDeleted(id){
            const position = this.vagas.findIndex((element) => {
                return element.id == id;
            });

            this.vagas.splice(position, 1);
        },

        changeActiveButton(tipo){

            $('.btn-group').on('click', '.btn', function() {
                $(this).addClass('active').siblings().removeClass('active');
            });
            if(tipo === 'ativa'){
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
              'displayVagasJuridica', 'permissaoDoUsuario'
            ]),

        },

         watch: {
          '$store.state.vagasJuridica':{
            handler() { 
             
            },
            
            deep: true
          }
        },
        
        created(){
            this.loadVagasJuridica();

        },
    }
</script>

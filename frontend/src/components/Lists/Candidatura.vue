<template>
    <div class="row justify-content-center">
     <div class="col-md-9">
      <painel>
        <template v-slot:panel-head>
          <h2>Candidaturas</h2>
        </template>
      </painel>
      <div class="row">
        <div v-if="!toggle">
            <div v-for="show in displayCandidaturas" :key="show.id" :id="show.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="label label-info ">Vaga: {{show.vaga.titulo}}</span></h3>
                    </template>
                    <template v-slot:card-body>
                    <p>Cargo: {{show.vaga.cargo}}</p>
                    <p>Detalhes: {{show.vaga}}</p>
                    </template>
                    <template v-slot:card-footer>
                    <div v-if="permissaoDoUsuario === 'JURIDICA'">
                        <button @click="vagaDaCandidatura(show.id)" class="btn btn-sm btn-success">Ver Candidatos</button>
                    </div>
                    <div v-else>
                        <div v-if="agendamento">
                            <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Desistir</button>
                        </div>
                    </div>
                    </template>
                </Card>
            </div>
        </div>
        <div v-else>
            <div>
                <button @click="toggle = false" class="btn btn-sm btn-outline-secondary">Voltar</button>
            </div>
            <div v-for="show in candidaturasByVaga" :key="show.id" :id="show.id">
              <List>
                <template v-slot:list-header>
                    <h3 class="mb-1" style="color: #4E73DF;">{{show.curriculo.fisica.user}}</h3>
                </template>
                <template v-slot:list-body>
                    <p class="mb-1"><strong>Cargo:</strong> {{show.curriculo.contato}}</p>
                    <p class="mb-1"><strong>Área de Atuação:</strong></p>
                    <p class="mb-1"><strong>Jornada de Trabalho:</strong></p>
                </template>
                <template v-slot:list-footer>
                  <button @click="showModal('else', vaga.id)" class="btn btn-sm btn-default">Ver mais</button>
                  <template>
                      <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button>
                  </template>
                  <template>
                    <router-link to="/new-curriculo" class="btn btn-sm btn-info">Preencha seu currículo para se candidatar!</router-link>
                  </template>
                  <Modal v-if="isModalShowMore" @close="closeModal">
                        <template v-slot:header><h3>Detalhes da Vaga</h3></template>
                        <template v-slot:body>

                          <h3 class="mb-1" style="color: #4E73DF;">{{vagaById[0].titulo}}</h3>
                          <p class="mb-1"><strong>Cargo: </strong>{{vagaById[0].cargo}}</p>
                          <p class="mb-1"><strong>Área de Atuação:</strong> {{vagaById[0].area.tipo}}</p>
                          <p class="mb-1"><strong>Jornada de Trabalho: </strong>{{vagaById[0].jornada}}</p>
                          <p class="mb-1"><strong>Salário:</strong> {{vagaById[0].salario}}</p>
                          <p class="mb-1"><strong>Benefícios: </strong>{{vagaById[0].beneficio}}</p>
                          <p class="mb-1"><strong>Requisitos:</strong> {{vagaById[0].requisito}}</p>
                        </template>
                        <template v-slot:footer>
                          <button @click="closeModal" class="btn btn-sm btn-outline-default">Voltar</button>

                          <div>
                            <router-link to="/new-curriculo" class="btn btn-sm btn-info">Preencha seu currículo para se candidatar!</router-link>
                          </div>
                        </template>
                  </Modal>
                  </template>
                </List>
              </div>
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
    import {mapGetters, mapActions} from 'vuex';
    import painel from '../Utils/Painel';

    export default {
        data(){
            return{

                candidaturas: [],
                toggle: false,
                agendamento: false,
                isModalShowMore: false,
                vaga_id: 0,
            }
        },
        components: {NewAgenda, Card, List, Modal,painel},
        methods: {
            ...mapActions([
                'loadCandidaturas'
            ]),

             showModal(modal, candidato_id){
                 this.isModalShowMore = true;
            },

            closeModal(){
              this.isModalWarning = false;
              this.isModalShowMore = false;
            },

            vagaDaCandidatura(vaga_id){
                this.toggle = true;
                this.vaga_id = vaga_id;
                console.log('vaga_id', vaga_id);
            },

            loadAAAAACandidaturas(){
                const user_id = this.$session.get('user_id');
                this.axios
                    .get(this.uri + '?token=' + this.token)
                    .then(response => {
                        if(this.$session.get('role') === 'JURIDICA'){
                            this.candidaturas = response.data.candidaturas;
                        }else{
                            this.candidaturas = response.data.candidaturasFisica;
                            if(response.data.candidaturasFisica[0].status === 'EM AGENDAMENTO'){
                                this.agendamento = true;
                            }
                        }

                        console.log(response.data);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onSchedule(candidaturaId){
               this.$router.push({ name: 'new-agenda', params: { candidaturaId }})
            }
        },

        computed: {
            ...mapGetters([
                'displayCandidaturas', 'permissaoDoUsuario', 'displayCandidaturasByVaga'
            ]),
            candidaturasByVaga() {
                return this.displayCandidaturasByVaga(this.vaga_id)
            },
        },

        async created(){
            await this.loadCandidaturas();
            console.log('display', this.displayCandidaturas)

        },

    }
</script>

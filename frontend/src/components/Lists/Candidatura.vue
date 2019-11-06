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
            <div v-for="show in vagasCandidaturas" :key="show.id" :id="show.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="label label-info ">Vaga: {{show.vaga.titulo}}</span></h3>
                    </template>
                    <template v-slot:card-body>
                    <p>Cargo: {{show.vaga.cargo}}</p>
                    <p>Detalhes: {{show}}</p>
                    </template>
                    <template v-slot:card-footer>
                    <div v-if="permissaoDoUsuario === 'JURIDICA'">
                        <button @click="vagaDaCandidatura(show.vagas_id)" class="btn btn-sm btn-success">Ver Candidatos</button>
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
                    <h3 class="mb-1" style="color: #4E73DF;">{{show.curriculo.fisica.user.name}}</h3>
                </template>
                <template v-slot:list-body>
                    <p class="mb-1"><strong>Objetivos:</strong> {{show.curriculo.objetivos}}</p>
                    <p class="mb-1"><strong>Pretensão Salarial:</strong> {{show.curriculo.pretensao}}</p>
                </template>
                <template v-slot:list-footer>
                  <button @click="showModal(show.id)" class="btn btn-sm btn-default">Ver mais</button>
                  
                  <Modal v-if="isModalShowMore" @close="closeModal">
                        <template v-slot:header><h3>Detalhes da Vaga</h3></template>
                        <template v-slot:body>

                         <h4>Informações Pessoais</h4>
                        <ul>
                            <li> <strong>Nome Completo</strong>: {{show.curriculo.fisica.user.name}}</li>
                            <li> <strong>Data de Nascimento</strong>: {{show.curriculo.fisica.nascimento | dateFormat}}</li>
                            <li> <strong>Gênero</strong>: {{show.curriculo.fisica.genero}}</li>
                            <li> <strong>Estado Civil</strong>: {{show.curriculo.fisica.estadoCivil}}</li>
                            <li> <strong>CPF</strong>: {{show.curriculo.fisica.cpf}}</li>
                          
                        </ul>
                        <h4>Redes Sociais</h4>
                        <ul>
                         
                        </ul>
                        </template>
                        <template v-slot:footer>
                          <button @click="closeModal" class="btn btn-sm btn-outline-default">Voltar</button>
                          <button @click="reject" class="btn btn-sm btn-outline-danger">Recusar</button>
                          <div>
                            <router-link to="/new-curriculo" class="btn btn-sm btn-info">Agendar Entrevista</router-link>
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
    import {mapGetters, mapActions, mapState} from 'vuex';
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

             showModal(candidato_id){
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
            ...mapState([
                'vagasCandidaturas'
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

<template>
    <div class="container" v-if="permissaoDoUsuario === 'JURIDICA'">
        <div v-if="displayResultados.length==0">
            <h1>Nenhum resultado encontrado</h1> 
        </div>
        <div class="row" v-else>
            <div class="col-md-6" v-for="curriculo in pageOfItems" :key="curriculo.id" :id="curriculo.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="label label-info " style="color: #4E73DF;">{{curriculo.fisica.user.name}}</span></h3>
                    </template>
                    <template v-slot:card-body>
                    <p><strong>Qualificações:</strong> {{curriculo.qualificacoes}}</p>
                    <p><strong>Escolaridade:</strong> {{curriculo.escolaridade}}</p>
                    <p><strong>Objetivos:</strong> {{curriculo.objetivos}}</p>
                    <p><strong>Pretensão Salarial:</strong> {{curriculo.pretensao}}</p>
                    <p><strong>Histórico Profissional:</strong> {{curriculo.historicoProfissional}}</p>
                    <p><strong>Cidade:</strong> {{curriculo.fisica.endereco.cidade}}</p>
                    <p><strong>Área de Atuação:</strong> {{curriculo.area.tipo}}</p>
                    </template>
                    <template v-slot:card-footer>
                    </template>
                </Card>
            </div>
        </div>
        <jw-pagination :items="displayResultados" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
    </div>
    <div class="container" v-else>
        <div v-if="displayResultados.length==0">
            <h1>Nenhum resultado encontrado</h1> 
        </div>
        <div class="row" v-else>
            <div class="col-md-6" v-for="vaga in pageOfItems" :key="vaga.id" :id="vaga.id">
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
        </div>
        <jw-pagination :items="displayResultados" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
    </div>
</template>

<script>
import Card from '../Utils/CardsVagas';
import List from '../Utils/List';
import Modal from '../Utils/ModalOld';
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
            keywords: '',
            pageOfItems: [],
            customLabels,
            filterState: true,
            isModalWarning: false,
            isModalShowMore: false,
            vaga_id: 0,

        }
    },
    components: {Card, JwPagination, List, Modal},

    created(){
        if(this.$store.state.auth.user.role == 'JURIDICA'){
            if((this.$route.query.escolaridade!='' || this.$route.query.objetivos!='' || this.$route.query.historicoProfissional!='' || this.$route.query.cidade!='' || this.$route.query.nome!='' || this.$route.query.area!='') == true && (this.$route.query.escolaridade!=undefined || this.$route.query.objetivos!=undefined || this.$route.query.historicoProfissional!=undefined || this.$route.query.cidade!=undefined || this.$route.query.nome!=undefined || this.$route.query.area!=undefined) == true){
                let pesquisa = {
                    keywords : this.$route.query.keywords,
                    escolaridade : this.$route.query.escolaridade, 
                    objetivos : this.$route.query.objetivos, 
                    historicoProfissional : this.$route.query.historicoProfissional,
                    cidade : this.$route.query.cidade,
                    nome: this.$route.query.nome,
                    area: this.$route.query.area,
                }
                this.$store.dispatch('searchCurriculosAvancadas', pesquisa)
                .then(response => {

                })
                .catch(error => console.log(error))
            }
            else{
                this.$store.dispatch('searchCurriculos', this.$route.query.keywords)
                .then(response => {

                })
                .catch(error => console.log(error))
            }
        }
        else {
            if((this.$route.query.cargo!='' || this.$route.query.beneficio!='' || this.$route.query.jornada!='' || this.$route.query.requisitos!='' || this.$route.query.area!='') == true && (this.$route.query.cargo!=undefined || this.$route.query.beneficio!=undefined || this.$route.query.jornada!=undefined || this.$route.query.requisitos!=undefined || this.$route.query.area!=undefined) == true){
                let pesquisa = {
                    keywords : this.$route.query.keywords,
                    cargo : this.$route.query.cargo, 
                    beneficio : this.$route.query.beneficio, 
                    jornada : this.$route.query.jornada,
                    requisitos : this.$route.query.requisitos,
                    area: this.$route.query.area,
                }
                this.$store.dispatch('searchVagasAvancadas', pesquisa)
                .then(response => {

                })
                .catch(error => console.log(error))
            }
            else{
                this.$store.dispatch('searchVagas', this.$route.query.keywords)
                .then(response => {
                    
                })
                .catch(error => console.log(error))
            }
        }

            this.loadVagasJuridica();
        
    },

    computed:{
        ...mapGetters([
            'displayResultados', 'permissaoDoUsuario', 'dataCompleted', 'displayVagaById'
        ]),
        
        vagaById(){
            return this.displayVagaById(this.vaga_id)
        }
    },

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
            }
            else{
                console.log('no show', vaga_id);
                this.isModalShowMore = true;
                this.vaga_id = vaga_id;
                console.log('kkkk', this.vagaById)

            }
        },

        onEdit(vaga_id){
            this.$session.set('editing', true);
            this.$session.set('vaga_id', vaga_id);
            this.$router.push({ name: 'new-vaga'})
        },

        closeModal(){
            this.isModalWarning = false;
            this.isModalShowMore = false;
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
    },
 }
</script>
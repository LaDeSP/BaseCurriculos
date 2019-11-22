<template>
    <div class="container" v-if="permissaoDoUsuario === 'JURIDICA'">
        <div v-if="displayResultados.length==0">
            <h1>Nenhum resultado encontrado</h1> 
        </div>
        <div class="card-group" v-else>
            <div class="col-lg-12">
                <div class="row">
                    <Card class="col-sm-6" v-for="curriculo in pageOfItems" :key="curriculo.id" :id="curriculo.id">
                        <template v-slot:card-header>
                        <h3><span class="label label-info " style="color: #4E73DF;">{{curriculo.fisica.user.name}}</span></h3>
                        </template>
                        <template v-slot:card-body>
                        <strong>Qualificações:</strong> {{curriculo.qualificacoes}}
                        <strong>Escolaridade:</strong> {{curriculo.escolaridade}}
                        <strong>Objetivos:</strong> {{curriculo.objetivos}}
                        <strong>Pretensão Salarial:</strong> {{curriculo.pretensao}}
                        <strong>Histórico Profissional:</strong> {{curriculo.historicoProfissional}}
                        <strong>Cidade:</strong> {{curriculo.fisica.endereco.cidade}}
                        <strong>Área de Atuação:</strong> {{curriculo.area.tipo}}
                        </template>
                        <template v-slot:card-footer>
                        </template>
                    </Card>
                    
                </div>
            </div>
        </div>
            
        <div v-if="displayResultados.length > 10">
             <jw-pagination :items="displayResultados" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <div class="display-none" v-else>
            <jw-pagination :items="displayResultados" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
    </div>
    <div class="container" v-else>
        <div v-if="displayResultados.length==0">
            <h1>Nenhum resultado encontrado</h1> 
        </div>
        <div class="card-group" v-else>
            <div class="col-lg-12">
                <div class="row">
                    <Card class="col-sm-6" v-for="vaga in pageOfItems" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
                        <template v-slot:card-header>
                            <h3 class="mb-1" style="color: #4E73DF;">{{vaga.titulo}}</h3>
                        </template>
                        <template v-slot:card-body>
                            <p class="mb-1"><strong>Cargo:</strong> {{vaga.cargo}}</p>
                            <p class="mb-1"><strong>Área de Atuação:</strong> {{vaga.area.tipo}}</p>
                            <p class="mb-1"><strong>Jornada de Trabalho:</strong> {{vaga.jornada}}</p>
                        </template>
                        <template v-slot:card-footer>
                            <template v-if="dataCompleted">
                                <div v-if="vaga.my_candidatura">
                                    <button class="btn btn-sm btn-success" disabled>Você já se candidatou pra essa vaga.</button>
                                </div>
                                <div v-else>
                                    <button @click="showModal('else', vaga.id)" class="btn btn-sm btn-default">Ver mais</button>
                                    <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button>
                                </div>
                            </template>
                            <template v-else>
                                <router-link to="/new-curriculo" class="btn btn-sm btn-info">Preencha seu currículo para se candidatar ou ver mais!</router-link>
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
        </div>
        <div class="container" v-if="displayResultados.length > 10">
            <jw-pagination :items="displayResultados" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <div class="container display-none" v-else>
            <jw-pagination :items="displayResultados" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
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
</template>

<script>
import Card from '../Utils/Card';
import Modal from '../Utils/ModalOld';
import { mapActions, mapGetters } from 'vuex';
import JwPagination from 'jw-vue-pagination';
import { BAlert } from 'bootstrap-vue'

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
            isModalSuccess: false,
            vaga_id: 0,

        }
    },
    components: {Card, JwPagination, Modal, BAlert},

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
            console.log(pageOfItems);
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
            this.isModalSuccess = false;
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
                for( var i = 0; i < this.$store.state.resultado.length; i++){ 
                    if ( this.$store.state.resultado[i].id == id) {
                        this.$store.state.resultado.splice(i, 1); 
                    }
                }
                this.isModalShowMore = false;
                this.isModalSuccess = true;
            }).catch(error => console.log(error))
        },
    },
 }
</script>
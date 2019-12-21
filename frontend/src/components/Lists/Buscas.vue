<template>
<span v-if="isFetching">
  <br>
  <br>
  <br>
  <div class="container">
    <center><h1>
        Carregando...  <span class="fas fa-spinner fa-pulse"></span>
    </h1></center>
  </div>
</span>
<span v-else>

<div class="row justify-content-center">
  <div class="col-md-9">
    <div v-if="permissaoDoUsuario === 'JURIDICA'">
        <div class="row mb-4">
          <div class="col-5">
            <router-link
              v-bind:to="'/dashboard/'"
              tag="button"
              class="btn btn-md btn-outline-secondary"
            >
              <i class="fa fa-home"></i> Home
            </router-link>
          </div>
          <div class="6">
            <h2 class="mb-1">
              <center><h1>Resultados</h1></center>
            </h2>
          </div>
        </div>
        <div v-if="displayResultados.length==0">
          <br>
          <br>
          <br>
          <div class="container"><center><h1>Nenhum resultado encontrado</h1></center></div>
        </div>
        <div class="card-deck" v-else>
            <div class="col-lg-12">
                <div class="row">
                    <Card class="col-sm-6 column" v-for="curriculo in pageOfItems" :key="curriculo.id" :id="curriculo.id" :foto=curriculo.fisica.user.foto :thumbnail=true>
                        <template v-slot:card-header>
                        <h3 class="card-title"><span class="label label-info " style="color: #4E73DF;">{{curriculo.fisica.user.name}}</span></h3>
                        </template>
                        <template v-slot:card-body> <br><br>
                        <strong>Qualificações:</strong> {{curriculo.qualificacoes}}  <br><br>
                        <strong>Escolaridade:</strong> {{curriculo.escolaridade}}  <br><br>
                        <strong>Objetivos:</strong> {{curriculo.objetivos}}  <br><br>
                        <strong>Pretensão Salarial:</strong> {{curriculo.pretensao}}  <br><br>
                        <strong>Histórico Profissional:</strong> {{curriculo.historicoProfissional}}  <br><br>
                        <strong>Cidade:</strong> {{curriculo.fisica.endereco.cidade}}  <br><br>
                        <strong>Área de Atuação:</strong> {{curriculo.area.tipo}}  <br><br>
                        </template>
                        <template v-slot:card-footer>
                            <div v-if="displayVagasJuridica.length>0">
                                <select class="custom-select" name="vaga" v-model="vaga[curriculo.id]">
                                    <option selected value="">Selecione a vaga</option>
                                    <option v-for="show in displayVagasJuridica" :key="show.id" :value="show.id">
                                        {{show.titulo}}
                                    </option>
                                </select><br><br>
                                <button :disabled="vaga[curriculo.id]==''||vaga[curriculo.id]==undefined" @click="onRequestConvite(curriculo.id)" class="btn btn-sm btn-success">Convidar</button>
                            </div>
                        </template>
                    </Card>

                </div>
            </div>
            <Modal v-if="isModalError" @close="closeModal">
                <template v-slot:header></template>
                <template v-slot:body>
                    <b-alert show variant="warning">
                        <h1>Selecione uma vaga!</h1>
                    </b-alert>
                </template>
            </Modal>
            <Modal v-if="isModalMultipleInvite" @close="closeModal">
                <template v-slot:header></template>
                <template v-slot:body>
                    <b-alert show variant="danger">
                        <h1>Você já convidou essa pessoa pra essa vaga!</h1>
                    </b-alert>
                </template>
            </Modal>
            <Modal v-if="isModalJaCandidatou" @close="closeModal">
                <template v-slot:header></template>
                <template v-slot:body>
                    <b-alert show variant="danger">
                        <h1>Essa pessoa já está com uma candidatura em andamento nessa vaga.</h1>
                    </b-alert>
                </template>
            </Modal>
            <Modal v-if="isModalSuccess" @close="closeModal">
            <template v-slot:header></template>
            <template v-slot:body>
                 <b-alert show variant="success">
                    <h1>Convite realizado com sucesso!</h1>
                </b-alert>
            </template>
        </Modal>
        </div>

        <div v-if="displayResultados.length > 10">
             <jw-pagination :items="displayResultados" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <div class="display-none" v-else>
            <jw-pagination :items="displayResultados" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
    </div>
    <div v-else>
        <div class="row mb-4">
          <div class="col-5">
            <router-link
              v-bind:to="'/dashboard/'"
              tag="button"
              class="btn btn-md btn-outline-secondary"
            >
              <i class="fa fa-home"></i> Home
            </router-link>
          </div>
          <div class="6">
            <h2 class="mb-1">
              <center><h1>Resultados</h1></center>
            </h2>
          </div>
        </div>
        <div v-if="displayResultados.length==0">
            <div class="container justify-content-center"><h1>Nenhum resultado encontrado</h1> </div>
        </div>
        <div class="card-deck" v-else>
            <div class="col-lg-12">
                <div class="row">
                    <Card class="col-sm-6 column" v-for="vaga in pageOfItems" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
                        <template v-slot:card-header>
                            <h3 class="card-title" style="color: #4E73DF;">{{vaga.titulo}}</h3>
                        </template>
                        <template v-slot:card-body>
                            <strong>Cargo:</strong> {{vaga.cargo}} <br><br>
                            <strong>Área de Atuação:</strong> {{vaga.area.tipo}}  <br><br>
                            <strong>Jornada de Trabalho:</strong> {{vaga.jornada}}  <br><br>
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
                                    <strong>Descrição:</strong> {{vagaById[0].descricao}}<br><br>
                                    <strong>Cargo: </strong>{{vagaById[0].cargo}}<br><br>
                                    <strong>Área de Atuação:</strong> {{vagaById[0].area.tipo}}<br><br>
                                    <strong>Jornada de Trabalho: </strong>{{vagaById[0].jornada}}<br><br>
                                    <strong>Salário:</strong> {{vagaById[0].salario}}<br><br>
                                    <strong>Benefícios: </strong>{{vagaById[0].beneficio}}<br><br>
                                    <strong>Requisitos:</strong> {{vagaById[0].requisito}}<br><br>
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
  </div>
</div>
</span>
</template>

<script>
import Card from '../Utils/Card';
import Modal from '../Utils/ModalOld';
import { mapActions, mapGetters, mapState } from 'vuex';
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
            isModalWarning: false,
            isModalShowMore: false,
            isModalSuccess: false,
            isModalError: false,
            isModalMultipleInvite: false,
            isModalJaCandidatou: false,
            vaga_id: 0,
            vaga: [],
            thisCurriculo: '',
        }
    },
    components: {Card, JwPagination, Modal, BAlert},

    async created(){
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
                await this.$store.dispatch('searchCurriculosAvancadas', pesquisa)
                .then(response => {

                })
                .catch(error => console.log(error))
            }
            else{
                await this.$store.dispatch('searchCurriculos', this.$route.query.keywords)
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
                await this.$store.dispatch('searchVagasAvancadas', pesquisa)
                .then(response => {

                })
                .catch(error => console.log(error))
            }
            else{
                await this.$store.dispatch('searchVagas', this.$route.query.keywords)
                .then(response => {

                })
                .catch(error => console.log(error))
            }
        }

        await this.loadVagasJuridica();

    },

    computed:{
        ...mapGetters([
            'displayResultados', 'permissaoDoUsuario', 'dataCompleted', 'displayVagaById', 
            'displayVagasJuridica', 'displayVagasNaoCandidatadas'
        ]),

        ...mapState([
            'isFetching'
        ]),

        vagaById(){
            return this.displayVagaById(this.vaga_id)
        },

        vagaNaoCandidatada(){
            this.vaga[this.thisCurriculo.id]='';
            console.log('thisvaga', this.vaga[this.thisCurriculo.id])
            console.log('thiscurriculo', this.thisCurriculo)
            return this.displayVagasNaoCandidatadas(this.thisCurriculo)
        },

        changeThisCurriculo: function() {
            return (curriculo) => this.thisCurriculo = curriculo;
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
            }
            else{
                this.isModalShowMore = true;
                this.vaga_id = vaga_id;
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
            this.isModalError = false;
            this.isModalMultipleInvite = false;
            this.isModalJaCandidatou = false;
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

        async onRequest(id){
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
            await this.$store.dispatch('requestVaga', requestVaga)
            .then(response => {
                for( var i = 0; i < this.$store.state.resultado.length; i++){
                    if ( this.$store.state.resultado[i].id == id) {
                        this.$store.state.resultado.splice(i, 1);
                    }
                }
                this.isModalShowMore = false;
                this.isModalSuccess = true;
            }).catch(error => console.log(error))
        },

        onRequestConvite(id){
            if(this.vaga[id]==''||this.vaga[id]==undefined){
                this.isModalError = true;
                return;
            }

            let requestConvite = {
                vaga_id: this.vaga[id],
                curriculo_id: id
            }
            this.$store.dispatch('requestConvite', requestConvite)
            .then(response => {
                if(response.error){
                    if(response.error[0]=="Essa pessoa está candidata nessa vaga."){
                        this.isModalJaCandidatou = true;
                    }
                    else{
                        this.isModalMultipleInvite = true;
                    }
                }
                else{
                    this.isModalShowMore = false;
                    this.isModalSuccess = true;
                }


            }).catch(error => console.log(error))
        },
    },
 }
</script>

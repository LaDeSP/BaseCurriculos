<template>
    <div class="container" v-if="permissaoDoUsuario === 'FISICA'">
        <div v-if="displayConvites.length==0">
            <h1>Você ainda não tem convites.</h1> 
        </div>
        <div class="card-group" v-else>
            <div class="col-lg-12">
                <div class="row">
                    <Card class="col-sm-6" v-for="convite in pageOfItems" :key="convite.id" :id="convite.id">
                        <template v-slot:card-header>
                        <h3><span class="label label-info " style="color: #4E73DF;">{{convite.vaga.titulo}}</span></h3>
                        </template>
                        <template v-slot:card-body>
                            <p class="mb-1"><strong>Cargo:</strong> {{convite.vaga.cargo}}</p>
                            <p class="mb-1"><strong>Área de Atuação:</strong> {{convite.vaga.area}}</p>
                            <p class="mb-1"><strong>Jornada de Trabalho:</strong> {{convite.vaga.jornada}}</p>
                        </template>
                        <template v-slot:card-footer>
                            <button @click="showModal('else', convite.vaga.id)" class="btn btn-sm btn-default">Ver mais</button>
                            <button @click="resposta('RECUSOU', convite.vaga.id)" class="btn btn-danger btn-sm btn-outline-default">Recusar</button>
                            <button @click="resposta('ACEITOU', convite.vaga.id)" class="btn btn-primary btn-sm btn-outline-default">Aceitar</button>
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
                                    <button @click="resposta('RECUSOU', vagaById[0].id)" class="btn btn-danger btn-sm btn-outline-default">Recusar</button>
                                    <button @click="resposta('ACEITOU', vagaById[0].id)" class="btn btn-primary btn-sm btn-outline-default">Aceitar</button>
                                </template>
                            </Modal>
                        </template>
                    </Card>
                    
                </div>
            </div>
        </div>
        <div v-if="displayConvites.length > 10">
             <jw-pagination :items="displayConvites" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <div class="display-none" v-else>
            <jw-pagination :items="displayConvites" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <Modal v-if="isModalAccept" @close="closeModal">
            <template v-slot:header></template>
            <template v-slot:body>
                 <b-alert show variant="success">
                    <h1>Você aceitou o convite! Sua candidatura foi criada. Vá para a candidaturas para vê-la.</h1>
                </b-alert>
            </template>
        </Modal>
        <Modal v-if="isModalRefuse" @close="closeModal">
            <template v-slot:header></template>
            <template v-slot:body>
                 <b-alert show variant="warning">
                    <h1>Você recusou o convite!</h1>
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
            pageOfItems: [],
            customLabels,
            isModalWarning: false,
            isModalShowMore: false,
            isModalAccept: false,
            isModalError: false,
            isModalMultipleInvite: false,
            isModalRefuse: false,
            vaga_id: 0,
        }
    },
    components: {Card, JwPagination, Modal, BAlert},

    computed:{
        ...mapGetters([
            'displayConvites', 'permissaoDoUsuario', 'displayVagaById'
        ]),

        vagaById(){
            return this.displayVagaById(this.vaga_id)
        }
    },

    methods: {
        ...mapActions([
            'getConvitesFisica', 'loadVagasJuridica'
        ]),

        onChangePage(pageOfItems) {
            // update page of items
            this.pageOfItems = pageOfItems;
        },

        closeModal(){
            this.isModalWarning = false;
            this.isModalShowMore = false;
            this.isModalAccept = false;
            this.isModalError = false;
            this.isModalMultipleInvite = false;
            this.isModalRefuse = false;
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

        resposta(resposta, vaga_id){
            let requestConvite = {
                resposta: resposta,
                vaga_id: vaga_id
            }
            this.$store.dispatch('respondeConvite', requestConvite)
            .then(response => {
                this.isModalShowMore = false;
                if(resposta=='ACEITOU'){
                    this.isModalAccept = true;
                }
                else{
                    this.isModalRefuse = true;
                }
                
            }).catch(error => console.log(error))
        }
    },
    
    created(){
        this.getConvitesFisica();
        this.loadVagasJuridica();
    }
}

</script>
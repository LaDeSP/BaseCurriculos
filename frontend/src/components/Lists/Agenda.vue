<template>
    <span v-if="isFetching">
        <br><br><br>
        <div class="container">
            <center><h1>Carregando...  <span class="fas fa-spinner fa-pulse"></span></h1></center>
        </div>
    </span>
    <span v-else>
        <div class="col-lg-10 d-sm-flex align-items-center justify-content-between mb-4 justify-content-center-when-cellphone d-flex-when-cellphone">
            <router-link v-bind:to="'/dashboard/'" tag="button" class="btn btn-md btn-outline-secondary"><i class="fa fa-home"></i> Home</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">     
                <div class="col-md-12 justify-content-center d-flex">
                    <h1 class="text-center">Agenda de Entrevistas</h1>
                </div>
                <div v-if="permissaoDoUsuario === 'JURIDICA'">
                    <div>
                        <div v-if="displayAgenda.length != 0">
                            <center class="bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                    <div class="col-md-12">
                                        <button @click="filterState = 'ALL'" type="button" class="btn btn-sm btn-outline-info">Todas</button>
                                        <button @click="filterState = 'EM AGENDAMENTO'" type="button" class="btn btn-sm btn-outline-warning">Em Agendamento</button>
                                        <button @click="filterState = 'CONFIRMADAS'" type="button" class="btn btn-sm btn-outline-success">Confirmadas</button>
                                        <button @click="filterState = 'CANCELADAS'" type="button" class="btn btn-sm btn-outline-danger">Canceladas</button>
                                        <button @click="filterState = 'FINALIZADAS'" type="button" class="btn btn-sm btn-outline-primary">Finalizadas</button>
                                    </div>
                                </div>
                            </center>
                        </div>
                        <div v-if="displayAgenda.length == 0 && filterState == 'ALL'">
                            <br><br>
                            <div class="container">
                                <center><h3>Não há entrevistas agendadas</h3></center>
                            </div>
                        </div>
                        <span v-if="filterState == 'EM AGENDAMENTO' && pageOfItems.length == 0">
                            <br><br>
                            <div class="container">
                                <center><h3>Não há entrevistas em agendamento. </h3></center>
                            </div>
                        </span>
                        <span v-else-if="filterState == 'CONFIRMADAS'&& pageOfItems.length == 0">
                            <br><br>
                            <div class="container">
                                <center><h3>Não há entrevistas confirmadas. </h3></center>
                            </div>
                        </span>
                        <span v-else-if="filterState == 'CANCELADAS' && pageOfItems.length == 0">
                            <br><br>
                            <div class="container">
                                <center><h3>Não há entrevistas canceladas. </h3></center>
                            </div>
                        </span>
                        <span v-else-if="filterState == 'FINALIZADAS' && pageOfItems.length == 0">
                            <br><br>
                            <div class="container">
                                <center><h3>Não há entrevistas finalizadas. </h3></center>
                            </div>
                        </span>
                        <div class="card-deck">
                            <div class="col-md-12">
                                <div class="row">
                                    <Card class="col-sm-6 margin-bottom column" v-for="show in pageOfItems" :key="show.id" :id="show.id" >
                                        <template v-slot:card-header>
                                            <span v-if="notificacoes">
                                                <span class="badge badge-success">
                                                    {{notificacoes}}
                                                </span>
                                            </span>
                                            <span class="text-info ">
                                                <h3 class="card-title">  Candidato: {{show.candidatura.curriculo.fisica.user.name}}</h3>
                                            </span>
                                            <span v-if="show.candidatura.status == 'EM AGENDAMENTO'">
                                                <h5 class="card-title"><span class="text-warning">{{show.candidatura.status}}</span></h5>
                                            </span>
                                            <span v-if="show.candidatura.status == 'ENTREVISTA CANCELADA'">
                                                <h5 class="card-title"><span class="text-danger">{{show.candidatura.status}}</span></h5>
                                            </span>
                                            <span v-else-if="show.candidatura.status == 'ENTREVISTA CONFIRMADA'">
                                                <h5 class="card-title"><span class="text-success">CONFIRMADA</span></h5>
                                            </span>
                                            <span v-if="show.candidatura.status == 'CONTRATADO'">
                                                <h5 class="card-title"><span class="text-success">{{show.candidatura.status}}</span></h5>
                                            </span>
                                            <span v-if="show.candidatura.status == 'RECUSADO'">
                                                <h5 class="card-title"><span class="text-danger">{{show.candidatura.status}}</span></h5>
                                            </span>
                                            <span v-if="show.candidatura.status == 'AGUARDANDO'">
                                                <h5 class="card-title"><span class="text-warning">{{show.candidatura.status}}</span></h5>
                                            </span>
                                        </template>
                                        <template v-slot:card-body>
                                            <ul>
                                                <li><strong>Vaga</strong>: {{show.candidatura.vaga.titulo}}</li>
                                                <li><strong>Data</strong>: {{show.data | dateFormat}}</li>
                                                <li><strong>Hora</strong>: {{show.hora}}</li>
                                                <span v-if="show.candidatura.status == 'ENTREVISTA CANCELADA'">
                                                    <li>
                                                        <span v-if="show.contraproposta == 'FISICA'">A entrevista foi cancelada.<br></span>
                                                        <span v-if="show.observacao != null && show.contraproposta == 'FISICA'">O candidato fez a seguinte observação:<br><br><i>"{{show.observacao}}"</i></span>
                                                        <span v-else-if="show.contraproposta == 'FISICA'">O candidato não fez observações.</span>
                                                    </li>
                                                </span>
                                                <span v-if="show.observacao != null && show.contraproposta == 'JURIDICA'">
                                                    <strong>Observações:</strong> {{show.observacao}}
                                                </span>
                                                <span v-else>
                                                    <strong>Observações</strong>: Não há observações.
                                                </span>
                                                <span v-if="show.candidatura.status == 'ENTREVISTA CONFIRMADA' && getDateNow(show.data)">
                                                    <strong>Notamos que a data de entrevista já passou. O candidato foi: </strong>
                                                </span>
                                            </ul>
                                        </template>
                                        <template v-slot:card-footer>
                                            <span v-if="show.candidatura.status == 'ENTREVISTA CONFIRMADA' && getDateNow(show.data)" >
                                                <center>
                                                    <button @click="confirmAgenda(show.candidatura.id, 'CONTRATADO')" class="btn btn-sm btn-success">Contratado</button>
                                                    <button @click="showModal('warningRecusa', show.candidatura.id)" class="btn btn-sm btn-danger">Recusado</button>
                                                </center>
                                                <Modal v-show="isModalWarningRecusa" @close="closeModal">
                                                    <template v-slot:header>
                                                        <h3>Recusar Candidato</h3>
                                                    </template>
                                                    <template v-slot:body>
                                                        <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>recusar</strong></span> esse candidato?</h2>
                                                        <br><h4>Caso queira, faça uma observação para o candidato:</h4>
                                                        <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                                                        <br><h6 class="text-center">Essa ação não poderá ser desfeita!</h6>
                                                    </template>
                                                    <template v-slot:footer>
                                                        <button @click="closeModal" class="btn btn-md btn-outline-secondary">Voltar</button>
                                                        <button @click="cancelAgenda('RECUSADO')" class="btn btn-md btn-danger">Enviar</button>
                                                    </template>
                                                </Modal>
                                            </span>
                                            <span v-if="show.candidatura.status == 'ENTREVISTA CANCELADDA'">
                                                <center><button @click="deleteCandidatura(show.candidatura.id)" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></center>
                                            </span>
                                            <span v-if="show.candidatura.status != 'ENTREVISTA CONFIRMADA' && show.candidatura.status != 'ENTREVISTA CANCELADA' && show.candidatura.status != 'RECUSADO' && show.candidatura.status != 'CONTRATADO'">
                                                <span v-if="show.contraproposta == 'FISICA'">
                                                    <button @click="confirmAgenda(show.candidatura.id)" class="btn btn-sm btn-success">Confirmar</button>
                                                    <router-link v-bind:to="'/agenda/' + show.candidatura.id" tag="button" class="btn btn-sm btn-primary">Fazer Contraproposta</router-link>
                                                </span>
                                                <span v-else>
                                                    <router-link v-bind:to="'/agenda/' + show.candidatura.id" tag="button" class="btn btn-sm btn-primary">Reagendar</router-link>
                                                </span>
                                            </span>
                                            <span v-if="show.candidatura.status != 'ENTREVISTA CANCELADA' && !getDateNow(show.data)">
                                                <button @click="showModal('warning', show.candidatura.id)" class="btn btn-sm btn-danger">Cancelar</button>
                                            </span>
                                            <Modal v-show="isModalWarning" @close="closeModal">
                                                <template v-slot:header>
                                                    <h3>Cancelar Entrevista</h3>
                                                </template>
                                                <template v-slot:body>
                                                    <h2 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> essa entrevista?</h2>
                                                    <center><br><h6>Você pode fazer uma observação para o candidato:</h6></center>
                                                    <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                                                    <br><h6 class="text-center">Essa ação não poderá ser desfeita!</h6>
                                                </template>
                                                <template v-slot:footer>
                                                    <button @click="cancelAgenda" class="btn btn-md btn-danger">Cancelar Entrevista</button>
                                                    <button @click="closeModal" class="btn btn-md btn-outline-secondary">Voltar</button>
                                                </template>
                                            </Modal>
                                        </template>
                                    </Card>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="trocaPagina" v-if="displayAgenda.length > 10">
                            <jw-pagination :items="displayAgenda" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
                        </div>
                        <div class="trocaPagina display-none" v-else>
                            <jw-pagination :items="isActive" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>


<script>
    import Card from '../Utils/Card';
    import List from '../Utils/List';
    import Modal from '../Utils/Modal';
    import Curriculo from '../Lists/Curriculo';
    import NewAgenda from '../Create/NewAgenda';
    import {mapGetters, mapActions, mapState} from 'vuex';
    import painel from '../Utils/Painel';
    import moment from 'moment'
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
                notificacoes: '',
                candidaturas: [],
                isModalShowMore: false,
                isModalWarning: false,
                isModalWarningRecusa: false,
                pageOfItems: [],
                candidatura_id: 0,
                observacao: '',
                customLabels,
                filterState: 'ALL',
            }
        },

        components: {NewAgenda, Card, List, Modal,painel, JwPagination},

        methods: {
            changeActiveButton(status) {
                $(".btn-group").on("click", ".btn", function() {
                    $(this)
                    .addClass("active")
                    .siblings()
                    .removeClass("active");
                });
                if (status === "ativa") {
                    this.filterState = true;
                } else {
                    this.filterState = false;
                }
            },

            onChangePage(pageOfItems) {
                this.pageOfItems = pageOfItems;
            },

            ...mapActions([
                'loadAgenda'
            ]),

            showModal(modal, id){
                if(modal === 'showMore'){
                    this.isModalShowMore = true;
                    this.candidato_id = id;
                }
                else if(modal === 'warning'){
                    this.isModalWarning = true;
                    this.candidatura_id = id;
                }
                else{
                    this.isModalWarningRecusa = true;
                    this.candidatura_id = id;
                }
            },

            closeModal(){
                this.isModalWarning = false;
                this.isModalShowMore = false;
                this.isModalWarningRecusa = false;
            },

            vagaDaCandidatura(vaga_id){
                this.toggle = true;
                this.vaga_id = vaga_id;
            },

            async confirmAgenda(candidatura_id, contratado){

                let candidatura = {
                    candidatura_id: candidatura_id,
                    contratado: contratado
                }

                await this.$store.dispatch('confirmAgenda', candidatura)
                .then(response => {
                    if(response.notificacao  != undefined){
                        this.notificacoes = response.notificacao;
                    }
                }).catch(error => console.log(error))
            },

            async cancelAgenda(recusado){
                let cancelAgenda = {
                    observacao: this.observacao,
                    candidatura_id: this.candidatura_id,
                    recusa: recusado,
                }
                await this.$store.dispatch('cancelAgenda', cancelAgenda)
                .then(response => {
                   this.isModalWarning = false;
                }).catch(error => console.log(error))
            },

            async deleteCandidatura(candidatura_id){
                await this.$store.dispatch('deleteCandidatura', candidatura_id)
                .then(response => {

                }).catch(error => console.log(error))
            },

            getDateNow(data){
                let now = new Date();
                let date = now.getDate();
                let month = now.getMonth() + 1;
                let year = now.getFullYear();

                let dateStr = '2020-12-13';
                var dateAgenda = Date.parse(data);
                var dateNow = Date.parse(dateStr);

                if(dateNow > dateAgenda){
                    return true
                }
                else{
                    return false
                }
            }
        },

        computed: {
            ...mapState([
                'isFetching'
            ]),

            ...mapGetters([
                'permissaoDoUsuario', 'displayAgenda',
                'displayEntrevistasEmAgendamento', 'displayEntrevistasConfirmadas',
                'displayEntrevistasCanceladas', 'displayEntrevistasFinalizadas',
            ]),

            isActive() {
                if(this.filterState === 'ALL'){
                     console.log('oi', this.filterState)
                     return this.displayAgenda
                }
                else if (this.filterState === 'EM AGENDAMENTO') {
                    return this.displayEntrevistasEmAgendamento
                }
                else if(this.filterState === 'CONFIRMADAS'){
                    return this.displayEntrevistasConfirmadas
                }
                else if(this.filterState === 'CANCELADAS'){
                     return this.displayEntrevistasCanceladas
                }
                else if(this.filterState === 'FINALIZADAS'){
                     return this.displayEntrevistasFinalizadas
                }
            },
        },

        filters:{
            dateFormat: function(value){
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY')
                }
            }
        },

        async created(){
            await this.loadAgenda();
            console.log('create', this.isActive)
        },

    }
</script>

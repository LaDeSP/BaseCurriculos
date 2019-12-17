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
    <div class="col-md-7">

        <div v-if="!this.editing">
            <h3><router-link to="/vagas" class="btn btn-md btn-outline-secondary"><i class="fas fa-long-arrow-alt-left"></i> Voltar</router-link> <center>Cadastrar Informações</center></h3>
        </div>
        <div v-else>
            <h3><router-link to="/vagas" class="btn btn-md btn-outline-secondary"><i class="fas fa-long-arrow-alt-left"></i> Voltar</router-link> <center>Editar Informações</center></h3>
        </div>
        <hr>

        <ValidationObserver v-slot="{ invalid }">
        <form-wizard @on-complete="onComplete"
            title="" subtitle=" "
            back-button-text="Voltar"
            next-button-text="Próximo"
            finish-button-text="Salvar"
            color="#2E59D9"
        >
        <div v-if="notificacoes">
            <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                {{notificacao[0]}}
            </span>
        </div>
        <tab-content title="Informações da Vaga" icon="fas fa-file-invoice-dollar">
            <div class="form-group">
            <label for="titulo">Título <a class="color-red">*</a></label>
            <ValidationProvider name="titulo" rules="required|max:250">
                <div slot-scope="{ errors }">
                    <input type="titulo" name="titulo"
                    class="form-control" v-model="titulo" maxlength="250">
                    <p class="color-red">{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="descricao">Descrição <a class="color-red">*</a></label>
            <ValidationProvider name="descricao" rules="required|max:5000">
                <div slot-scope="{ errors }">
                    <textarea type="descricao" name="descricao"
                    class="form-control" v-model="descricao" rows="3" maxlength="5000"></textarea>
                    <p class="color-red">{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="cargo">Cargo <a class="color-red">*</a></label>
            <ValidationProvider name="cargo" rules="required|max:250">
                <div slot-scope="{ errors }">
                    <input type="text" class="form-control" name="cargo" v-model="cargo" maxlength="250">
                    <p class="color-red">{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="quantidade">Quantidade de Vagas <a class="color-red">*</a></label>
            <ValidationProvider name="quantidade" rules="required|numeric|min_value:1|integer">
                <div slot-scope="{ errors }">
                    <input type="number" class="form-control" name="quantidade" v-model="quantidade">
                    <p class="color-red">{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="area">Área de Atuação <a class="color-red">*</a></label>
            <select class="custom-select" name="area" v-model="area">
                <option value="" disabled selected>Selecione uma Área</option>
                <option v-for="area in areas" :key="area.id" :value="area.id">
                    {{area.tipo}}
                </option>
            </select>
            </div>

            <div class="form-group">
            <label for="salario">Salário</label>
            <ValidationProvider name="salario" rules="max:250">
                <div slot-scope="{ errors }">
                    <input type="text" name="salario" class="form-control" v-model="salario" maxlength="250">
                    <p class="color-red">{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

        </tab-content>

        <tab-content title="Detalhes da Vaga" icon="fas fa-list-ul" >

            <div class="form-group">
            <label for="jornada">Jornada de Trabalho <a class="color-red">*</a></label>
            <ValidationProvider name="jornada" rules="required|max:250">
                <div slot-scope="{ errors }">
                    <input type="jornada" name="jornada"
                    class="form-control" v-model="jornada" maxlength="250">
                    <p class="color-red">{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="beneficios">Benefícios <a class="color-red">*</a></label>
            <ValidationProvider name="beneficios" rules="required|max:5000">
                <div slot-scope="{ errors }">
                <textarea class="form-control" rows="5" v-model="beneficios" maxlength="5000"></textarea>
                <p class="color-red">{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="requisitos">Requisitos <a class="color-red">*</a></label>
            <ValidationProvider name="requisitos" rules="required|max:5000">
                <div slot-scope="{ errors }">
                    <textarea class="form-control"  rows="5" v-model="requisitos" maxlength="5000"></textarea>
                    <p class="color-red">{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

        </tab-content>
        <div slot="footer" slot-scope="props">
            <div class="wizard-footer-left">
                <wizard-button  v-if="props.activeTabIndex > 0" @click.native="props.prevTab()" :style="props.fillButtonStyle">Voltar</wizard-button>
            </div>
            <div class="wizard-footer-right">
                <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()" class="wizard-footer-right" :style="props.fillButtonStyle">Próximo</wizard-button>
                <wizard-button v-else :disabled="invalid" @click.native="onComplete" class="wizard-footer-right finish-button" :style="props.fillButtonStyle">  {{props.isLastStep ? 'Salvar' : 'Próximo'}}</wizard-button>
            </div>
        </div>

        </form-wizard>
        </ValidationObserver>

    </div>
</div>
</span>
</template>

<script>

  import { mapActions, mapGetters, mapState} from 'vuex';

    export default {

        data(){
            return{

                titulo: '',
                descricao: '',
                cargo: '',
                salario: '',
                beneficios: '',
                requisitos: '',
                area: 0,
                jornada: '',
                quantidade: 0,
                areas: [],
                editing: this.$session.get('editing'),
                notificacoes: [],
                vaga_id: this.$session.get('vaga_id')


            }
        },

        methods: {
          ...mapActions([
              'loadVagasJuridica'
          ]),

            onComplete(){

                let vaga = {

                    titulo: this.titulo,
                    descricao: this.descricao,
                    cargo: this.cargo,
                    quantidade: this.quantidade,
                    salario: this.salario,
                    beneficios: this.beneficios,
                    requisitos: this.requisitos,
                    area: this.area,
                    jornada: this.jornada,
                    status: 'ATIVA',
                    vaga_id: this.vaga_id
                }

                if(!this.editing){
                    this.$store.dispatch('createVaga', vaga)
                    .then(response => {

                        if(response.error  != undefined){
                            this.notificacoes = response.error;
                        }else{
                            this.$router.push({ name: 'vagas'});
                        }
                    }).catch(error => console.log(error))

                }else{
                    this.$store.dispatch('updateVaga', vaga)
                    .then(response => {
                            if(response.error  != undefined){
                                this.notificacoes = response.error;
                            }else{
                                this.$router.push({ name: 'vagas'});
                            }
                    }).catch(error => console.log(error))
                }
            },

            verifyEdit(){

                this.vaga_id = this.$session.get('vaga_id');

                   this.$store.commit('isFetching')
                    console.log('dada', this.$store.state.isFetching)
                this.displayDataEdit();

            },

            displayDataEdit(){

                 if(this.editing){
                    this.titulo = this.vagaById[0].titulo;
                    this.descricao = this.vagaById[0].descricao;
                    this.cargo = this.vagaById[0].cargo;
                    this.quantidade = this.vagaById[0].quantidade;
                    this.salario = this.vagaById[0].salario;
                    this.requisitos = this.vagaById[0].requisito;
                    this.beneficios = this.vagaById[0].beneficio;
                    this.area = this.vagaById[0].area;
                    this.jornada = this.vagaById[0].jornada;
                    this.area = this.vagaById[0].area.id;
                    this.salario = parseFloat(this.vagaById[0].salario);

                 }

                this.$store.commit('isFetching')

                console.log('fetchin 2', this.$store.state.isFetching)
            },

            loadArea(){
                this.$store.dispatch('loadArea')
                .then(response => {
                    this.areas = response.areas;
                    this.nome = this.$store.state.auth.user.name;
                }).catch(error => console.log(error))
            },
        },

        computed:{

            ...mapState([
                'isFetching'
            ]),

            ...mapGetters([
              'displayVagasJuridica', 'displayVagaById'
            ]),

             vagaById(){
                return this.displayVagaById(this.vaga_id)
            }

        },

        async created(){
            await this.loadVagasJuridica();
            this.loadArea();
            this.verifyEdit();
        },

       /* async beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.loadVagasJuridica();
                vm.loadArea();
                vm.verifyEdit();
            });
        } */
    }
</script>


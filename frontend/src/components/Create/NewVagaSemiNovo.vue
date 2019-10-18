<template>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div v-if="!this.editing">
            <h3>Cadastrar Informações</h3>
        </div>
        <div v-else>
            <h3>{{displayVagasJuridica}}Editar Informações</h3>
        </div>
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
            <label for="titulo">Título</label>
            <ValidationProvider name="titulo" rules="required|max:50">
                <div slot-scope="{ errors }">
                    <input type="titulo" name="titulo"
                    class="form-control" v-model="titulo" maxlength="50">
                    <p>{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="local">Local</label>
            <ValidationProvider name="local" rules="required|max:50">
                <div slot-scope="{ errors }">
                    <input type="text" class="form-control" name="local" v-model="local" maxlength="50">
                    <p>{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="quantidade">Quantidade de Vagas</label>
            <ValidationProvider name="quantidade" rules="required|numeric|min_value:1|integer">
                <div slot-scope="{ errors }">
                    <input type="number" class="form-control" name="quantidade" v-model="quantidade">
                    <p>{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="area">Área de Atuação</label>
            <select class="custom-select" name="area" v-model="area">
                <option value="" disabled selected>Selecione uma Área</option>
                <option v-for="area in areas" :key="area.id" :value="area.id">
                    {{area.tipo}}
                </option>
            </select>
            </div>

            <div class="form-group">
            <label for="salario">Salário</label>
            <ValidationProvider name="salario" rules="required|numeric|min_value:1">
                <div slot-scope="{ errors }">
                    <input type="number"  name="salario" class="form-control" v-model="salario" step="any" placeholder="R$">
                    <p>{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

        </tab-content>

        <tab-content title="Detalhes da Vaga" icon="fas fa-list-ul" >

            <div class="form-group">
            <label for="jornada">Jornada de Trabalho</label>
            <ValidationProvider name="jornada" rules="required|max:50">
                <div slot-scope="{ errors }">
                    <input type="jornada" name="jornada"
                    class="form-control" v-model="jornada" maxlength="50">
                    <p>{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="beneficios">Benefícios</label>
            <ValidationProvider name="beneficios" rules="required|max:500">
                <div slot-scope="{ errors }">
                <textarea class="form-control" rows="3" v-model="beneficios" maxlength="500"></textarea>
                <p>{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

            <div class="form-group">
            <label for="requisitos">Requisitos</label>
            <ValidationProvider name="requisitos" rules="required|max:500">
                <div slot-scope="{ errors }">
                    <textarea class="form-control"  rows="3" v-model="requisitos" maxlength="500"></textarea>
                    <p>{{ errors[0] }}</p>
                </div>
            </ValidationProvider>
            </div>

        </tab-content>

        </form-wizard>
    </div>
</div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'; 
    export default {
    
        data(){
            return{

                titulo: '',
                local: '',
                salario: '',
                beneficios: '',
                requisitos: '',
                area: '',
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
                    local: this.local,
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
                if(this.editing) this.displayDataEdit();
               
            },

            displayDataEdit(){
                console.log(this.displayVagaById)
                console.log('desgraça ID', this.$session.get('vaga_id'))
               /* this.titulo = response.data.vaga.titulo,
                this.local = response.data.vaga.local,
                this.quantidade = response.data.vaga.quantidade,
                this.salario = response.data.vaga.salario,
                this.requisitos = response.data.vaga.requisito,
                this.beneficios = response.data.vaga.beneficio,
                this.area = response.data.vaga.area,
                this.jornada = response.data.vaga.jornada
                //this.area = this.displayCurriculo.area_id */
                //this.pretensao = parseFloat(this.displayCurriculo.pretensao)
                
            },
            loadArea(){
                const token = this.$store.state.auth.token;
                this.axios.get('http://localhost:8000/api/areas?token=' + token)

                    .then(response => {
                        this.areas = response.data.areas
                        this.nome = this.$store.state.auth.user.name
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
        },

        computed:{

            ...mapGetters([
                'displayVagasJuridica', //  'displayVagaById'
            ]),

            vagaById(){
             //   return this.displayVagaById(this.vaga_id)
            }

        },

       created(){
           this.loadVagasJuridica;
       }

    }
</script>

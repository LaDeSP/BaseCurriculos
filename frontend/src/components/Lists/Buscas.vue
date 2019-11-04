<template>
    <div class="container" v-if="permissaoDoUsuario === 'JURIDICA'">
         <div class="row">
            <div class="col-md-6" v-for="curriculo in displayResultados" :key="curriculo.id" :id="curriculo.id">
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
                    </template>
                    <template v-slot:card-footer>
                    </template>
                </Card>
            </div>
        </div>
        <div v-if="displayResultados.length==0">
            <h1>Nenhum resultado encontrado</h1> 
        </div>
    </div>
    <div class="container" v-else>
        <div class="row">
            <div class="col-md-6" v-for="vaga in displayResultados" :key="vaga.id" :id="vaga.id">
                <Card style="width: 30rem;">
                    <template v-slot:card-header>
                    <h3><span class="label label-info " style="color: #4E73DF;">{{vaga.titulo}}</span></h3>
                    </template>
                    <template v-slot:card-body>
                    <p><strong>Cargo:</strong> {{vaga.cargo}}</p>
                    <p><strong>Status:</strong> {{vaga.status}}</p>
                    <p><strong>Quantidade:</strong> {{vaga.quantidade}}</p>
                    <p><strong>Área de Atuação:</strong> {{vaga.area.tipo}}</p>
                    <p><strong>Salário:</strong> {{vaga.salario}}</p>
                    <p><strong>Jornada de Trabalho:</strong> {{vaga.jornada}}</p>
                    <p><strong>Benefícios:</strong> {{vaga.beneficio}}</p>
                    <p><strong>Requisitos:</strong> {{vaga.requisito}}</p>
                    </template>
                    <template v-slot:card-footer>
                    </template>
                </Card>
            </div>
        </div>
        <div v-if="displayResultados.length==0">
            <h1>Nenhum resultado encontrado</h1> 
        </div>
    </div>
</template>

<script>
import Card from '../Utils/CardsVagas';
import {mapGetters} from 'vuex';

export default {
    data(){
        return{
            keywords: '',
        }
    },
    components: {Card},

    created(){
        if(this.$store.state.auth.user.role == 'JURIDICA'){
            if((this.$route.query.escolaridade!='' || this.$route.query.objetivos!='' || this.$route.query.historicoProfissional!='' || this.$route.query.cidade!='' || this.$route.query.nome!='') == true && (this.$route.query.escolaridade!=undefined || this.$route.query.objetivos!=undefined || this.$route.query.historicoProfissional!=undefined || this.$route.query.cidade!=undefined || this.$route.query.nome!=undefined) == true){
                let pesquisa = {
                    keywords : this.$route.query.keywords,
                    escolaridade : this.$route.query.escolaridade, 
                    objetivos : this.$route.query.objetivos, 
                    historicoProfissional : this.$route.query.historicoProfissional,
                    cidade : this.$route.query.cidade,
                    nome: this.$route.query.nome,
                }
                this.$store.dispatch('searchCurriculosAvancadas', pesquisa)
                .then(response => {
                    console.log('state', this.$store.state.resultado);
                })
                .catch(error => console.log(error))
            }
            else{
                this.$store.dispatch('searchCurriculos', this.$route.query.keywords)
                .then(response => {
                    console.log('state', this.$store.state.resultado);
                })
                .catch(error => console.log(error))
            }
        }
        else {
            if((this.$route.query.cargo!='' || this.$route.query.beneficio!='' || this.$route.query.jornada!='' || this.$route.query.requisitos!='') == true && (this.$route.query.cargo!=undefined || this.$route.query.beneficio!=undefined || this.$route.query.jornada!=undefined || this.$route.query.requisitos!=undefined) == true){
                console.log('created if'); 
                let pesquisa = {
                    keywords : this.$route.query.keywords,
                    cargo : this.$route.query.cargo, 
                    beneficio : this.$route.query.beneficio, 
                    jornada : this.$route.query.jornada,
                    requisitos : this.$route.query.requisitos
                }
                this.$store.dispatch('searchVagasAvancadas', pesquisa)
                .then(response => {
                    console.log('state', this.$store.state.resultado);
                })
                .catch(error => console.log(error))
            }
            else{
                console.log('created else');
                this.$store.dispatch('searchVagas', this.$route.query.keywords)
                .then(response => {
                    console.log('state', this.$store.state.resultado);
                })
                .catch(error => console.log(error))
            }
        }
        
    },

    computed:{
        ...mapGetters([
            'displayResultados', 'permissaoDoUsuario'
        ]),
    },
 }
</script>
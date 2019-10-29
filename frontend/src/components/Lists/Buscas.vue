<template>
    <div>
        <div v-for="vaga in displayResultados" :key="vaga.id" :id="vaga.id">
            <Card style="width: 30rem;">
                <template v-slot:card-header>
                  <h3><span class="label label-info " style="color: #4E73DF;">{{vaga.titulo}}</span></h3>
                </template>
                <template v-slot:card-body>
                  <p><strong>Cargo:</strong> {{vaga.cargo}}</p>
                  <p><strong>Status:</strong> {{vaga.status}}</p>
                  <p><strong>Quantidade:</strong> {{vaga.quantidade}}</p>
                  <!--<p><strong>Área de Atuação:</strong> {{vaga.area.tipo}}</p>-->
                  <p><strong>Salário:</strong> {{vaga.salario}}</p>
                  <p><strong>Jornada de Trabalho:</strong> {{vaga.jornada}}</p>
                  <p><strong>Benefícios:</strong> {{vaga.beneficio}}</p>
                  <p><strong>Requisitos:</strong> {{vaga.requisito}}</p>
                </template>
                <template v-slot:card-footer>
                </template>
              </Card>
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
        this.$store.dispatch('searchVagas', this.$route.params.keywords)
            .then(response => {
                console.log('state', this.$store.state.resultado);
            })
            .catch(error => console.log(error))
    },

    computed:{
        ...mapGetters([
            'displayResultados'
        ]),
    },
 }
</script>
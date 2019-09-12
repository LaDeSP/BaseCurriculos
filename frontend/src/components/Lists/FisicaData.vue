<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Informações Pessoais</h2></div>
        <div class="panel-body">
              <div v-for="show in fisica" :key="show.id">
                <h4>Nome Completo: <strong>{{show.user.nome}}</strong></h4>
                <p>Data de Nascimento: {{show.dataNascimento | dateFormat}}</p>
                <p>Gênero: {{show.genero}}</p>
                <p>Estado Civil: {{show.estadoCivil}}</p>
                <p>CPF: {{show.cpf}}</p>
                <p>Rua: {{show.endereco.rua}}</p>
                <p>Bairro: {{show.endereco.bairro}}</p>
                <p>Cidade: {{show.endereco.cidade}}</p>
                <p>CEP: {{show.endereco.cep}}</p>
                <p>País de Nacionalidade {{show.endereco.cep}}</p>
                <p>Telefone Fixo: {{show.contato.fixo}}</p>
                <p>Telefone Celular: {{alu.contato.celular}}</p>
            </div>  
             <hr>
            
                <curriculo></curriculo>
        </div>
        <div class="panel-footer">
            <router-link to="/DashFIS" tag="button" class="btn btn-lg btn-danger ">Voltar</router-link>
        </div>   
        
    </div>
</template>

<script>

    import moment from 'moment'
    import Curriculo from './Curriculo.vue';

    export default {

        data(){
            return{
                fisica: []

            }
        },
        components: {'curriculo': Curriculo},
        methods: {

            loadFisica(){
            
                const user_id = this.$session.get('user_id');
                const token = this.$session.get('jwt');
                this.axios.get('http://localhost:8000/api/pfisicas/' + user_id + '?token=' + token)
                    .then(response => {
                        this.fisica = response.data.fisica
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },
        filters:{
           
            dateFormat: function(value){
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY')
                }
            }
        }, 

        created(){
            this.loadFisica();
        }
       
    }
</script>


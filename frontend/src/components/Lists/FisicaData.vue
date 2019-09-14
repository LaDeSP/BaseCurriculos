<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Informações Pessoais</h2></div>
        <div class="panel-body">
            <div v-if="loadFlag === true">
              <div v-for="show in fisica" :key="show.id">
                <h4>Nome Completo: <strong>{{show.user.name}}</strong></h4>
                <p>Data de Nascimento: {{show.data_nascimento | dateFormat}}</p>
                <p>Gênero: {{show.genero}}</p>
                <p>Estado Civil: {{show.estado_civil}}</p>
                <p>CPF: {{show.cpf}}</p>
                <p>Rua: {{show.endereco.rua}}</p>
                <p>Bairro: {{show.endereco.bairro}}</p>
                <p>Cidade: {{show.endereco.cidade}}</p>
                <p>CEP: {{show.endereco.cep}}</p>
                <p>País de Nacionalidade {{show.endereco.cep}}</p>
                <p>Telefone Fixo: {{show.contato.fixo}}</p>
                <p>Telefone Celular: {{show.contato.celular}}</p>
             </div>  
            </div>
             <hr>
            
            <div v-if="loadFlag === true">
                
                <curriculo></curriculo>
            
             <div class="panel-footer">
                <button @click="onEdit()" class="btn btn-lg btn-warning">Editar Informações</button>
                <router-link to="/DashFIS" tag="button" class="btn btn-lg btn-default ">Voltar</router-link>
                <button @click="onDelete()" class="btn btn-lg btn-danger">Deletar Conta</button>
            </div>   
        
            </div>
            <div v-else>
                <h4>Quase lá! Que tal preencher seu curriculo...</h4>
                <new-curriculo></new-curriculo>      
            </div> 

        </div>
    </div>
</template>

<script>

    import moment from 'moment'
    import Curriculo from './Curriculo.vue';
    import NewCurriculo from '../Create/NewCurriculo.vue';

    export default {

        data(){
            return{
                fisica: [],
                loadFlag: false,
                uri: 'http://localhost:8000/api/pfisicas/',
                token: this.$session.get('jwt')

            }
        },
        components: {'curriculo': Curriculo, 'new-curriculo': NewCurriculo},
        methods: {

            loadFisica(){
                const user_id = this.$session.get('user_id');
               
                this.axios.get(this.uri + user_id + '?token=' + this.token)
                    .then(response => {
                        if(response.data.fisica[0].contatos_id && response.data.fisica[0].enderecos_id !== null){
                           this.loadFlag = true;
                           this.fisica = response.data.fisica;
                           console.log(this.loadFlag);
                       }
                 
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onEdit(){
                const user_id = this.$session.get('user_id');
                this.$router.push({ name: 'new-curriculo', params: { editing: true, user_id }})
            },

            onDelete(){
                const user_id = this.$session.get('user_id');
                this.axios.delete(this.uri + user_id + '?token=' + this.token)
                    .then(response => {
                        this.$session.remove('jwt');
                        this.$session.destroy();
                        this.$router.push({ name: 'login' })
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


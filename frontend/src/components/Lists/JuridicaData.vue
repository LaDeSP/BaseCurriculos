<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Meu Perfil</h2></div>
        <div class="panel-body">
            <div v-if="loadFlag === false" class="text-center">
                    <h4> Você não terminou de cadastrar suas informações :/ Que tal fazer isso agora? </h4>
                    <add-juridica></add-juridica>
            </div>
            <div v-else>
              <div v-for="show in juridica" :key="show.id">
                <h4>Razão Social: <strong>{{show.razao}}</strong></h4>
                <p>CNPJ: {{show.cnpj}}</p>
                <p>Missão: {{show.missao}}</p>
                <p>Ramo: {{show.ramo}}</p>
                <p>Rua: {{show.endereco.rua}}</p>
                <p>Bairro: {{show.endereco.bairro}}</p>
                <p>Cidade: {{show.endereco.cidade}}</p>
                <p>CEP: {{show.endereco.cep}}</p>
                <p>País {{show.endereco.pais}}</p>
                <p>Estado {{show.endereco.estado}}</p>
                <p>Telefone: {{show.contato.fixo}}</p>
                <p>Telefone Celular: {{show.contato.celular}}</p>
                <hr>
                <h3>Redes Sociais</h3>
                <p>Facebook: {{show.contato.facebook}}</p>
                <p>Twitter: {{show.contato.twitter}}</p>
                <p>Linkedin: {{show.contato.linkedin}}</p>
                <p>Site: {{show.contato.site}}</p>
                <p>Outra: {{show.contato.outraRede}}</p>
            </div>  
             <hr>
            <div class="panel-footer">
                <button @click="onEdit()" class="btn btn-lg btn-warning">Editar Informações</button>
                <router-link to="/dashboard-juridica" class="btn btn-lg btn-default ">Voltar</router-link>
                <button @click="onDelete()" class="btn btn-lg btn-danger">Deletar Conta</button>
        </div>   
        </div>
        </div>
        
    </div>
</template>

<script>

    import NewJuridicaData from '../Create/NewJuridicaData';
    export default {

        data(){
            return{
                juridica: [],
                uri: 'http://localhost:8000/api/pjuridicas/',
                token:  this.$session.get('jwt'),
                loadFlag: false

            }
        },
        components: {'add-juridica': NewJuridicaData},
        methods: {

            loadJuridica(){
                const user_id = this.$session.get('user_id');
                this.axios.get(this.uri + user_id + '?token=' + this.token)
                    .then(response => {
                 
                       if(response.data.juridica[0].contatos_id && response.data.juridica[0].enderecos_id !== null){
                           this.loadFlag = true;
                           this.juridica = response.data.juridica;
                           console.log(this.loadFlag);
                       }
                 
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onEdit(){
                this.$router.push({ name: 'add-juridica', params: { editing: true }})
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

        created(){
             
            this.loadJuridica();
        }
       
    }
</script>


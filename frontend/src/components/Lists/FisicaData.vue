<template>
    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">

            <div v-if="dataCompleted">
             <h2>Informações Pessoais</h2>
             <ul> <h1>{{displayPessoaFisica}}</h1>
                <h4> <strong>Nome Completo</strong>: {{displayPessoaFisica.nome}}</h4>
                <li> <strong>Data de Nascimento</strong>: {{displayPessoaFisica.nascimento | dateFormat}}</li>
                <li> <strong>Gênero</strong>: {{displayPessoaFisica.genero}}</li>
                <li> <strong>Estado Civil</strong>: {{displayPessoaFisica.estadoCivil}}</li>
                <li> <strong>CPF</strong>: {{displayPessoaFisica.cpf}}</li>
                <li> <strong>Rua</strong>: {{displayPessoaFisica.rua}}</li>
                <li> <strong>Bairro</strong>: {{displayPessoaFisica.bairro}}</li>
                <li> <strong>Cidade</strong>: {{displayPessoaFisica.cidade}}</li>
                <li> <strong>CEP</strong>: {{displayPessoaFisica.cep}}</li>
                <li> <strong>País de Nacionalidade</strong>: {{displayPessoaFisica.cep}}</li>
                <li> <strong>Telefone Fixo</strong>: {{displayPessoaFisica.fixo}}</li>
                <li> <strong>Telefone Celular</strong>: {{displayPessoaFisica.celular}}</li>
             </ul>
         
             <hr>

                <curriculo></curriculo>

             <div class="panel-footer">
                <button @click="onEdit" class="btn btn-lg btn-warning">Editar Informações</button>
                <router-link to="/DashFIS" tag="button" class="btn btn-lg btn-default ">Voltar</router-link>
                <button @click="onDelete()" class="btn btn-lg btn-danger">Deletar Conta</button>
            </div>

            </div>
            <div v-else>
                <h4>Você ainda não completou suas informações... Que tal fazer isso agora?</h4>
                <new-curriculo></new-curriculo>
            </div>

        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import moment from 'moment'
    import Curriculo from './Curriculo.vue';
    import NewCurriculo from '../Create/NewCurriculo.vue';
    export default {
        components: {'curriculo': Curriculo, 'new-curriculo': NewCurriculo},
        methods: {
            ...mapActions([
                'loadFisica'
            ]),
            onEdit(){
             
            this.$router.push({ name: 'new-curriculo'});
            //this.$router.push({ name: 'new-curriculo', params: { editing: true }})
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
        computed: {
            ...mapGetters([
                'dataCompleted', 'displayPessoaFisica'
            ]),
        },
        filters:{
            dateFormat: function(value){
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY')
                }
            }
        },
       async created(){
          
            await this.loadFisica();
            console.log('neve', this.displayPessoaFisica)
        },
        watch: {
            async displayPessoaFisica() {
            await this.loadFisica();
            }
        }
    }
</script>
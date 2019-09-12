<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Currículo</h2></div>
        <div class="panel-body">
            <div v-if="curriculo.length == 0" class="text-center">
                    <h4> Você ainda não cadastrou seu currículo :/ </h4>
            </div>
            <div v-else>
                <div v-for="show in curriculo" :key="show.id"> 
                    <h1>Redes Sociais</h1>
                    <hr>
                    <span v-if="typeof show.contato.facebook !== 'undefined'">Facebook: {{show.contato.facebook}}</span>
                    <span v-if="typeof show.contato.twitter !== 'undefined'">Twitter: {{show.contato.twitter}}</span>
                    <span v-if="typeof show.contato.linkedin !== 'undefined'">Linkedin: {{show.contato.linkedin}}</span>
                    <span v-if="typeof show.contato.site !== 'undefined'">Site: {{show.contato.site}}</span>
                    <span v-if="typeof show.contato.outraRede !== 'undefined'"> Outra: {{show.contato.outraRede}}</span>
                    <hr>
                    <h1>Objetivos</h1>
                    <p>{{show.objetivos}}</p>
                    <hr>
                    <h1>Área de Atuação</h1>
                    <p>{{show.area.tipo}}</p>
                    <hr>
                    <h1>Pretensão Salarial</h1>
                    <p>{{show.pretensao}}</p>
                    <hr>
                    <h1>Formação Acadêmica</h1>
                    <p>{{show.escolaridade}}</p>
                    <hr>
                    <h1>Histórico Profissional</h1>
                    <p>{{show.historicoProfissional}}</p>
                    <hr>
                    <h1>Qualificações</h1>
                    <p>{{show.qualificacoes}}</p>
                </div>
            </div>  
             <hr>
    </div>
</div>
</template>

<script>

    export default {

        data(){
            return{
                curriculo: []

            }
        },
        methods: {

            loadCurriculo(){
            
                const user_id = this.$session.get('user_id');
                const token = this.$session.get('jwt');
                this.axios.get('http://localhost:8000/api/curriculos/' + user_id + '?token=' + token)
                    .then(response => {
                        this.curriculo = response.data.curriculo
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },
        created(){
            this.loadCurriculo();
        }
       
    }
</script>
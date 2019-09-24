<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Currículo</h2></div>
        <div class="panel-body">
            <div v-if="curriculo.length == 0" class="text-center">
                    <h4> Você ainda não cadastrou seu currículo :/ </h4>
            </div>
            <div v-else-if="curriculo.length>0">
                <div v-for="show in curriculo" :key="show.id"> 
                    
                    <h3>Redes Sociais</h3>
                    <hr>
                       {{show.fisica}}
                        <!--<span v-if="typeof show.fisica.contato.facebook !== 'undefined'">Facebook: {{show.contato.facebook}}</span>
                        <span v-if="typeof show.fisica.contato.twitter !== 'undefined'">Twitter: {{show.contato.twitter}}</span>
                        <span v-if="typeof show.fisica.contato.linkedin !== 'undefined'">Linkedin: {{show.contato.linkedin}}</span>
                        <span v-if="typeof show.fisica.contato.site !== 'undefined'">Site: {{show.contato.site}}</span>
                        <span v-if="typeof show.fisica.contato.outraRede !== 'undefined'"> Outra: {{show.contato.outraRede}}</span> -->
                    <hr>
                    <h3>Objetivos</h3>
                    <p>{{show.objetivos}}</p>
                    <hr>
                    <h3>Área de Atuação</h3>
                    <p>{{show.area.tipo}}</p>
                    <hr>
                    <h3>Pretensão Salarial</h3>
                    <p>{{show.pretensao}}</p>
                    <hr>
                    <h3>Formação Acadêmica</h3>
                    <p>{{show.escolaridade}}</p>
                    <hr>
                    <h3>Histórico Profissional</h3>
                    <p>{{show.historicoProfissional}}</p>
                    <hr>
                    <h3>Qualificações</h3>
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
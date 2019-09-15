<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Candidaturas</h2></div>
            <div class="panel-body" v-for="show in candidaturas" :key="show.id" :id="show.id">     
              <h3><span class="label label-info ">Título da Vaga:{{show.vaga.titulo}}</span></h3>
                <p>Candidato: {{show.curriculo.fisicas_id}}</p>

                <button @click="onSchedule(show.id)" class="btn btn-sm btn-success">Marcar Entrevista</button>
                <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Deletar</button>  
               
        </div>
    </div>
</template>


<script>
   
    export default {
        data(){
            return{
              
                candidaturas: [],
                fisicas:[],
                uri: 'http://localhost:8000/api/candidaturas',
                token: this.$session.get('jwt')
            }
        },
        methods: {
            
            loadCandidaturas(){
                const user_id = this.$session.get('user_id');
                this.axios
                    .get(this.uri + '?token=' + this.token)
                    .then(response => {
                        this.candidaturas = response.data.candidaturas,
                        this.fisicas = response.data.fisicas
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onSchedule(candidaturaId){
               this.$router.push({ name: 'agendar', params: { candidaturaId }})
            }
        },
        created(){
            this.loadCandidaturas();
        }
    }
</script>
<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Candidaturas</h2></div>
            <div class="panel-body" v-for="show in candidaturas" :key="show.id" :id="show.id">     
              <h3><span class="label label-info ">Título da Vaga:{{show.vaga.titulo}}</span></h3>
                <p>DADOS DA VAGA: {{show.vaga}}</p>
                <p>Candidato: {{show.curriculo}}</p>
                 <h4>STATUS: {{show.status}}</h4>
            <div v-if="!isFIS">
                <button @click="onSchedule(show.id)" class="btn btn-sm btn-success">Marcar Entrevista</button>
                <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Deletar</button>
            </div>
            <div v-else>
                <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Desistir</button>
            </div>
            <hr>
        </div>
    </div>
</template>


<script>
   
    export default {
        data(){
            return{
              
                candidaturas: [],
                uri: 'http://localhost:8000/api/candidaturas',
                token: this.$session.get('jwt'),
                isFIS: false
            }
        },
        methods: {
            
            loadCandidaturas(){
                const user_id = this.$session.get('user_id');
                this.axios
                    .get(this.uri + '?token=' + this.token)
                    .then(response => {
                        if(this.$session.get('role') === 'JURIDICA'){
                            this.candidaturas = response.data.candidaturas;
                        }else{
                            this.candidaturas = response.data.candidaturasFisica;
                        }
                       
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onSchedule(candidaturaId){
               this.$router.push({ name: 'new-agenda', params: { candidaturaId }})
            }
        },
        beforeMount(){
               if(this.$session.get('role') === 'FISICA'){this.isFIS = true}
        },
        created(){
            this.loadCandidaturas();
        }
    }
</script>
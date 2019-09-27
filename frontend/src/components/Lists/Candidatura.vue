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
                <div v-if="agendamento">
                  
                </div>
                <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Desistir</button>
            </div>
            <hr>
        </div>
    </div>
</template>


<script>
   
    import NewAgenda from '../Create/NewAgenda';

    export default {
        data(){
            return{
              
                candidaturas: [],
                uri: 'http://localhost:8000/api/candidaturas',
                token: this.$session.get('jwt'),
                isFIS: false,
                agendamento: false
            }
        },
        components: {NewAgenda},
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
                            if(response.data.candidaturasFisica[0].status === 'EM AGENDAMENTO'){
                                this.agendamento = true;
                            }
                        }
                       
                        console.log(response.data);
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
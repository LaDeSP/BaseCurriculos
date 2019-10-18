<template>
    <div class="row justify-content-center">
      <div class="panel-heading"><h2>Candidaturas</h2></div>
      <div class="row">
        <div v-for="show in candidaturas" :key="show.id" :id="show.id">
          <card style="width: 30rem;">
            <template v-slot:card-header>
              <h3><span class="label label-info ">Título da Vaga:{{show.vaga.titulo}}</span></h3>
            </template>
            <template v-slot:card-body>
              <p>DADOS DA VAGA: {{show.vaga}}</p>
            </template>
            <template v-slot:card-footer>
              <div v-if="!isFIS">
                  <button @click="onSchedule(show.id)" class="btn btn-sm btn-success">Ver Candidatos</button>
                  <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Deletar</button>
              </div>
              <div v-else>
                  <div v-if="agendamento">
                  </div>
                  <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Desistir</button>
              </div>
            </template>
          </card>
        </div>
      </div>
    </div>
</template>


<script>
    import card from '../Utils/CardsVagas';
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

            console.log('teste', localStorage.getItem('auth'));
        }
    }
</script>

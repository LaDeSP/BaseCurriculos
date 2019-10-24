<template>
    <div class="row justify-content-center">
      <div class="panel-heading"><h2>candidaturas</h2></div>
      <div class="row">
        <div v-for="show in displayCandidaturas" :key="show.id" :id="show.id">
          <Card style="width: 30rem;">
            <template v-slot:card-header>
              <h3><span class="label label-info ">Vaga:{{show.vaga.titulo}}</span></h3>
            </template>
            <template v-slot:card-body>
              <p>Cargo: {{show.vaga.cargo}}</p>
              <p>Detalhes: {{show.vaga}}</p>
            </template>
            <template v-slot:card-footer>
              <div v-if="permissaoDoUsuario === 'JURIDICA'">
                  <button @click="onSchedule(show.id)" class="btn btn-sm btn-success">Ver Candidatos</button>
                  <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Deletar</button>
              </div>
              <div v-else>
                  <div v-if="agendamento">
                  </div>
                  <button @click="onDelete(show.id)" class="btn btn-sm btn-danger">Desistir</button>
              </div>
            </template>
          </Card>
        </div>
      </div>
    </div>
</template>


<script>
    import Card from '../Utils/CardsVagas';
    import NewAgenda from '../Create/NewAgenda';
    import {mapGetters, mapActions} from 'vuex';

    export default {
        data(){
            return{

                candidaturas: [],
                agendamento: false
            }
        },
        components: {NewAgenda, Card},
        methods: {
            ...mapActions([
                'loadCandidaturas'
            ]),
            loadAAAAACandidaturas(){
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
        
        computed: {
            ...mapGetters([
                'displayCandidaturas', 'permissaoDoUsuario'
            ]),
        },

        async created(){
            await this.loadCandidaturas();
            console.log(this.displayCandidaturas)
          
        },  
        
    }
</script>

<template>
  <div class="row justify-content-center">
    <div class="col-6">
        <ValidationObserver v-slot="{ invalid }">
          <form >
              <div v-if="notificacoes">
                  <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                      {{notificacao[0]}}
                  </span>
              </div>
              <card class="form-row justify-content-center">
                <template v-slot:card-header >
                  <div cclass="d-flex justify-content-center">
                    <center><h1 v-if="!editing">Agendar Entrevista</h1>
                    <h1 v-else>Editar Entrevista</h1></center>
                  </div>
                </template>
                <template v-slot:card-body>
                  <div class="col-12">
                    <div class="form-group">
                        <label for="data">* Dia</label>
                        <ValidationProvider name="data" rules="required">
                            <div slot-scope="{ errors }">
                                <input type="date" class="form-control" name="data" v-model="data">
                                <p>{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="hora">* Hora</label>
                        <ValidationProvider name="hora" rules="required">
                            <div slot-scope="{ errors }">
                                <input type="time" name="hora"
                                class="form-control" v-model="hora">
                                <p>{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="observacao">Observação:</label>
                        <ValidationProvider name="observacao" rules="max:500">
                            <div slot-scope="{ errors }">
                                <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                                <p>{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>

                  </div>
                  </template>
                  <template v-slot:card-footer class="justify-content-center">
                    <div v-if="editing === false">
                      <div class="row">
                        <div class="col-md-10 float-left" >
                          <router-link class="btn btn-danger btn-lg" to="/dashboard-fisica">Voltar</router-link>
                        </div>
                        <div class="col-md-2 float-right" >
                          <button :disabled="invalid" @click.prevent="register" type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      <div class="row">
                        <div class="col-md-10 float-left" >
                          <router-link class="btn btn-default" to="/dashboard-juridica">Voltar</router-link>
                        </div>
                        <div class="col-md-2 float-right" >
                          <button :disabled="invalid" @click.prevent="register" type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                      </div>
                    </div>
                </template>
              </card>
          </form>
      </ValidationObserver>
    </div>
  </div>
</template>

<script>
  import card from '../Utils/Card';
  import {mapState, mapActions, mapGetters} from 'vuex';

  export default{
    components:{
      card
    },
    data(){
      return{
        data: '',
        hora: '',
        observacao: '',
        contraproposta: '',
        candidatura_id: 0,
        editing: false,
        notificacoes: [],
      }
    },
    methods: {

      ...mapActions(['loadAgenda']),

      register(){
        let newAgendaData = {
          data: this.data,
          hora: this.hora,
          observacao: this.observacao,
          candidatura_id: this.$session.get('candidato_id'),
          update_id: this.$route.params.id
        }

        if(!this.editing){
          this.$store.dispatch('newAgenda', newAgendaData)
          .then( response => { 
            if(response.error  != undefined){
              this.notificacoes = response.error;
            }
            else{
              console.log('deu bonm');
              this.$router.push({ name: 'agenda' })
            }
          
          })
          .catch(error => console.log(error))
        }else{
          this.$store.dispatch('updateAgenda', newAgendaData)
          .then( response => { 
            if(response.error  != undefined){
              this.notificacoes = response.error;
            }
            else{
              console.log('deu bonm');
              this.$router.push({ name: 'agenda' })
            }
          
          })
          .catch(error => console.log(error))
        }
      },

      displayDataEdit(){
        console.log('displaydatdaedit', this.agendaById[0])
        this.data = this.agendaById[0].data;
        this.hora = this.agendaById[0].hora;
        this.observacao = this.agendaById[0].observacao;
      }
    },

    computed:{ 
      ...mapState([
        'agenda'
      ]),
      ...mapGetters([
        'displayAgendaById'
      ]),
      agendaById() {
          return this.displayAgendaById(this.$route.params.id)
      },
    },

    async created(){
      
      if(this.$route.params.id){
        this.editing = true;
        await this.loadAgenda();
        this.displayDataEdit();
      }
    }

  }
</script>

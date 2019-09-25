<template>
 <div class="row justify-content-center">
    <div class="col-sm-12">
        <ValidationObserver v-slot="{ invalid }">
            <form>
                <h1 v-if="!editing">Agendar Entrevista</h1>
                <h1 v-else>Editar Entrevista</h1>
                <div class="form-row">
                    <div class="col-6">

                        <div class="form-group"> 
                            <label for="data">Dia</label>
                            <ValidationProvider name="data" rules="required">
                                <div slot-scope="{ errors }">
                                    <input type="date" class="form-control" name="data" v-model="data">
                                    <p>{{ errors[0] }}</p>
                                </div>
                            </ValidationProvider>
                        </div>
                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input type="time" name="hora" 
                            class="form-control" v-model="hora">
                        </div>
                        <div class="form-group">
                            <label for="observacao">Observação:</label>
                            <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao"></textarea>
                        </div>
                        <div v-if="editing === false">
                            <button :disabled="invalid" @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
                            <router-link class="btn btn-default" to="/dashboard-fisica">Voltar</router-link>
                        </div>
                        <div v-else>
                            <button :disabled="invalid" @click.prevent="edit" type="submit" class="btn btn-primary">Enviar</button>
                            <router-link class="btn btn-default" to="/dashboard-fisica">Voltar</router-link>
                        </div>
                    </div>
                </div>
            </form>
        </ValidationObserver>
    </div>
</div>
</template>

<script>

    export default {
    
        data(){
            return{

                data: '',
                hora: '',
                observacao: '',
                candidatura_id: 0, 
                editing: false,
                uri: 'http://localhost:8000/api/agenda',
                token: this.$session.get('jwt'),
              
                
            }
        },
        methods: {

            register(){
                this.axios.post(this.uri + '?token=' + this.token, {
                        data: this.data,
                        hora: this.hora,
                        observacao: this.observacao,
                        candidatura_id: this.$route.params.candidaturaId
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response.data)
                    )
                    .catch(
                        (error) => console.log(error)
                    );
            },
          
        },
        mounted(){
            console.log(this.$route.params.candidaturaId);
        }
     
        
    }
</script>

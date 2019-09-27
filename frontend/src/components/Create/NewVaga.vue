<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <ValidationObserver v-slot="{ invalid }">
            <form>
                <h1 v-if="!editing">Cadastro de Vaga</h1>
                <h1 v-else>Editar Vaga</h1>

                <div class="form-group">
                    <label for="titulo">Título</label>
                    <ValidationProvider name="titulo" rules="required">
                        <div slot-scope="{ errors }">
                            <input type="titulo" name="titulo" 
                            class="form-control" v-model="titulo">
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>   
                </div>
                <div class="form-group">
                    <label for="local">Local</label>
                    <ValidationProvider name="local" rules="required">
                        <div slot-scope="{ errors }">
                            <input type="text" class="form-control" name="local" v-model="local">
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>   
                </div>
                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <ValidationProvider name="quantidade" rules="required|numeric">
                        <div slot-scope="{ errors }">
                            <input type="number" class="form-control" name="quantidade" v-model="quantidade">
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>   
                </div>
                <div class="form-group"> 
                    <label for="area">Área de Atuação</label>
                        <select class="custom-select" name="area" v-model="area">
                            <option value="" disabled selected>Selecione uma Área</option>
                            <option v-for="area in areas" :key="area.id" :value="area.id">
                                {{area.tipo}}
                            </option>
                        </select>
                </div>
                <div class="form-group">
                    <label for="salario">Salário</label>
                    <ValidationProvider name="salario" rules="required|numeric">
                        <div slot-scope="{ errors }">
                            <input type="number"  name="salario" 
                            class="form-control" v-model="salario" step="any">
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>   
                </div>
                <div class="form-group">
                    <label for="jornada">Jornada de Trabalho</label>
                    <ValidationProvider name="jornada" rules="required">
                        <div slot-scope="{ errors }">
                            <input type="jornada" name="jornada" 
                            class="form-control" v-model="jornada">
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>   
                </div>
                <div class="form-group">
                    <label for="beneficios">Benefícios</label>
                    <ValidationProvider name="beneficios" rules="required">
                        <div slot-scope="{ errors }">
                            <textarea class="form-control" rows="3" v-model="beneficios"></textarea>
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>   
                </div>
                <div class="form-group">
                    <label for="requisitos">Requisitos</label>
                    <ValidationProvider name="beneficios" rules="required">
                        <div slot-scope="{ errors }">
                            <textarea class="form-control"  rows="3" v-model="requisitos"></textarea>
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>   
                </div>
                <div v-if="editing === false">
                    <button @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
                <div v-else>
                    <button :disabled="invalid" @click.prevent="edit" type="submit" class="btn btn-primary">Enviar</button>
                </div>
                <router-link to="/dashboard" class="btn btn-danger">Cancelar</router-link>
            </form>
        </ValidationObserver>
    </div>
</div>
</template>

<script>

    export default {
    
        data(){
            return{

                titulo: '',
                local: '',
                salario: '',
                beneficios: '',
                requisitos: '',
                area: '',
                jornada: '',
                quantidade: 0,
                areas: [],
                uri: 'http://localhost:8000/api/vagas',
                token: this.$session.get('jwt'),
                editing: false
                
               
            }
        },
        methods: {
            register(){
           
                this.axios.post(this.uri + '?token=' + this.token, 
                    {
                        titulo: this.titulo,
                        local: this.local,
                        quantidade: this.quantidade,
                        salario: this.salario,
                        beneficios: this.beneficios,
                        requisitos: this.requisitos,
                        area: this.area,
                        jornada: this.jornada,
                        status: 'ATIVA',
                        user_id: this.$session.get('user_id')    
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                    )
                    .catch(
                        (error) => console.log(error),
                        
                    );
            },
            
            verifyEdit(){
                
                if(this.$route.params.editing === true) this.editing = true;
                
                    console.log('verifyedit:', this.editing);
            },

            edit(){
                
                let vaga_id = this.$route.params.vaga_id;

                this.axios.put(this.uri + '/' + vaga_id + '?token=' + this.token, 

                    {
                        titulo: this.titulo,
                        local: this.local,
                        quantidade: this.quantidade,
                        salario: this.salario,
                        beneficios: this.beneficios,
                        requisitos: this.requisitos,
                        area: this.area,
                        jornada: this.jornada     
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response)
                    )
                    .catch(
                        (error) => console.log(error)
                    );
            },

            loadArea(){
             
                this.axios.get('http://localhost:8000/api/areas?token=' + this.token)

                    .then(response => {
                        this.areas = response.data.areas
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );

                    console.log(this.token);
            },

            loadDataEdit(){

                const vaga_id = this.$route.params.vaga_id; 

                this.axios.get(this.uri + '/' + vaga_id + '?token=' + this.token)
                    .then(response=>{
                         
                         this.titulo = response.data.vaga.titulo,
                         this.local = response.data.vaga.local,
                         this.quantidade = response.data.vaga.quantidade,
                         this.salario = response.data.vaga.salario,
                         this.requisitos = response.data.vaga.requisito,
                         this.beneficios = response.data.vaga.beneficio,
                         this.area = response.data.vaga.area,
                         this.jornada = response.data.vaga.jornada
                         console.log(response.data.vaga)
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },

        created() {
            console.log(this.$session.get('user_id'));
            this.loadDataEdit();
            this.loadArea();  

        },

        mounted(){
            this.verifyEdit();
        }
        
    }
</script>

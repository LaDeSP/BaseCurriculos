<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1 v-if="!editing">Cadastro de Vaga</h1>
            <h1 v-else>Editar Vaga</h1>

            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="titulo" id="titulo" name="titulo" 
                class="form-control" v-model="titulo">
            </div>
            <div class="form-group">
                <label for="local">Local</label>
                <input type="text" class="form-control" name="local" v-model="local">
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
                <input type="salario" id="salario" name="salario" 
                class="form-control" v-model="salario">
            </div>
            <div class="form-group">
                <label for="jornada">Jornada de Trabalho</label>
                <input type="jornada" id="jornada" name="jornada" 
                class="form-control" v-model="jornada">
            </div>
            <div class="form-group">
                <label for="beneficios">Benefícios</label>
                <textarea class="form-control" id="beneficios" rows="3" v-model="beneficios"></textarea>
            </div>
            <div class="form-group">
                <label for="requisitos">Requisitos</label>
                <textarea class="form-control" id="requisitos" rows="3" v-model="requisitos"></textarea>
            </div>
            <div v-if="editing === false">
                <button @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
            <div v-else>
                <button @click.prevent="edit" type="submit" class="btn btn-primary">Enviar</button>
            </div>
            <router-link to="/dashboard" class="btn btn-danger">Cancelar</router-link>
        </form>
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
                areas: [],
                uri: 'http://localhost:8000/api/vagas',
                token: this.$session.get('jwt'),
                editing: false
                
               
            }
        },
        methods: {
            register(){
                const user_id = this.$session.get('user_id');
           
                this.axios.post(this.uri + '?token=' + this.token, 
                    {
                        titulo: this.titulo,
                        local: this.local,
                        salario: this.salario,
                        beneficios: this.beneficios,
                        requisitos: this.requisitos,
                        area: this.area,
                        jornada: this.jornada,
                        user_id: this.user_id     
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
             
                this.axios.get(this.uri + '?token=' + this.token)

                    .then(response => {
                        this.areas = response.data.areas
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
            
            this.loadDataEdit();
            this.loadArea();  

        },

        mounted(){
            this.verifyEdit();
        }
        
    }
</script>

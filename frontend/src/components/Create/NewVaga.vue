<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Vaga</h1>

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
            <button @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
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
                uri: 'http://localhost:8000/api/vagas?token='
               
            }
        },
        methods: {
            register(){
                const token = this.$session.get('jwt');
                const user_id = this.$session.get('user_id');
           
                this.axios.post(this.uri + token, 
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
         
            loadArea(){
                const token = this.$session.get('jwt');
                this.axios.get(this.uri + token)
                    .then(response => {
                        this.areas = response.data.areas
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },
        beforeMount(){
                const role = localStorage.getItem('role');
                if(role === 'ADMIN'){
                    this.isAdmin = true
                }else if(role === 'COORDENADOR'){
                    isCoor = true
                }
        },
        mounted(){
            this.loadArea();
        }
        
    }
</script>

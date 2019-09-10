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
                <label for="salario">Salário</label>
                <input type="salario" id="salario" name="salario" 
                class="form-control" v-model="salario">
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
  import axios from 'axios';

    export default {
    
        data(){
            return{

                titulo: '',
                area: '',
                empresa: '',
                supervisor: '',
                requisitos: '',
                ////
                supervisores: [],
                empresas: [],
                isAdmin: false,
                isCoor: false
                ///
                
            }
        },
        methods: {
            register(){
                const token = localStorage.getItem('token');
                const user_id = localStorage.getItem('user_id');

                axios.post('http://localhost:8000/api/vaga?token=' + token, 
                    {
                        titulo: this.titulo,
                        area: this.area,
                        empresa: this.empresa,
                        supervisor: this.supervisor,
                        isAdmin: this.isAdmin,
                        requisitos: this.requisitos,
                        coordenador: user_id
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                        //alert("Cadastrado com sucesso"),
                    )
                    .catch(
                        (error) => console.log(this.role)
                    );

                    this.$router.push({ name: 'vagas' })
            },
         
            loadES(){
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/vaga/create?token=' + token)
                    .then(response => {
                        this.empresas = response.data.empresas
                        this.supervisores = response.data.supervisores
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
            this.loadES();
        }
        
    }
</script>

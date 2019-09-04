<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Curso</h1>
            
            <div class="form-group">
                <label for="nome">Nome do Curso</label>
                <input type="text" id="nome" name="nome" 
                class="form-control" v-model="nome">
            </div>
            <div class="form-group"> 
                <label for="instituicao">Instituição</label>
                    <select class="custom-select" name="instituicao" v-model="instituicao">
                        <option value="" disabled selected>Selecione uma instituição</option>
                        <option v-for="inst in instituicoes" :key="inst.id" :value="inst.id">
                            {{inst.nome}}
                        </option>
                    </select>
            </div>
            <div class="form-group">
                <label for="campus">Campus</label>
                    <select class="custom-select" name="campus" v-model="campus">
                        <option value="" disabled selected>Selecione um campus</option>
                        <option v-for="cam in campuses" :key="cam.id" :value="cam.id">
                            {{cam.nome}}
                        </option>
                    </select>    
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

                nome: '',
                instituicao: '',
                campus: '',
                instituicoes: [],
                campuses: [],
                ///
                auth: localStorage.getItem('role')
                
            }
        },
        methods: {
            register(){
                const token = localStorage.getItem('token');
                axios.post('http://localhost:8000/api/curso?token=' + token, 
               
                    {
                        nome: this.nome,
                        instituicao: this.instituicao,
                        campus: this.campus
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                        alert("Cadastrado com sucesso"),
                    )
                    .catch(
                        (error) => console.log(this.role)
                    );

                    if(this.auth === 'ADMIN'){
                        this.$router.push({ name: 'ADMDash' })
                    }else if(auth === 'COORDENADOR'){
                        this.$router.push({ name: 'COORDash' })
                    }
                    
            },
          
            loadIC(){
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/curso/create?token=' + token)
                    .then(response => {
                        this.campuses = response.data.campuses
                        this.instituicoes = response.data.instituicoes
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },

        mounted(){
            this.loadIC();
        }
        
    }
</script>

<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Editar Coordenador</h1>
         
            <div class="form-group"> 
                <label for="telefone">Telefone</label>
                <div class="form-row">
                    <div class="col-6">
                        <input type="text" class="form-control" name="fixo" placeholder="Fixo" v-model="fixo">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="celular" placeholder="Celular" v-model="celular"> 
                    </div>
                </div>
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
            <div class="form-group"> 
                <label for="curso">Curso</label>
                        <select class="custom-select" name="curso" v-model="curso">
                            <option value="" disabled selected>Selecione um curso</option>
                                    <option v-for="cur in cursos" :key="cur.id" :value="cur.id">
                                        {{cur.nome}}
                            </option>          
                        </select>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" name="cargo"  v-model="cargo">
            </div>
            <div v-if="auth === 'ADMIN'">
                <button @click.prevent="editCoordenador" type="submit" class="btn btn-success">Salvar</button>
                <router-link to="{name: ADMDash}" class="btn btn-danger">Cancelar</router-link>
            </div>
            <div v-else-if="auth === 'COORDENADOR'">
                 <button @click.prevent="editCoordenador" type="submit" class="btn btn-success">Salvar</button>
                <router-link to="{name: COORDash}" class="btn btn-danger">Cancelar</router-link>
            </div>

        </form>
    </div>
</div>
</template>

<script>
  import axios from 'axios';

    export default {
    
        data(){
            return{

               
                celular: '',
                fixo: '',
                cargo: '',
                curso: '',
                instituicao: '',
                campus: '',
                ////
                cursos: [],
                instituicoes: [],
                campuses: [],
                ///
                auth: localStorage.getItem('role')
                
            }
        },
        methods: {
            editCoordenador(){
                const token = localStorage.getItem('token');
                axios.put('http://localhost:8000/api/coordenador/' + this.$route.params.id + '?token=' + token, 

                    {
                    
                        
                        celular: this.celular,
                        fixo: this.fixo,
                        cargo: this.cargo,
                        curso: this.curso,
                        instituicao: this.instituicao,
                        campus: this.campus
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                        alert("Editado com sucesso"),
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
            
             //inst, campus, curso
            getEditCoordenador(){
                
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/coordenador/create?token=' + token)
                    .then(response => {
                        this.cursos = response.data.cursos
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
            this.getEditCoordenador();
        }
        
    }
</script>

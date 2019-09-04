<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Editar Aluno</h1>
         
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
                <label for="endereco">Endereço</label>
                    <div class="form-row">
                        <div class="col-3">
                            <input type="text" class="form-control" name="rua" placeholder="Rua" v-model="rua">
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" name="bairro" placeholder="Bairro" v-model="bairro">
                        </div>    
                        <div class="col-3">
                            <input type="text" class="form-control" name="cidade" placeholder="Cidade" v-model="cidade">
                        </div>    
                        <div class="col">
                            <input type="text" class="form-control" name="cep" placeholder="CEP" v-model="cep">
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
                <label for="semestre">Semestre</label>
                <input type="text" class="form-control" name="semestre" placeholder="Semestre" v-model="semestre">
            </div>
            <div v-if="auth === 'ADMIN'">
                <button @click.prevent="editAluno" type="submit" class="btn btn-success">Salvar</button>
                <router-link to="{name: ADMDash}" class="btn btn-danger">Cancelar</router-link>
            </div>
            <div v-else-if="auth === 'COORDENADOR'">
                 <button @click.prevent="editAluno" type="submit" class="btn btn-success">Salvar</button>
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

                rua: '',
                bairro: '',
                cidade: '',
                cep: '',
                celular: '',
                fixo: '',
                semestre: '',
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
            editAluno(){
                const token = localStorage.getItem('token');
                axios.put('http://localhost:8000/api/aluno/' + this.$route.params.id + '?token=' + token, 

                    {
                    
                        rua: this.rua,
                        bairro: this.bairro,
                        cidade: this.cidade,
                        cep: this.cep,
                        celular: this.celular,
                        fixo: this.fixo,
                        semestre: this.semestre,
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
            getEditAluno(){
                
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/aluno/' + this.$route.params.id + '/edit?token=' + token)
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
            this.getEditAluno();
        }
        
    }
</script>

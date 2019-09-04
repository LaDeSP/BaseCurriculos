<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Aluno</h1>
            <div class="form-group">
                <label for="username">Nome de Usuário</label>
                <input type="text" id="username" name="username" 
                class="form-control" v-model="username" placeholder="Ex. nome.sobrenome">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                class="form-control" v-model="email">
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" 
                class="form-control" v-model="password">
            </div>
            
            <hr>
            
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="nome" id="nome" name="nome" 
                class="form-control" v-model="nome">
            </div>
        
            <div class="form-group"> 
                <label for="nascimento">Data de Nascimento</label>
                <input type="date" class="form-control" name="nascimento" v-model="nascimento">
            </div>
            <div class="form-group"> 
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" placeholder="Ex. 999.999.999-99" v-model="cpf">
            </div>
            <div class="form-group">
                <label for="rg">RG</label>
                <input type="text" class="form-control" name="rg" placeholder="RG" v-model="rg">
            </div>
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
            <div class="form-group">
                <label for="rga">RGA</label>
                <input type="text" class="form-control" name="rga" placeholder="Ex. 201505100078" v-model="rga">
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

                username:'',
                email: '',
                password: '',
                ////
                nome: '',
                nascimento: '',
                cpf: '',
                rg: '',
                rua: '',
                bairro: '',
                cidade: '',
                cep: '',
                celular: '',
                fixo: '',
                rga: '',
                semestre: '',
                curso: '',
                instituicao: '',
                campus: '',
                role: 'ALUNO',
                ////
                cursos: [],
                instituicoes: [],
                campuses: [],
                ///
                
            }
        },
        methods: {
            register(){
                const token = localStorage.getItem('token');
                const role = localStorage.getItem('role');
                axios.post('http://localhost:8000/api/aluno?token=' + token, 
                //pra autenticar, precisa de mais uma header
                //essa header só vai dizer pro beck q isso é uma chamada ajax
                    {
                        username: this.username, 
                        email: this.email, 
                        password: this.password,
                        ////
                        nome: this.nome,
                        nascimento: this.nascimento,
                        cpf: this.cpf,
                        rg: this.rg,
                        rua: this.rua,
                        bairro: this.bairro,
                        cidade: this.cidade,
                        cep: this.cep,
                        celular: this.celular,
                        fixo: this.fixo,
                        rga: this.rga,
                        semestre: this.semestre,
                        curso: this.curso,
                        instituicao: this.instituicao,
                        campus: this.campus,
                        role: this.role
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                        alert("Cadastrado com sucesso"),
                    )
                    .catch(
                        (error) => console.log(this.role)
                    );

                    if(this.role == 'ADMIN'){
                        this.$router.push({ name: 'ADMDash' })
                    }else if(role == 'COORDENADOR'){
                        this.$router.push({ name: 'COORDash' })
                    }
                    
            },
             //inst, campus, curso
            loadICC(){
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/aluno/create?token=' + token)
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

        computed: {
           
        },

        mounted(){
            this.loadICC();
        }
        
    }
</script>

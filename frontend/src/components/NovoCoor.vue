<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Coordenador</h1>
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
                <input type="text" class="form-control" name="cargo" v-model="cargo">
            </div>
            <div class="form-group">
                <label for="siape">SIAPE</label>
                <input type="text" class="form-control" name="siape" v-model="siape">
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
                celular: '',
                fixo: '',
                siape: '',
                curso: '',
                instituicao: '',
                campus: '',
                cargo: '',
                role: 'COORDENADOR',
                ////
                cursos: [],
                instituicoes: [],
                campuses: [],
                ///
                auth: localStorage.getItem('role')
                
            }
        },
        methods: {
            register(){
                const token = localStorage.getItem('token');
                axios.post('http://localhost:8000/api/coordenador?token=' + token, 
                    {
                        username: this.username, 
                        email: this.email, 
                        password: this.password,
                        ////
                        nome: this.nome,
                        nascimento: this.nascimento,
                        cpf: this.cpf,
                        rg: this.rg,
                        siape: this.siape,
                        celular: this.celular,
                        fixo: this.fixo,
                        cargo: this.cargo,
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

                    if(this.auth === 'ADMIN'){
                        this.$router.push({ name: 'ADMDash' })
                    }
                    
            },
             //inst, campus, curso
            loadICC(){
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

        computed: {
           
        },

        mounted(){
            this.loadICC();
        }
        
    }
</script>

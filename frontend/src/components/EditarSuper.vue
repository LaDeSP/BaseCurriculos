<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Editar Supervisor</h1>
         
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
                <label for="empresa">Empresa</label>
                    <select class="custom-select" name="empresa" v-model="empresa">
                        <option value="" disabled selected>Selecione uma empresa</option>
                        <option v-for="emp in empresas" :key="emp.id" :value="emp.id">
                            {{emp.nome}}
                        </option>
                    </select>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" name="cargo"  v-model="cargo">
            </div>
            <div class="form-group">
                <label for="area">Área</label>
                <input type="text" class="form-control" name="area"  v-model="area">
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

                fixo: '',
                empresa: '',
                area: '',
                celular: '',
                ////
                empresas: [],
                ///
                auth: localStorage.getItem('role')
                
            }
        },
        methods: {
            editCoordenador(){
                const token = localStorage.getItem('token');
                axios.put('http://localhost:8000/api/supervisor/' + this.$route.params.id + '?token=' + token, 

                    {
                    
                        fixo: this.fixo,
                        empresa: this.empresa,
                        area: this.area,
                        celular: this.celular,
                        
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
   
            getEditSupervisor(){
                
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/supervisor/' + this.$route.params.id + 'edit?token=' + token)
                    .then(response => {
                        this.empresa = response.data.empresas
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },

        mounted(){
            this.getEditSupervisor();
        }
        
    }
</script>

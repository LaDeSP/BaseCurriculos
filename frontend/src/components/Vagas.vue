<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Vagas de Estágio</h2></div>
            <div class="panel-body" v-for="vaga in vagas" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
        
                <h3><span class="label label-info ">Título: {{vaga.titulo}}</span></h3>
                <p>Responsável:{{vaga.responsavel}}</p>
                <p>Área: {{vaga.area}}</p>
                <p>Empresa: {{vaga.empresa.nome}}</p>
                <p>Requisitos: {{vaga.requisitos}}</p>
               <div v-if="isAluno === true">
                   <router-link v-bind:to="'/nova-solicitacao/' + vaga.id" tag="button" class="btn btn-sm btn-warning">Solicitar</router-link>
                   <!--<button @click="onRequest(vaga.id, vaga.coor_id, vaga.super_id)" class="btn btn-sm btn-warning">Solicitar</button> -->
                </div>
               <div v-if="isAdmin === true">
                    <button @click="onDelete(vaga.id)" class="btn btn-sm btn-danger">Apagar</button>
                </div>
                <div v-else-if="isCoor === true && role_id == vaga.coor_id">
                    <button @click="onDelete(vaga.id)" class="btn btn-sm btn-danger">Apagar</button>
                </div>
    
        </div>
    </div>
</template>


<script>
    import axios from 'axios';
    export default {
        data(){
            return{
              
                vagas: [],
                role: '',
                isCoor: false,
                isAdmin: false,
                role_id: null,
                isAluno: false
            }
        },
        methods: {
            loadVagas(){
                const token = localStorage.getItem('token');

                axios
                    .get('http://localhost:8000/api/vaga?token=' + token)
                    .then(response => {
                        this.vagas = response.data.vagas
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onRequest(vagaid, coorid, superid){
                
                //const token = localStorage.getItem('token');
                const user_id = localStorage.getItem('user_id');
                const vaga_id = vagaid;
                const coor_id = coorid;
                const super_id = superid;

                localStorage.setItem('vaga_id', vaga_id)
                localStorage.setItem('cor_id', coor_id)
                localStorage.setItem('sup_id', super_id)
                //console.log(vaga_id)
                //console.log(coor_id)
                //console.log(super_id)

                this.$router.push({ name: 'novasolicitacao' })
                /*axios.post('http://localhost:8000/api/solicitacao/?token=' + token, 
                    {
                       aluno_id: user_id,
                       vaga_id: vaga_id,
                       coor_id: coor_id,
                       super_id: super_id
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                        
                    )
                    .catch(
                        (error) => console.log(this.role)
                    );
                    */
            },
            onDelete(id){
        
                const token = localStorage.getItem('token');
                this.$emit('vagaDeleted', id);
                axios.delete('http://localhost:8000/api/vaga/' + id + '?token=' + token)
                    .then(
                        response => console.log(response),
                    )
                    .catch(
                        error => console.log(error)
                    );
               
            },
            onVagaDeleted(id){
                const position = this.vagas.findIndex((element) => {
                    return element.id == id;
                });

                this.vagas.splice(position, 1);
            }
        },
        beforeMount(){
                const role = localStorage.getItem('role');
                if(role === 'ADMIN'){
                    this.isAdmin = true;
                }else if(role === 'COORDENADOR'){
                    const coor_id = localStorage.getItem('coor_id');
                    this.role_id = coor_id;
                    this.isCoor = true;
                }else if(role === 'ALUNO'){
                    this.isAluno = true
                }
                
        },
        mounted(){
            this.loadVagas();
        }
    }
</script>


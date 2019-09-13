<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Vagas de Emprego</h2></div>
            <div class="panel-body" v-for="vaga in vagas" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
        
                <h3><span class="label label-info ">Título: {{vaga.titulo}}</span></h3>
                <p>Local:{{vaga.local}}</p>
                <p>Área de Atuação: {{vaga.area.tipo}}</p>
                <p>Salário: {{vaga.salario}}</p>
                <p>Jornada de Trabalho: {{vaga.jornada}}</p>
                <p>Benefícios: {{vaga.beneficio}}</p>
                <p>Requisitos: {{vaga.requisito}}</p>
                <div v-if="isFIS === true">
                   <router-link v-bind:to="'' + vaga.id" tag="button" class="btn btn-sm btn-default">Ver mais</router-link>
                   <button @click="onRequest(vaga.id, vaga.coor_id, vaga.super_id)" class="btn btn-sm btn-primary">Se Candidatar</button> 
                </div>
                <button @click="onEdit(vaga.id)" class="btn btn-sm btn-warning">Editar</button> 
               
        </div>
    </div>
</template>


<script>
   
    export default {
        data(){
            return{
              
                vagas: [],
                role: '',
                uri: 'http://localhost:8000/api/vagas',
                token: this.$session.get('jwt'),
                isFIS: false
            }
        },
        methods: {
            loadVagas(){

                this.axios
                    .get(this.uri + '?token=' + this.token)
                    .then(response => {
                        this.vagas = response.data.vagas
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },

            onEdit(vaga_id){

                this.$router.push({ name: 'new-vaga', params: { editing: true, vaga_id }})
            },

            onRequest(vagaid, coorid, superid){
                
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
            },
            onDelete(id){

                this.$emit('vagaDeleted', id);

                this.axios.delete('http://localhost:8000/api/vaga/' + id + '?token=' + this.token)
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

                /*const role = localStorage.getItem('role');
                if(role === 'ADMIN'){
                    this.isAdmin = true;
                }else if(role === 'COORDENADOR'){
                    const coor_id = localStorage.getItem('coor_id');
                    this.role_id = coor_id;
                    this.isCoor = true;
                }else if(role === 'ALUNO'){
                    this.isAluno = true
                }
                */
               if(this.$session.get('role') === 'FISICA'){this.isFIS = true}
                
        },
        mounted(){
            this.loadVagas();
        }
    }
</script>

<!--<div v-if="isAluno === true">
                   <router-link v-bind:to="'/nova-solicitacao/' + vaga.id" tag="button" class="btn btn-sm btn-warning">Solicitar</router-link>
                   <button @click="onRequest(vaga.id, vaga.coor_id, vaga.super_id)" class="btn btn-sm btn-warning">Solicitar</button> 
                </div>
               <div v-if="isAdmin === true">
                    <button @click="onDelete(vaga.id)" class="btn btn-sm btn-danger">Apagar</button>
                </div>
                <div v-else-if="isCoor === true && role_id == vaga.coor_id">
                    <button @click="onDelete(vaga.id)" class="btn btn-sm btn-danger">Apagar</button>
                </div>
    -->
<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Vagas de Emprego</h2></div>
            <div class="panel-body" v-for="vaga in isActive" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">     
              <h3><span class="label label-info ">Título: {{vaga.titulo}}</span></h3>
                <p>Local:{{vaga.local}}</p>
                 <p>Status:{{vaga.status}}</p>
                <p>Quantidade: {{vaga.quantidade}}</p>
                <p>Área de Atuação: {{vaga.area.tipo}}</p>
                <p>Salário: {{vaga.salario}}</p>
                <p>Jornada de Trabalho: {{vaga.jornada}}</p>
                <p>Benefícios: {{vaga.beneficio}}</p>
                <p>Requisitos: {{vaga.requisito}}</p>

                <div v-if="isFIS === true">
                   <router-link v-bind:to="'' + vaga.id" tag="button" class="btn btn-sm btn-default">Ver mais</router-link>
                   <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button> 
                </div>
                <div v-else>
                    <button @click="onEdit(vaga.id)" class="btn btn-sm btn-warning">Editar</button>
                    <button @click="onDelete(vaga.id)" class="btn btn-sm btn-danger">Deletar</button>  
                </div>
               <hr>
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
                auth_jur: 0,
                isFIS: false
            }
        },
        methods: {
            loadVagas(){

                this.axios
                    .get(this.uri + '?token=' + this.token)
                    .then(response => {
                        this.vagas = response.data.vagas
                        this.auth_jur = response.data.auth_jur
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            },

            onEdit(vaga_id){

                this.$router.push({ name: 'new-vaga', params: { editing: true, vaga_id }})
            },

            onRequest(vagaId){
                
                const vaga_id = vagaId;
                this.axios.post('http://localhost:8000/api/candidaturas?token=' + this.token, 
                    {
                        vaga_id: vaga_id,
                        user_id: this.$session.get('user_id')
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                    )
                    .catch(
                        (error) => console.log(error),
                        
                    );
               
            },
            onDelete(id){

                this.$emit('vagaDeleted', id);

                this.axios.delete(this.uri + '/' + id + '?token=' + this.token)
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

        computed:{
             isActive(){
                if(this.$session.get('role') === 'FISICA'){
                    return this.vagas.filter((vaga) => {return vaga.status === 'ATIVA';})
                }else{
                    return this.vagas.filter((vaga) => {return vaga.status === 'ATIVA' && vaga.juridicas_id == this.auth_jur;})
                }
                
            }

        },
        beforeMount(){
               if(this.$session.get('role') === 'FISICA'){this.isFIS = true}
        },
        
        created(){
            this.loadVagas();
        }
    }
</script>
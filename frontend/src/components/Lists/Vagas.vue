<template>
  <div class="row justify-center">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-md-10 float-left" >
          <div class="panel-heading"><h2> {{displayVagasJuridica}} | Minhas Vagas</h2></div>
        </div>
        <div class="col-md-2 float-right" >
          <div class="btn-group btn-group-sm">
            <router-link to="/new-vaga"><button  type="button" class="btn btn-primary"><h4>Criar Vaga <span><i class="fa fa-plus"></i></span></h4></button></router-link>
          </div>
        </div>
      </div>
      <br>
      <div class="d-flex flex-row bd-highlight mb-3">
        <div class="p-2 bd-highlight">
          <div class="btn-group btn-group-sm" role="group">
              <button @click="changeActiveButton('ativa')" type="button" class="active btn btn-outline-success">Vagas Ativas</button>
              <button @click="changeActiveButton" type="button" class="btn btn-outline-secondary">Vagas Inativas</button>
          </div>
        </div>
      </div>
      <div  v-for="vaga in isActive" :key="vaga.id" :id="vaga.id" @vagaDeleted="onVagaDeleted($event)">
        <div class="row">
          <div class="col-sm-4">
            <card>
              <template v-slot:card-header>
                <h3><span class="label label-info ">Título: {{vaga.titulo}}</span></h3>
              </template>
              <template v-slot:card-body>
                <p>Local:{{vaga.local}}</p>
                  <p>Status:{{vaga.status}}</p>
                <p>Quantidade: {{vaga.quantidade}}</p>
                <p>Área de Atuação: {{vaga.area.tipo}}</p>
                <p>Salário: {{vaga.salario}}</p>
                <p>Jornada de Trabalho: {{vaga.jornada}}</p>
                <p>Benefícios: {{vaga.beneficio}}</p>
                <p>Requisitos: {{vaga.requisito}}</p>
              </template>
              <template v-slot:card-footer>
                <div v-if="permissaoDoUsuario === 'FISICA'">
                    <router-link v-bind:to="'' + vaga.id" tag="button" class="btn btn-sm btn-default">Ver mais</router-link>
                    <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button>
                </div>
                <div v-else>
                  <button @click="onEdit(vaga.id)" class="btn btn-sm btn-warning">Editar</button>
                  <span v-if="filterState">
                      <button @click="changeStatus(vaga.id, 'INATIVA')" class="btn btn-sm btn-outline-danger">Desativar</button>
                  </span>
                  <span v-else>
                      <button @click="changeStatus(vaga.id, 'ATIVA')" class="btn btn-sm btn-outline-primary">Ativar</button>
                  </span>
                  <button @click="onDelete(vaga.id)" class="btn btn-sm btn-danger">Deletar</button>
                </div>
              </template>
            </card>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
  import card from '../Utils/Card';
  import { mapActions, mapGetters } from 'vuex';

    export default {
      components:{
      card
    },
    data(){
        return{

            vagas: [],
            role: '',
            auth_jur: 0,
            filterState: true
        }
    },
        methods: {
          ...mapActions([
              'loadVagasJuridica'
          ]),
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
            changeStatus(id, status){

               this.axios.post(this.uri + '/' + 'changeStatus' + '?token=' + this.token,
                    {
                        vaga_id: id,
                        status: status
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response)
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
            },

            changeActiveButton(tipo){

                $('.btn-group').on('click', '.btn', function() {
                    $(this).addClass('active').siblings().removeClass('active');
                });
                if(tipo === 'ativa'){
                    this.filterState = true;
                }else{
                    this.filterState = false;
                }
                console.log('filtersTATE', this.filterState);
            }
        },
        computed:{
             isActive(){

               /* if(this.$session.get('role') === 'FISICA'){
                    return this.vagas.filter((vaga) => {return vaga.status === 'ATIVA';})
                }else{
                    if(this.filterState === true){
                        return this.vagas.filter((vaga) => {return vaga.status === 'ATIVA'})
                    }else{
                        return this.vagas.filter((vaga) => {return vaga.status === 'INATIVA'})
                    }
                } */
                let oi = this.displayVagasJuridica.filter((vaga) => {return vaga.status === 'ATIVA'})
                console.log('oi', oi)
            },  

            ...mapGetters([
              'displayVagasJuridica', 'permissaoDoUsuario'
            ]),

        },

        created(){
            this.loadVagasJuridica();
            console.log('cpmspç', this.displayVagasJuridica)
        },
    }
</script>

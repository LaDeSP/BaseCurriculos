<template>
<div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Painel</h1>
  </div>
    <div class="row">
      <div class="col-xl-12 col-lg-12">
        <card class="border-left-primary shadow h-100">
            <template v-slot:card-header class="py-3">
              <center><router-link to="/vagas" class="font-weight-bold text-primary text-uppercase mb-1">Minhas Candidaturas</router-link></center>
            </template>
            <template v-slot:card-body>
              <div class="row no-gutters align-items-center">

                  <div class="h2 mb-0 font-weight-bold text-gray-900">
                    <div class="row no-gutters align-items-center">
                      <cardvagas style="width: 18rem;">
                        <template v-slot:card-header >
                            <center><h5>Atendente</h5></center>
                        </template>
                        <template v-slot:card-body>
                          <div class=" font-weight-bold text-warning text-uppercase">
                            <center><h5>Aguardando</h5><h1 class="float-none"> <span class="fas fa-spinner fa-pulse"></span></h1></center>
                          </div>
                        </template>
                      </cardvagas>
                      <cardvagas style="width: 18rem;">
                        <template v-slot:card-header >
                            <center><h5>Garçom</h5></center>
                        </template>
                        <template v-slot:card-body>
                          <div class=" font-weight-bold text-warning text-uppercase">
                            <center><h5>Aguardando</h5><h1 class="float-none"> <span class="fas fa-spinner fa-pulse"></span></h1></center>
                          </div>

                        </template>
                      </cardvagas>
                      <cardvagas style="width: 18rem;">
                        <template v-slot:card-header >
                            <center><h5>Panfletagem</h5></center>
                        </template>
                        <template v-slot:card-body>
                          <div class=" font-weight-bold text-warning text-uppercase">
                            <center><h5>Aguardando</h5><h1 class="float-none"> <span class="fas fa-spinner fa-pulse"></span></h1></center>
                          </div>
                        </template>
                      </cardvagas>
                    </div>

                  </div>

                <div class="col-auto">

                </div>
              </div>
            </template>
            <template v-slot:card-footer>
                <center><button @click="onRequest(vaga.id)" class="btn btn-lg btn-primary">Ver Mais <span class="fa fa-eye"></span></button></center>
            </template>
        </card>
      </div>
    </div>
    <vagas></vagas>
</div>
</template>

<script>
  import card from '../Utils/Card';
  import cardvagas from '../Utils/Cards-fisica';
  import vagas from '../Lists/Vagas';
  export default{
    components:{
      card,cardvagas,vagas
    },
  }

</script>


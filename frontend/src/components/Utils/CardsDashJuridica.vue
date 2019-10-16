<template>
<div>
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Painel</h1></div>
    <div class="row">
      <div class="col-xl-6 col-md-12 mb-8">
        <card class="border-left-primary shadow h-100 py-2">
            <template v-slot:card-header class="py-3">
              <h6 class="font-weight-bold text-primary text-uppercase mb-1">Vagas Disponiveis</h6>
            </template>
            <template v-slot:card-body>
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                
                  <div class="h2 mb-0 font-weight-bold text-gray-900">2</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-100"></i>
                </div>
              </div>
            </template>
        </card>
      </div>
      <div class="col-xl-6 col-md-12 mb-8">
        <card class="border-left-success shadow h-100 py-2">
          <template v-slot:card-header class="py-3">
              <h6 class="font-weight-bold text-success text-uppercase mb-1">Currículos Recebidos</h6>
            </template>
            <template v-slot:card-body>
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  
                  <center>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <h2>" 10 "</h2>
                      <i class="fas fa-users"></i>
                    </div>
                  </center>
                </div>
              </div>
            </template>
        </card>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 mb-4">
        <card class="shadow mb-4">
            <template v-slot:card-header class="py-3">
              <h6 class="m-0 font-weight-bold text-primary">Processos em Andamento</h6>
            </template>
            <template v-slot:card-body>
              <h4 class="small font-weight-bold">"Panfletagem" <span class="float-right"> De 7 vagas falta 1</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 90%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold">"Gerente" <span class="float-right"> As vagas estão completas</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold"> "Encaixotador" <span class="float-right">As vagas estão completas</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold"> "Atendentes" <span class="float-right">De 5 vagas faltam 1</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-info" role="progressbar" style="width: 90%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                </div>
              </div>
              <h4 class="small font-weight-bold"> "Supervisor" <span class="float-right">As vagas estão completas</span></h4>
              <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                </div>
              </div>
            </template>
        </card>
      </div>
      <div class="col-lg-6 mb-6">
        <div class="row">
          <div class="col-sm-12">
            <card>
              <template v-slot:card-body>
                <center> <h5 class="card-title">Agendar Entrevista</h5></center>
                <br>
                <div class="input-group">
                  <div class="input-group-predend">
                    <span class="input-group-text"> Vaga:</span>
                  </div>
                  <select class="form-control">
                    <option>Supervisor</option>
                    <option>Atendente</option>
                    <option> Gerente</option>
                    <option>Planfetagem</option>
                  </select>
                </div>
                <br>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Candidato:</span>
                  </div>
                  <select class="form-control">
                    <option>Jorge da Silva</option>
                    <option>João Marcos</option>
                  </select>
                </div>
                <br>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Data:</span>
                  </div>
                  <input type="date">
                </div>
                <br>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Hora:</span>
                  </div>
                  <input type="time">
                </div>
                <br>
                <router-link to="/agenda" class="btn btn-primary"> Agendar</router-link>
              </template>
            </card>
          </div>
        </div>
        <card class="shadow mb-4">
            <template v-slot:card-headear class="py-3">
              <center><h6 class="m-0 font-weight-bold text-primary"> Agendamentos</h6></center>
            </template>
            <template v-slot:card-body >
              <div class="container">
                <div class="row">
                  <div class="col-sm">
                    <div class=" font-weight-bold text-success text-uppercase mb-1">
                      <center>
                        <h5>Confirmados</h5>
                        <h1 class="float-none"> " 5 " <i class="fas fa-check-circle"></i></h1>
                      </center>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class=" font-weight-bold text-warning text-uppercase mb-1">
                      <center>
                        <h5>Aguardando</h5>
                        <h1 class="float-none"> " 3 " <span class="fas fa-spinner fa-pulse"></span></h1>
                      </center>
                    </div>
                  </div>
                </div>
              </div>
            </template>
        </card>
      </div>
  </div>
</div>
</template>

<script>
  import card from '../Utils/Card';
  export default{
    components:{
      card
    },
  }

</script>


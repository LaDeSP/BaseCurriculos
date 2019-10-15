<template>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Painel</h1>
  <div class="row">
    <div class="col-xl-6 col-md-12 mb-8">
      <div class="card border-left-primary shadow h-100 py-2">
        <template v-slot:card-body>
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="font-weight-bold text-primary text-uppercase mb-1"><router-link >Vagas Disponiveis</router-link></div>
              <div class="h2 mb-0 font-weight-bold text-gray-900">2</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-600"></i>
            </div>
          </div>
        </template>
      </div>
    </div>
    <div class="col-xl-6 col-md-12 mb-8">

    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 mb-4">

    </div>
    <div class="col-lg-6 mb-6">

    </div>
  </div>
</div>

</template>

<script>
  import card from '..Card/';
  export default {
    name: 'card',
  }

</script>


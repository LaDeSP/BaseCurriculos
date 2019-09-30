<template>
<div class="modal fade" id="cadas1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" >Cadastre-se</h5>
          <button type="button" class="Close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <NewFisica></NewFisica>
      </div>
      <br>
      <div class="modal-footer">
        <a href="pessoaSemCadastro.html"><button type="submit" id="btnCadastrar" class="btn btn-primary btn-block" data-loading-text="Cadastrando...">Cadastrar</button></a>
      </div>
    </div>
  </div>
</div>
</template>
<script>

  import NewFisica from '../Auth/NewFisica';

  export default {
    data(){
        return {

        }
    },
    components:{
      NewFisica
    }
  }

</script>

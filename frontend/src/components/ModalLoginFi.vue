<template>

<!-- Modal -->
<div>
  <div class="modal fade" id="fisica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel" >Pessoa Física </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
          <div class="modal-header">
              <div class="form-group">
              <h5 class="modal-title" id="exampleModalLabel" >Login</h5>
              <br>
              <div class="row">
                <div class="col-lg-9">
                  <div class="form-group input-group margin-bottom-sm">
                    <span class="input-group-text"><i class="fas fa-envelope fa-fw"></i></span>
                    <input class="form-control" type="text" name = "email" placeholder="Email" required = "autofocus"><!--required autofocus-->
                  </div>
                  <div class="form-group input-group">
                    <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                    <input class="form-control" type="password" name = "senha" placeholder="Senha" required = "autofocus"><!--required autofocus-->
                  </div>
                </div>
                <div class="col-lg-3 text-right" style="padding-left: 35px;">
                    <i class="far fa-user fa-5x login-icon"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-center">
            <div class="modal-footer">
                <div class="d-flex justify-content-center">
                  <a href="pessoaSemCadastro.html"><input class="btn btn-primary btn-lg btn-block" type="submit" value="Entrar" ></a>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <p>Não tem uma conta ainda?</p>
              <input class="btn btn-outline-primary btn-lg  btn-block " type="submit" value=" Crie sua Conta" data-toggle="modal" data-target="#cadas1">

          </div>

        </div>
      </div>
    </div>
  </div>
  <ModalCadasFi></ModalCadasFi>
</div>
<!--  end-Modal -->
</template>

<script>
  import ModalCadasFi from './ModalCadasFi';

  export default {
    data(){
        return {

        }
    },
    components:{
      ModalCadasFi
    }
  }

</script>

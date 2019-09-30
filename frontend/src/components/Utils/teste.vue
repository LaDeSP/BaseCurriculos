<template>


 <div class="row justify-content-center">
    <div class="col-sm-6">
        <br>

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
        <slot name="icone">
          <i class="far fa-user fa-5x login-icon"></i>
        </slot>
    </div>

    <div class="d-flex justify-content-center">
      <div class="modal-footer">
          <div class="d-flex justify-content-center">
            <a href="pessoaSemCadastro.html"><input class="btn btn-primary btn-lg btn-block" type="submit" value="Entrar" ></a>
          </div>
      </div>
    </div>

</div>


</template>

<script>

  export default {
    data(){
        return {

        }
    },
    components:{

    }
  }

</script>

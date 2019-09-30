<template>

<div class="row justify-content-center" >
    <div class="col-lg-8">

            <div class="form-group input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fas fa-envelope fa-fw"></i></span>
                <input placeholder="Email" type="email" id="email" name="email" class="form-control" required = "autofocus" v-model="email">
            </div>

            <div class="form-group input-group">
                <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                <input placeholder="Senha" type="password" id="password" name="password"
                class="form-control" v-model="password" required = "autofocus">
            </div>

    </div>
            <div class="col-lg-3 text-right" style="padding-left: 35px;">
              <slot name="icone">
                <i class="far fa-user fa-5x login-icon"></i>
              </slot>
            </div>
            <div class="text-center modal-footer">
              <button @click.prevent="login" type="submit" class="btn btn-lg btn-primary">Entrar</button>
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

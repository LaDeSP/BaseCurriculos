<template>
<div class="modal " tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" @click="fecharNoVazio(event, this)">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <slot name="header">
          <h5 class="modal-title" id="exampleModalLabel" >Eu sou a header.</h5>
        </slot>
        <button data-dismiss="modal" @click="close" class="close" aria-label="Close" style='color: #ff0000;'>x</button>
        <!-- <button ><span aria-hidden="true">&times;</span></button> -->
      </div>
      <div class="modal-body">
        <slot name="body">
          <p>Sou o body.</p>
        </slot>
      </div>
      <br>

        <slot name="footer">

        </slot>

    </div>
  </div>
</div>
</template>
<script>

  export default {
    name: 'modal',
    methods: {
      close(){
        this.$emit('close');
      },
      fecharNoVazio(e, element) {
                
                  if(e.target.classList=='close'){
                      document.getElementById("modalImag").style.display = "none";
                      return;
                  }
                  else if (e.target.classList != element.classList){
                      return;
                  }
                  document.getElementById("modalImag").style.display = "none";
              }
    }
  }

</script>


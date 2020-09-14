<template>
  <div class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" @click="close">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content" @click.stop>
        <div class="modal-header" style="color: #858796;">
          <slot name="header">
            <h5 class="modal-title" id="exampleModalLabel" ></h5>
          </slot>
          <button data-dismiss="modal" @click="close" class="close" aria-label="Close" style='color: #ff0000;'>x</button>
        </div>
        <div class="modal-body" style="color: #858796;">
          <slot name="body">
            Sou o body.
          </slot>
        </div>
        <div class="modal-footer">
          <slot name="footer">
          </slot>
        </div>
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
      }
    }
  }

</script>


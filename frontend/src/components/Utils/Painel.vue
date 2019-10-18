<template>
      <div class="panel panel-default">
        <slot nmae="panel"></slot>
        <div class="panel-body">
          <slot name="panel-body">
          </slot>
        </div>
        <div class="panel-footer">
          <slot name="panel-footer"></slot>
        </div>
      </div>
</template>
<script>
  export default {
    name: 'painel',
  }
  // https://github.com/luizamazo/estagio-2.0/blob/frontend/src/components/Coordenadores.vue
</script>

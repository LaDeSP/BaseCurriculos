<template>
  <div class="table-responsive-md">
    <slot name="table-responsive"></slot>
      <table class="table text-center">
        <slot name="table"></slot>
        <thead>
          <slot name="thead"></slot>
        </thead>
        <tbody>
          <slot name="tbody"></slot>
        </tbody>
      </table>
  </div>
</template>
<script>
  export default {
    name: 'table',
  }
  // https://github.com/luizamazo/estagio-2.0/blob/frontend/src/components/Coordenadores.vue
</script>

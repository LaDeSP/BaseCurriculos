<template>

<div class="card">
  <div class="card-header">
    <slot name="card-header">
    </slot>
  </div>
  <div class="card-body">
    <slot name="card-body">
    </slot>
  </div>
  <div class="card-footer">
    <slot name="card-footer">
    </slot>
  </div>
</div>

</template>

<script>

  export default {
    name: 'card',
  }

</script>


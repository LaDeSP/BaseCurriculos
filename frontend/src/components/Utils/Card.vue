<template>

<div class="card">
  <div class="card-header">
    <slot name="card-header">
    </slot>
  </div>
  <div class="card-body">
    <slot name="thumbnail">
      <img v-if="url" class="card-img-top img-thumbnail img-fluid" :src=url>
    </slot>
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

    props: {
      url: String
    },
  }

</script>


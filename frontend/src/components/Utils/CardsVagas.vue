<template>
 <div class="col-sm-12">
<div class="card-group">
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
  </div>
</div>
</template>

<script>

  export default {
    name: 'card-vaga',
  }

</script>


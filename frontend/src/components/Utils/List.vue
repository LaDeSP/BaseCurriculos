<template>

    <div class="list-group">
        <div class="list-group-item  flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
            <slot name="list-header">
                <h5 class="mb-1">List group item heading</h5>
                <small>3 days ago</small>
            </slot>
            </div>
            <slot name="list-body">
                <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                <small>Donec id elit non mi porta.</small>
            </slot>
            <hr>
            <slot name="list-footer">
            </slot>
        </div>
    </div>

</template>

<script>

  export default {
    name: 'list',
  }

</script>


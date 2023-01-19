<template>
  <authorization-guards-form
    label="Permission"
    route-alias="permission.store"
    success-message="Permisie adaugata!"
  ></authorization-guards-form>
</template>
<script lang="ts" setup>
  import AuthorizationGuardsForm from '@/ts/components/authorization-guards-form.vue';
</script>

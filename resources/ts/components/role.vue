<template>
  <authorization-guards-form
    label="Role"
    route-alias="role.store"
    success-message="Rol adaugat!"
  ></authorization-guards-form>
</template>
<script lang="ts" setup>
  import AuthorizationGuardsForm from '@/ts/components/authorization-guards-form.vue';
</script>

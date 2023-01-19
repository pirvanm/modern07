<template>
  <kendo-grid :config="gridConfig" @open-dialog="setDialogVisible"></kendo-grid>

  <company-create-edit-component v-bind="company" v-if="dialogVisible" />
</template>
<script setup lang="ts">
  import KendoGrid from '~views/components/kendo-grid.vue';
  import { gridConfig } from '../config/grid.config';
  const CompanyCreateEditComponent = defineAsyncComponent(
    () => import('../components/company-create-edit.vue')
  );

  let company = reactive({});

  const dialogVisible = ref(false);
  provide('dialogVisible', dialogVisible);

  const setDialogVisible = (data: Object) => {
    company = data?.dataItem;
    dialogVisible.value = true;
  };
</script>

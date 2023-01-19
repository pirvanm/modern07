<template>
  <kendo-grid :config="gridConfig" @open-dialog="setDialogVisible"></kendo-grid>
  <proposal-create-edit-component></proposal-create-edit-component>
</template>
<script lang="ts" setup>
  import { gridConfig } from '../config/grid-config';
  import KendoGrid from '~views/components/kendo-grid.vue';
  import { ref, onMounted, defineAsyncComponent } from 'vue';

  const dialogVisible = ref<boolean>(false);

  const setDialogVisible = (data: Object) => {
    dialogVisible.value = true;
  };
</script>

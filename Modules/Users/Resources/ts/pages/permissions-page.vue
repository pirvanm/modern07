<template>
  <kendo-grid
    :config="gridConfig"
    @addGridDialog="gridDialog"
    @editGridDialog="gridDialog"
    @deleteGridDialog="deleteGridDialog"
  ></kendo-grid>
  <form-dialog-component
    :permission="permission"
    v-if="showGridDialog"
    v-model="showGridDialog"
    @closeDialog="showGridDialog = false"
  />
</template>
<script setup lang="ts">
  import KendoGrid from '~views/components/kendo-grid.vue';
  import { gridConfig } from '../config/grid.permissions.config';
  import { useForm } from '@inertiajs/inertia-vue3';
  import FormDialogComponent from '../components/permissions/form-dialog.vue';
  import {onMounted} from "vue";

  // to be able to refresh the grid
  const refreshGrid: any = ref<boolean>(false);
  provide('refreshGrid', refreshGrid);
  const refreshGridFilters = ref<boolean>(false);
  provide('refreshGridFilters', refreshGridFilters);

  // dealing with the dialog
  const showGridDialog: any = ref<boolean>(false);
  let permission: any = ref<any>(null);

  // form actions
  const gridDialog = (item: any) => {
    showGridDialog.value = true;
    permission.value = item;
  };

  const deleteGridDialog = (item: any) => {
    ElMessageBox.confirm(
      `Are you sure you want to delete permision ${item.name}?`,
      'Warning',
      {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'error',
      }
    )
      .then(() => {
        useForm({}).delete(
          route('permissions.destroy', { permission: item.id }),
          {
            onSuccess: () => {
              refreshGrid.value = !refreshGrid.value;
              ElMessage({
                type: 'success',
                message: 'Delete completed',
              });
            },
            onError: (error) => {
              console.log(error);
            },
          }
        );
      })
      .catch(() => {
        ElMessage({
          type: 'info',
          message: 'Delete canceled',
        });
      });
  };

  onMounted(() => {
      refreshGridFilters.value = !refreshGridFilters.value;
  })
</script>

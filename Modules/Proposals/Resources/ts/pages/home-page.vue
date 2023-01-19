<template>
  <kendo-grid
    :config="gridConfig"
    @addGridDialog="gridDialog"
    @editGridDialog="gridDialog"
    @deleteGridDialog="deleteGridDialog"
  ></kendo-grid>
  <form-dialog-component
    v-if="showGridDialog"
    v-model="showGridDialog"
    :proposal="proposal"
    @closeDialog="showGridDialog = false"
  />
</template>
<script lang="ts" setup>
  import { gridConfig } from '../configs/grid-config';
  import { useForm } from '@inertiajs/inertia-vue3';
  import KendoGrid from '~views/components/kendo-grid.vue';
  import FormDialogComponent from '../components/form-dialog.vue';

  // to be able to refresh the grid
  const refreshGrid = ref<boolean>(false);
  provide('refreshGrid', refreshGrid);
  // to control the grid main dialog visibility
  const showGridDialog = ref<boolean>(false);
  // to hold the user data for editing
  const proposal = ref<any>(null);
  // form actions
  const gridDialog = (item: any) => {
    showGridDialog.value = true;
    proposal.value = item;
  };


  const deleteGridDialog = (item: any) => {
      ElMessageBox.confirm(
          `Are you sure you want to delete proposal with ID ${item?.id}?`,
          'Warning',
          {
              confirmButtonText: 'OK',
              cancelButtonText: 'Cancel',
              type: 'error',
          }
      )
          .then(() => {
              useForm({}).delete(route('proposals.destroy', { proposal: item.id }), {
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
              });
          })
          .catch(() => {
              ElMessage({
                  type: 'info',
                  message: 'Delete canceled',
              });
          });
  };

</script>

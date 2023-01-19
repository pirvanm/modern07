<template>
  <kendo-grid
    :config="gridConfig"
    @addGridDialog="gridDialog"
    @editGridDialog="gridDialog"
    @deleteGridDialog="deleteGridDialog"
    @impersonateUser="impersonateUser"
  ></kendo-grid>
  <form-dialog-component
    v-if="showGridDialog"
    v-model="showGridDialog"
    :user="user"
    @closeDialog="showGridDialog = false"
  />
</template>
<script setup lang="ts">
  import KendoGrid from '~views/components/kendo-grid.vue';
  import { gridConfig } from '../config/grid.users.config';
  import { useForm } from '@inertiajs/inertia-vue3';
  import { Inertia } from '@inertiajs/inertia';
  import FormDialogComponent from '../components/users/form-dialog.vue';
  import { onMounted } from 'vue';
  // to be able to refresh the grid
  const refreshGrid = ref<boolean>(false);
  const refreshGridFilters = ref<boolean>(false);
  provide('refreshGrid', refreshGrid);
  provide('refreshGridFilters', refreshGridFilters);

  // to control the grid main dialog visibility
  const showGridDialog = ref<boolean>(false);
  // to hold the user id for editing
  const user = ref<any>(null);
  // form actions
  const gridDialog = (item: any) => {
    showGridDialog.value = true;
    user.value = item;
  };
  const deleteGridDialog = (item: any) => {
    ElMessageBox.confirm(
      `Are you sure you want to delete user ${item.name}?`,
      'Warning',
      {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'error',
      }
    )
      .then(() => {
        useForm({}).delete(route('proposals.destroy', { proposals: item.id }), {
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
  const impersonateUser = (item: any) => {
    ElMessageBox.confirm(
      `Are you sure you want to authenticate on user ${item.name}?`,
      'Warning',
      {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }
    )
      .then(() => {
        Inertia.patch(route('users.impersoante', { user: item.id }));
      })
      .catch((error) => {
        ElMessage({
          type: 'info',
          message: 'Action canceled',
        });
      });
  };

  onMounted(() => {
    refreshGridFilters.value = !refreshGridFilters.value;
  });
</script>

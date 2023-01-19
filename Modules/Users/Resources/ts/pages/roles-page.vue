<template>
  <kendo-grid
    :config="gridConfig"
    @addGridDialog="gridDialog"
    @editGridDialog="gridDialog"
    @deleteGridDialog="deleteGridDialog"
    @permissionsGridDialog="permissionsGridDialog"
    @cloneRoleGridDialog="cloneRoleGridDialog"
  ></kendo-grid>
  <form-dialog-component
    :role="role"
    :clone-role="cloneRole"
    v-if="showGridDialog"
    v-model="showGridDialog"
    @closeDialog="showGridDialog = false"
  />
  <permissions-dialog-component
    :role="role"
    v-if="showPermissionsDialog"
    v-model="showPermissionsDialog"
    @closeDialog="showPermissionsDialog = false"
  />
</template>
<script setup lang="ts">
  import KendoGrid from '~views/components/kendo-grid.vue';
  import { gridConfig } from '../config/grid.roles.config';
  import FormDialogComponent from '../components/roles/form-dialog.vue';
  import PermissionsDialogComponent from '../components/roles/permissions-dialog.vue';
  import {onMounted} from "vue";

  // to be able to refresh the grid
  const refreshGrid = ref<boolean>(false);
  provide('refreshGrid', refreshGrid);
  const refreshGridFilters = ref<boolean>(false);
  provide('refreshGridFilters', refreshGridFilters);

  // dealing with the dialog
  const showGridDialog = ref<boolean>(false);
  const showPermissionsDialog = ref<boolean>(false);
  let role = ref<any>(null);

  let cloneRole = ref<boolean>(false);

  // form actions
  const permissionsGridDialog = (item: any) => {
    showPermissionsDialog.value = true;
    role.value = item;
  };

  const gridDialog = (item: any) => {
    showGridDialog.value = true;
    role.value = item;
    cloneRole.value = false;
  };

  const cloneRoleGridDialog = (item:any) => {
      showGridDialog.value= true;
      role.value = item;
      cloneRole.value = true;
  };

  const deleteGridDialog = (item: any) => {
    ElMessageBox.confirm(
      `Are you sure you want to delete role ${item?.name}?`,
      'Warning',
      {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'error',
      }
    )
      .then(() => {
        useForm({}).delete(route('roles.destroy', { role: item.id }), {
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

  onMounted(() => {
      refreshGridFilters.value = !refreshGridFilters.value;
  })
</script>

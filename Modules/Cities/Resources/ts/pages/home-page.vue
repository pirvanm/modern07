<template>
  <kendo-grid :config="gridConfig" @open-dialog="setDialogVisible"></kendo-grid>

  <el-dialog v-model="dialogVisible" title="Create City" width="30%">
    <el-form :model="form" label-width="100px">
      <el-form-item label="Name">
        <el-input v-model="form.name" />
      </el-form-item>
      <el-form-item label="Parent">
        <el-select v-model="form.name" placeholder="Please select a user type">
          <el-option label="Employee" value="Employee" />
          <el-option label="Partner" value="Partner" />
        </el-select>
      </el-form-item>
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="dialogVisible = false">
          Confirm
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>
<script setup lang="ts">
  import KendoGrid from '~views/components/kendo-grid.vue';
  import { IKendoConfig } from '~shared/interfaces';

  const gridConfig: IKendoConfig = {
    dataSource: 'cities',
    route: 'cities.data',
    columns: [
      {
        field: 'id',
        title: 'Id',
        filter: 'numeric',
        sortable: true,
        filterable: true,
      },
      {
        field: 'name',
        title: 'Name',
        filter: 'text',
        sortable: true,
        filterable: true,
      },
      {
        field: 'parent.name',
        title: 'Apartine De',
        filter: 'text',
        sortable: true,
        filterable: true,
      },
      {
        field: 'county.name',
        title: 'County',
        filter: 'text',
        sortable: true,
        filterable: true,
      },
    ],
  };

  const form = ref({
    name: '',
  });

  const dialogVisible = ref(false);

  const setDialogVisible = () => {
    dialogVisible.value = true;
  };
</script>

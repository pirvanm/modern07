<template>
  <td>
    <el-button size="small" type="success" @click="goToShowPage(dataItem)">
      <i-ep-view />
    </el-button>
    <el-button size="small" type="primary" @click="editGridDialog(dataItem)">
      <i-ep-edit />
    </el-button>
    <el-button size="small" type="danger" @click="deleteGridDialog(dataItem)">
      <i-ep-delete />
    </el-button>
  </td>
</template>

<script lang="ts" setup>
  import { Inertia } from '@inertiajs/inertia';

  interface columnProps {
    field: string;
    dataItem: Object;
    format: string;
    className: string;
    columnIndex: number;
    columnsCount: number;
    rowType: string;
    level: number;
    expanded: boolean;
    editor: string;
  }
  const props = defineProps<columnProps>();

  const emit = defineEmits(['editGridDialog', 'deleteGridDialog']);

  const editGridDialog = (item: Object) => emit('editGridDialog', item);
  const deleteGridDialog = (item: Object) => emit('deleteGridDialog', item);
  const goToShowPage = (item) => {
    Inertia.visit(route('proposals.show', { proposal: item.id }));
  };
</script>

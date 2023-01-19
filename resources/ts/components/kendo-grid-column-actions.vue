<template>
  <td>
    <el-button type="primary" @click="editGridDialog(dataItem)">
      <i-ep-edit />
    </el-button>
    <el-button type="danger" @click="deleteGridDialog(dataItem)"
      ><i-ep-delete
    /></el-button>
  </td>
</template>

<script lang="ts" setup>
  interface columnProps {
    field: String;
    dataItem: Object;
    format: String;
    className: String;
    columnIndex: Number;
    columnsCount: Number;
    rowType: String;
    level: Number;
    expanded: Boolean;
    editor: String;
  }
  const props = defineProps<columnProps>();

  const emit = defineEmits(['editGridDialog', 'deleteGridDialog']);

  const editGridDialog = (item: Object) => emit('editGridDialog', item);
  const deleteGridDialog = (item: Object) => emit('deleteGridDialog', item);
</script>

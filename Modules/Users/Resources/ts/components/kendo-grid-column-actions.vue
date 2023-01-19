<template>
    <td style="display: flex">
        <el-button size="small" type="primary" @click="editGridDialog(dataItem)">
            <i-ep-edit />
        </el-button>
        <el-button size="small" type="danger" @click="deleteGridDialog(dataItem)"
        ><i-ep-delete
        /></el-button>
        <el-button
            size="small"
            type="warning"
            @click="permissionsGridDialog(dataItem)"
        ><i-ep-lock />
        </el-button>
        <el-button
            size="small"
            type="primary"
            @click="cloneRoleGridDialog(dataItem)"
        >
            <i-ep-switch />
        </el-button>
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
const emit = defineEmits([
    'editGridDialog',
    'deleteGridDialog',
    'permissionsGridDialog',
    'cloneRoleGridDialog',
]);
const editGridDialog = (item: Object) => emit('editGridDialog', item);
const deleteGridDialog = (item: Object) => emit('deleteGridDialog', item);
const permissionsGridDialog = (item: Object) =>
    emit('permissionsGridDialog', item);
const cloneRoleGridDialog = (item: Object) =>
    emit('cloneRoleGridDialog', item);
</script>

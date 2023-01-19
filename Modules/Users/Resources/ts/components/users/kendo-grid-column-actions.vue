<template>
    <td style="display: flex">
        <el-button size="small" type="primary" @click="editGridDialog(dataItem)">
            <i-ep-edit />
        </el-button>
        <el-button size="small" type="danger" @click="deleteGridDialog(dataItem)"
        ><i-ep-delete
        /></el-button>
        <el-button
            v-if="user.id != dataItem.id"
            size="small"
            type="primary"
            @click="impersonateUser(dataItem)"
        >
            <i-ep-user />
        </el-button>
    </td>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/inertia-vue3';

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
const user = usePage().props.value.auth.user;

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
const impersonateUser = (item: Object) => emit('impersonateUser', item);
</script>

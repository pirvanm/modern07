<template>
  <el-dialog
    :title="permission ? 'Edit Permission' : 'Add Permission'"
    width="30%"
  >
    <el-form v-model="form" v-loading="permissionLoading" label-width="100px">
      <el-form-item
        label="Name"
        :error="form.errors.name"
        :show-message="form.errors.name"
      >
        <el-input v-model="form.name" />
      </el-form-item>
      <el-form-item
        label="Guard"
        :error="form.errors.guard_name"
        :show-message="form.errors.guard_name"
      >
        <el-select
          v-model="form.guard_name"
          class="m-2"
          placeholder="Select guard"
          :class="'full-width'"
        >
          <el-option
            v-for="guard in guards"
            :key="guard"
            :label="guard"
            :value="guard"
          />
        </el-select>
      </el-form-item>
      <el-form-item
        label="Display Name"
        :error="form.errors.display_name"
        :show-message="form.errors.display_name"
      >
        <el-input v-model="form.display_name" />
      </el-form-item>
      <el-form-item
        label="Description"
        :error="form.errors.description"
        :show-message="form.errors.description"
      >
        <el-input v-model="form.description" />
      </el-form-item>
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="closeDialog">Cancel</el-button>
        <el-button type="primary" @click="submit()"> Confirm </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script lang="ts" setup>
  import { useForm, InertiaForm } from '@inertiajs/inertia-vue3';
  import { IPermission } from '~shared/interfaces/permission';
  import { GuardTypes } from '~shared/enums/';

  // props and emits
  const props: any = defineProps(['permission', 'dialogVisible']);
  const emit: any = defineEmits(['closeDialog']);

  // guards
  const guards: string[] = Object.values(GuardTypes);

  // so we can refresh the grid
  const refreshGrid: any = inject('refreshGrid');

  // the schema for our role object
  let permissionObject = {
    id: null,
    name: null,
    display_name: null,
    guard_name: GuardTypes.WEB,
    description: null,
  };

  if (props.permission) {
    permissionObject = props.permission;
  }

  // to keep track of the data
  let permissionLoading = ref<boolean>(false);
  let form: InertiaForm<IPermission> = useForm(permissionObject);

  let submit = () => {
    let url = form.id
      ? route('permissions.update', { permission: form.id })
      : route('permissions.store');
    let method = form.id ? 'patch' : 'post';

    form[method](url, {
      onSuccess: () => {
        refreshGrid.value = !refreshGrid.value;
        closeDialog();
        ElMessage({
          message: 'Operation completed successfully!',
          type: 'success',
        });
      },
    });
  };
  let closeDialog = () => {
    emit('closeDialog');
  };
</script>

<style lang="css">
  .full-width {
    display: block;
    width: 100%;
  }
</style>

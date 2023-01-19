<template>
  <el-dialog :title="title" width="30%">
    <el-form v-model="form" v-loading="roleLoading" label-width="100px">
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
  import { IRole } from '~shared/interfaces/role';
  import { GuardTypes } from '~shared/enums/';

  // props and emits
  const props: any = defineProps(['role', 'dialogVisible', 'cloneRole']);
  const emit: any = defineEmits(['closeDialog']);

  //dialog title
  const title = ref<string>('Create Role');

  // guards
  const guards: string[] = Object.values(GuardTypes);

  // so we can refresh the grid
  const refreshGrid: any = inject('refreshGrid');

  // the schema for our role object
  let roleObject = {
    id: null,
    name: null,
    guard_name: GuardTypes.WEB,
    display_name: null,
    description: null,
  };

  // if we are editing
  if (props.role) {
    roleObject = props.role;
  }

  // to keep track of the data
  const roleLoading = ref<boolean>(false);
  const form: InertiaForm<IRole> = useForm(roleObject);

  const submit = () => {
    let url = form.id
      ? route('roles.update', { role: form.id })
      : route('roles.store');
    let method = form.id ? 'patch' : 'post';

    if (props.cloneRole) {
      method = 'post';
      url = route('roles.clone', { role: form.id });
    }

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
  const closeDialog = () => {
    emit('closeDialog');
  };

  const setTitle = () => {
    if (props.role) {
      if (props.cloneRole) {
        title.value = `Duplicate Role ${props.role.display_name}`;
      } else {
        title.value = `Edit Role ${props.role.display_name}`;
      }
    }
  };

  onMounted(() => {
    setTitle();
  });
</script>

<style lang="css">
  .full-width {
    display: block;
    width: 100%;
  }
</style>

<template>
  <el-dialog :title="user ? __('Edit User') : __('Add User')" width="30%">
    <el-form v-model="form" v-loading="rolesLoading" label-width="100px">
      <el-form-item
        :label="__('Username')"
        :error="form.errors.name"
        :show-message="form.errors.name"
      >
        <el-input v-model="form.name" />
      </el-form-item>
      <el-form-item
        label="Password"
        :error="form.errors.password"
        :show-message="form.errors.password"
      >
        <el-input v-model="form.password" />
      </el-form-item>
      <el-form-item
        label="Email"
        :error="form.errors.email"
        :show-message="form.errors.email"
      >
        <el-input v-model="form.email" />
      </el-form-item>
      <el-form-item
        label="Role"
        :error="form.errors.role_id"
        :show-message="form.errors.role_id"
      >
        <el-select
          v-model="form.role_id"
          placeholder="Please select a role"
          :loading="rolesLoading"
          :class="`full-width`"
        >
          <el-option
            v-for="role in roles"
            :key="role.id"
            :label="role.name"
            :value="role.id"
          ></el-option>
        </el-select>
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
  import { IUser } from '~shared/interfaces/user';
  import { IRole } from '~shared/interfaces/role';
  import axios from 'axios';

  // props and emits
  const props: any = defineProps(['user']);
  const emit: any = defineEmits(['closeDialog']);

  // so we can refresh the grid
  const refreshGrid: any = inject('refreshGrid');

  // for displaying loading animation until data is raedy
  const rolesLoading: any = ref<boolean>(false);

  // the schema for our user object
  let userObject: IUser = {
    id: null,
    name: null,
    email: null,
    password: null,
    role_id: null,
  };

  // if we are editing an user
  if (props.user) {
    userObject = props.user;
    userObject.password = null;
    userObject.role_id = props.user?.roles?.id;
  }

  // to keep track of the data
  const form: InertiaForm<IUser> = useForm(userObject);
  let roles: any = reactive<IRole[]>([]);

  const submit = () => {
    const url = form.id
      ? route('users.update', { user: form.id })
      : route('users.store');
    const method = form.id ? 'patch' : 'post';

    // we do not want to send the whole role thing
    delete form.role;

    form[method](url, {
      onSuccess: () => {
        closeDialog();
        refreshGrid.value = !refreshGrid.value;
        ElMessage({
          message: 'Operation completed successfully!',
          type: 'success',
        });

        // if role changed reload page
        console.log(props.user);
        if (form.role_id !== props.user.roles.id) {
          location.reload();
        }
      },
    });
  };
  const closeDialog = () => {
    emit('closeDialog');
  };
  // API related ( get all roles except the one that is currently attached to our user )
  const fetchUnattachedRoles = async () => {
    const userId = props.user ? props.user.id : '';
    rolesLoading.value = true;
    await axios
      .get(`/api/roles/except/user/${userId}`)
      .then((response: any) => {
        roles = response.data;
        rolesLoading.value = false;
      })
      .catch((error: any) => {
        console.log(error);
      });
  };

  onMounted(() => {
    fetchUnattachedRoles();
  });
</script>

<style lang="css">
  .full-width {
    display: block;
    width: 100%;
  }
</style>

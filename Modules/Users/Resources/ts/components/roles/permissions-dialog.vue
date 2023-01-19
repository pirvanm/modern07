<template>
  <el-dialog :title="`Add Permissions to Role ${role.name}`" width="30%">
    <el-form v-loading="permissionsLoading" label-width="100px">
      <dual-list-box
        v-if="!permissionsLoading"
        :orgSource="dualListBoxData.source"
        :orgDestination="dualListBoxData.destination"
        @onListChange="onListChange"
      />
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
  import { IPermission } from '~shared/enums/permission.interface';
  import axios from 'axios';

  import DualListBox from '~views/components/dual-list-box.vue';

  // props and emits
  const props: any = defineProps(['role', 'dialogVisible']);
  const emit: any = defineEmits(['closeDialog']);

  // so we can refresh the grid
  const refreshGrid: any = inject('refreshGrid');

  // to keep track of permissions loading state
  const permissionsLoading = ref<boolean>(false);

  // to keep track of the form and permissions data
  const form: InertiaForm<{ permissions: number[] }> = useForm({
    permissions: [] as number[],
  });

  // the data that we pass as props to dual-list-box
  let dualListBoxData = reactive({
    source: [],
    destination: [],
  });

  let submit = () => {
    let url = route('roles.permissions.update', { role: props.role.id });
    let method = 'patch';

    // send data
    form[method](url, {
      onSuccess: () => {
        closeDialog();
        refreshGrid.value = !refreshGrid.value;
        ElMessage({
          message: 'Operation completed successfully!',
          type: 'success',
        });
          location.reload();
      },
    });
  };
  // API related
  async function fetchUnattachedPermissions() {
    permissionsLoading.value = true;
    await axios
      .get(`/api/permissions/except/role/${props.role?.id}`)
      .then((response: any) => {
        let permissions = response.data;
        dualListBoxData.source = groupPermissionsByNamePrefix(permissions);
        permissionsLoading.value = false;
      })
      .catch((error: any) => {
        console.log(error);
      });
  }

  // helper function to group permissions
  function groupPermissionsByNamePrefix(permissions: IPermission[]) {
    const groupedPerm: any = [];
    if (permissions.length) {
      permissions.forEach((permission) => {
        let bits = permission.name.split('_');

        let item = groupedPerm.find((i: {label: string}) => i.label == bits[0]);

        if (item) {
          item.items.push({ id: permission.id, name: permission.name });
        } else {
          groupedPerm.push({
            label: bits[0],
            items: [{ id: permission.id, name: permission.name }],
          });
        }
      });
    }

    return groupedPerm;
  }

  // event emitted by dual-list-box
  function onListChange(source: [], destination: []) {
    destination.forEach((group: { label: string; items: IPermission[] }) => {
      group.items.forEach((item: IPermission) => {
        form.permissions.push(parseInt(item.id));
      });
    });
  }

  let closeDialog = () => {
    emit('closeDialog');
  };

  onMounted(() => {
    fetchUnattachedPermissions();

    // we assign the grouped permissions of the viewed role
    dualListBoxData.destination = groupPermissionsByNamePrefix(
      props.role.permissions
    );
  });
</script>

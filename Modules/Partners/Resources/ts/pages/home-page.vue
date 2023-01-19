<template>
  <kendo-grid :config="gridConfig" @open-dialog="setDialogVisible"></kendo-grid>

  <el-dialog v-model="dialogVisible" title="Add Partner" width="30%">
    <el-form :model="form" label-width="100px">
      <el-form-item
        label="First Name"
        :show-message="form.errors.fname"
        :error="form.errors.fname"
      >
        <el-input v-model="form.fname" />
      </el-form-item>
      <el-form-item
        label="Last Name"
        :show-message="form.errors.lname"
        :error="form.errors.lname"
      >
        <el-input v-model="form.lname" />
      </el-form-item>
      <el-form-item
        label="Company"
        :show-message="form.errors.company_id"
        :error="form.errors.company_id"
      >
        <el-select
          v-model="form.company_id"
          filterable
          remote
          reserve-keyword
          remote-show-suffix
          :remote-method="remoteMethod"
          :loading="loading"
          placeholder="Please select a company"
        >
          <el-option
            v-for="item in options"
            :key="item.value"
            :value="item.value"
            :label="item.label"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item
        label="Phone"
        :show-message="form.errors.phone"
        :error="form.errors.phone"
      >
        <el-input v-model="form.phone" />
      </el-form-item>
      <el-form-item
        label="Email"
        :show-message="form.errors.email"
        :error="form.errors.email"
      >
        <el-input v-model="form.email" />
      </el-form-item>
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="submitForm"> Confirm </el-button>
      </span>
    </template>
  </el-dialog>
</template>
<script setup lang="ts">
  import { InertiaForm, useForm } from '@inertiajs/inertia-vue3';
  import KendoGrid from '~views/components/kendo-grid.vue';
  import { gridConfig } from '../config/grid.config';
  import axios from 'axios';

  interface formInterface {
    fname: string | null;
    lname: string | null;
    company_id: number | null;
    phone: string | null;
    email: string | null;
  }

  const props = withDefaults(defineProps<formInterface>(), {
    fname: null,
    lname: null,
    company_id: null,
    phone: null,
    email: null,
  });

  const form: InertiaForm<formInterface> = useForm(props);

  interface ListItem {
    value: string;
    label: string;
  }

  const options = ref<ListItem[]>([]);
  const value = ref<string[]>([]);
  const loading = ref(false);

  const remoteMethod = (query: string) => {
    options.value = [];

    if (query) {
      loading.value = true;
      axios
        .get(route('companies.search'), {
          params: {
            q: query,
          },
        })
        .then((response) => {
          response.data.forEach((item) => {
            options.value.push({
              label: item.name,
              value: item.id,
            });
          });
          loading.value = false;
        })
        .catch((error) => {
          console.log(error);
        });
    } else {
      options.value = [];
    }
  };

  function submitForm() {
    let url = route('partners.store');
    form.post(url, {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
        dialogVisible.value = false;

        ElMessage({
          message: 'Operation completed successfully!',
          type: 'success',
        });
      },
      onError: () => {},
    });
  }

  const dialogVisible = ref(false);

  const setDialogVisible = () => {
    form.clearErrors();
    dialogVisible.value = true;
  };
</script>

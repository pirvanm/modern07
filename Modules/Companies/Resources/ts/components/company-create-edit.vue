<template>
  <el-dialog
    v-model="dialogVisible"
    :title="method == 'post' ? 'Add Company' : 'Edit Company'"
    label-position="right"
    style="width: 35%"
    label-width="70px"
    status-icon
  >
    <el-form :model="form" label-width="100px">
      <el-form-item
        label="Name"
        :show-message="form.errors.name"
        :error="form.errors.name"
      >
        <el-input v-model="form.name" />
      </el-form-item>
      <el-form-item
        label="CUI"
        :show-message="form.errors.cui"
        :error="form.errors.cui"
      >
        <el-input v-model="form.cui" />
      </el-form-item>
      <el-form-item
        label="Reg"
        :show-message="form.errors.reg"
        :error="form.errors.reg"
      >
        <el-input v-model="form.reg" />
      </el-form-item>
      <settlement-component
        :cityFormError="form.errors.city_id"
        :city="city"
        :county="city?.county"
        @cityChanged="cityChanged"
      ></settlement-component>
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
      <el-form-item
        label="Type"
        :show-message="form.errors.type"
        :error="form.errors.type"
      >
        <el-select
          v-model="form.type"
          class="m-2"
          placeholder="Select a type"
          style="
             {
              display: 'block';
              width: 100%;
            }
          "
        >
          <el-option
            v-for="companyType in companyTypes"
            :key="companyType"
            :label="companyType"
            :value="companyType"
          />
        </el-select>
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

<script lang="ts" setup>
  import { InertiaForm, useForm } from '@inertiajs/inertia-vue3';

  import { ICity } from '~shared/interfaces/settlements/city.interface';
  import SettlementComponent from '~shared/components/settlement.vue';

  import { CompanyTypes, CompanyStatuses } from '~shared/enums/';

  // enumes values
  let companyStatuses = Object.values(CompanyStatuses);
  let companyTypes = Object.values(CompanyTypes);

  interface formInterface {
    city: ICity | null;
    city_id: number | null;
    name: string | null;
    hris_code: string | null;
    cui: string | null;
    reg: string | null;
    phone: string | null;
    email: string | null;
    type: CompanyTypes | null;
  }

  const props = withDefaults(defineProps<formInterface>(), {
    city: null,
    city_id: null,
    name: null,
    hris_code: null,
    cui: null,
    reg: null,
    phone: null,
    email: null,
    type: null,
  });

  // form method
  let method = ref<string>('post');
  if (props.name) {
    method.value = 'patch';
  }

  const cityChanged = (city: ICity | null) => {
    Object.assign(form, { city: city });
    Object.assign(form, { city_id: city.id });
  };

  const dialogVisible = inject('dialogVisible');

  watch(dialogVisible, (newValue, oldValue) => {
    form.clearErrors();
  });

  let form: InertiaForm<formInterface> = useForm(props);

  function submitForm() {
    form[method.value]('/companies', {
      preserveScroll: true,
      onSuccess: () => {
        form.clearErrors();
        ElMessage({
          message: 'Operation completed successfully!',
          type: 'success',
        });
      },
      onError: (errors: any) => console.log(errors),
    });
  }
</script>

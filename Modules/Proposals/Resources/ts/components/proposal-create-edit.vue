<template>
  <el-dialog
    v-model="dialogVisible"
    :title="method == 'post' ? __('Add Proposal') : __('Edit Proposal')"
    label-position="right"
    style="width: 35%"
    label-width="70px"
    status-icon
  >
    <el-form :model="form" label-width="100px">
      <settlement-component
        :city-form-error="form.errors.city_id"
        :city="city"
        :county="city?.county"
        @cityChanged="cityChanged"
      ></settlement-component>
      <el-form-item
        :label="__('Type')"
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
            v-for="shopType in shopTypes"
            :key="shopType"
            :label="shopType"
            :value="shopType"
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

  // enumes values
  import { ShopTypes } from '~shared/enums/';
  const shopTypes = Object.values(ShopTypes);

  const dialogVisible = inject('dialogVisible');
  watch(dialogVisible, (newValue, oldValue) => {
    form.clearErrors();
  });

  interface formInterface {
    city: ICity | null;
    city_id: number | null;
    type: ShopTypes | null;
  }

  const props = withDefaults(defineProps<formInterface>(), {
    city: null,
    city_id: null,
    type: null,
  });

  // form method
  const method = ref<string>('post');
  if (props.name) {
    method.value = 'patch';
  }

  const cityChanged = (city: ICity | null) => {
    Object.assign(form, { city: city });
    Object.assign(form, { city_id: city.id });
  };

  const form: InertiaForm<formInterface> = useForm(props);

  function submitForm() {
    form[method.value](route('proposals.store'), {
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

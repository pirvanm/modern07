<template>
  <el-form
    v-loading="loading"
    :model="form"
    :rules="validationRules"
    label-position="right"
    style="width: 95%"
    label-width="70px"
    status-icon
  >
    <el-form-item label="Locatie" style="width: 100%" prop="city">
      <settlement-component
        v-bind="form"
        @city-changed="cityChanged"
        @county-changed="countyChanged"
      ></settlement-component>
    </el-form-item>
    <el-form-item label="Adresa" required>
      <el-row :gutter="2">
        <el-col :span="5">
          <el-tooltip content="Tip adresa" placement="top-start" effect="dark">
            <el-form-item prop="streetType">
              <el-select
                v-model="form.streetType"
                value-key="id"
                clearable
                filterable
              >
                <el-option
                  v-for="type in streetTypes"
                  :key="type.id"
                  :label="type.name"
                  :value="type"
                ></el-option>
              </el-select>
            </el-form-item>
          </el-tooltip>
        </el-col>
        <el-col :span="15">
          <el-tooltip content="Nume adresa" placement="top-start" effect="dark">
            <el-form-item prop="streetName">
              <el-input
                v-model="form.streetName"
                placeholder="Nume"
                class="input-with-select"
              >
              </el-input>
            </el-form-item>
          </el-tooltip>
        </el-col>
        <el-col :span="4">
          <el-tooltip
            content="Numar adresa"
            placement="top-start"
            effect="dark"
          >
            <el-form-item prop="streetNumber">
              <el-input
                v-model="form.streetNumber"
                placeholder="Numar"
              ></el-input>
            </el-form-item>
          </el-tooltip>
        </el-col>
      </el-row>
    </el-form-item>
    <el-form-item label="Cladire">
      <el-row :gutter="2">
        <el-col :span="8">
          <el-tooltip
            content="Numar cladire"
            placement="top-start"
            effect="dark"
          >
            <el-form-item prop="buildingNumber" label-width="auto">
              <el-input
                v-model="form.buildingNumber"
                placeholder="Numar"
              ></el-input>
            </el-form-item>
          </el-tooltip>
        </el-col>
        <el-col :span="8">
          <el-tooltip content="Etaj" placement="top-start" effect="dark">
            <el-form-item prop="level">
              <el-input v-model="form.level" placeholder="Etaj"></el-input>
            </el-form-item>
          </el-tooltip>
        </el-col>
        <el-col :span="8">
          <el-tooltip
            content="Numar apartament"
            placement="top-start"
            effect="dark"
          >
            <el-form-item prop="apartmentNumber">
              <el-input
                v-model="form.apartmentNumber"
                placeholder="Apartament"
              ></el-input>
            </el-form-item>
          </el-tooltip>
        </el-col>
      </el-row>
    </el-form-item>
  </el-form>
</template>
<script setup lang="ts">
  import SettlementComponent from '~shared/components/settlement.vue';
  import { onMounted, reactive, Ref, ref, watch } from 'vue';
  import { ICity } from '~shared/interfaces/settlements/city.interface';
  import { ICounty } from '~shared/interfaces/settlements/county.interface';
  import settlementsService from '~shared/services/settlements.service';
  import { FormRules } from 'element-plus';

  interface formInterface {
    county: ICounty | null;
    city: ICity | null;
    streetName: string | null;
    streetType: { id: number; name: string } | null;
    streetNumber: string | null;
    buildingNumber: string | null;
    level: number | null;
    apartmentNumber: number | null;
  }

  const props = withDefaults(defineProps<formInterface>(), {
    county: null,
    city: null,
    streetName: null,
    streetType: null,
    streetNumber: null,
    buildingNumber: null,
    level: null,
    apartmentNumber: null,
  });

  const streetTypes: Ref<{ id: number; name: string }[]> = ref([]);

  const cityChanged = (city: ICity | null) => {
    Object.assign(form, { city });
  };
  const countyChanged = (county: ICounty | null) => {
    Object.assign(form, { county });
  };

  const form: Ref<formInterface> = ref(props);
  const loading: Ref<boolean> = ref(false);

  watch(form, (formValue: formInterface | object) => {
    if (Object.values(formValue).every((val) => !!val) && loading.value) {
      setTimeout(() => {
        loading.value = false;
      }, 1500);
    }
  });

  watch(props, (value) => {
    form.value = value;
  });

  (function _initStreetTypes() {
    settlementsService
      .getStreetTypes()
      .then((types) => (streetTypes.value = types));
  })();

  const requiredMessage = (label: string): string => `Introduceti ${label}!`;

  const validationRules = reactive<FormRules>({
    city: {
      type: 'object',
      required: true,
      message: 'Selectati orasul si judetul!',
      trigger: 'change',
    },

    streetName: {
      type: 'string',
      required: true,
      asyncValidator: (rule: any, value: any) => {
        return new Promise((resolve, reject) => {
          const forbiddenWords = streetTypes.value;
          if (
            !value ||
            forbiddenWords.some((forbidden: { id: number; name: string }) =>
              value.toLowerCase().includes(forbidden.name.toLowerCase())
            )
          ) {
            reject('Adresa gresita!');
          }
          resolve();
        });
      },
      trigger: 'change',
    },

    streetType: {
      type: 'object',
      required: true,
      message: requiredMessage('tipul adresei'),
      trigger: 'change',
    },

    streetNumber: {
      type: 'string',
      required: true,
      message: requiredMessage('numarul strazii'),
      trigger: 'blur',
    },
  });

  onMounted(() => {
    form.value = { ...props };
    const isUpdateState = Object.values(form).some((formValue) => !!formValue);
    if (isUpdateState) {
      loading.value = true;
    }
  });
</script>

<style>
  .el-row {
    margin-bottom: 10px;
  }
</style>

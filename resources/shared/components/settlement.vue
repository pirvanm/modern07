<template>
  <el-row :gutter="0">
    <el-col :span="24">
      <el-form-item :label="__('County')">
        <el-select
          v-model="selectedCounty"
          value-key="id"
          filterable
          clearable
          :loading="countyLoading"
          :placeholder="__('SelectaCounty')"
          style="
             {
              display: 'block';
              width: 100%;
            }
          "
        >
          <el-option
            v-for="(item, index) in counties"
            :key="index"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
    </el-col>

    <el-col  :span="24">
      <el-form-item
        :label="__('City')"
        :show-message="form.errors.city_id"
        :error="form.errors.city_id"
      >
        <el-select
          v-model="selectedCity"
          value-key="id"
          filterable
          clearable
          :loading="cityLoading"
          :placeholder="__('Select a location')"
          loading-text="Locations loading"
          style="
             {
              display: 'block';
              width: 100%;
            }
          "
        >
          <el-option
            v-for="(item, index) in cities"
            :key="index"
            :label="item.name"
            :value="item"
          />
        </el-select>
      </el-form-item>
    </el-col>
  </el-row>
</template>

<script setup lang="ts">
  import { ICounty } from '~shared/interfaces/settlements/county.interface';
  import { ICity } from '~shared/interfaces/settlements/city.interface';
  import { onMounted, Ref, ref, watch } from 'vue';
  import settlementsService from '~shared/services/settlements.service';

  const props = defineProps(['form']);

  const counties: Ref<ICounty[]> = ref([]);
  const cities: Ref<ICity[]> = ref([]);

  const countyLoading: Ref<boolean> = ref(false);
  const cityLoading: Ref<boolean> = ref(false);
  const initState: Ref<boolean> = ref(false);

  const selectedCounty: Ref<ICounty | null> = ref(props.form?.city?.county);
  const selectedCity: Ref<ICity | null> = ref(props.form.city);

  const emit = defineEmits(['countyChanged', 'cityChanged']);

  watch(selectedCounty, (selectedCounty: ICounty | null) => {
    emit('countyChanged', selectedCounty);
    if (selectedCounty) {
      _getCities();
    } else {
      _resetCities();
    }
    initState.value = false;
  });

  watch(selectedCity, (city: ICity | null) => {
    emit('cityChanged', city);
    initState.value = false;
  });

  (function _initCounties() {
    countyLoading.value = true;
    settlementsService.getCounties().then((resCounties: ICounty[]) => {
      counties.value = resCounties;
      countyLoading.value = false;
    });
  })();

  const _getCities = () => {
    if (selectedCounty?.value?.id) {
      cityLoading.value = true;
      settlementsService
        .getCitiesByCountyId(selectedCounty?.value?.id)
        .then((resCities) => {
          cities.value = resCities;
          cityLoading.value = false;
        });
    }
  };

  const _resetCities = () => {
    cities.value = [];
    selectedCity.value = null;
  };

  onMounted(() => {
    if (selectedCounty.value && selectedCity.value) {
      _getCities();
    }
  });
</script>

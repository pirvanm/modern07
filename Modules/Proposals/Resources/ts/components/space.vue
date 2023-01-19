<template>
  <el-row :gutter="10">
    <el-col :span="8">
      <el-form-item
        :label="__('Type')"
        :show-message="form.errors['space.agency_type']"
        :error="form.errors['space.agency_type']"
      >
        <el-select
          v-model="space.agency_type"
          class="m-2"
          placeholder="Select agency type"
          :class="`full-width`"
        >
          <el-option
            v-for="shopType in shopTypes"
            :key="shopType"
            :label="shopType"
            :value="shopType"
          />
        </el-select>
      </el-form-item>
    </el-col>
    <el-col :span="8">
      <el-form-item
        :label="__('Space Type')"
        :error="form.errors['space.space_type']"
        :show-message="form.errors['space.space_type']"
      >
        <el-input v-model="space.space_type" />
      </el-form-item>
    </el-col>
    <el-col :span="8">
      <el-form-item
        :label="__('Total Area')"
        :error="form.errors['space.total_area']"
        :show-message="form.errors['space.total_area']"
      >
        <el-input v-model="space.total_area" />
      </el-form-item>
    </el-col>
    <el-col :span="8">
      <el-form-item
        :label="__('Area Annexes')"
        :error="form.errors['space.area_annexes']"
        :show-message="form.errors['space.area_annexes']"
      >
        <el-input v-model="space.area_annexes" />
      </el-form-item>
    </el-col>
    <el-col :span="8">
      <el-form-item
        :label="__('Street Front')"
        :error="form.errors['space.street_front']"
        :show-message="form.errors['space.street_front']"
      >
        <el-input v-model="space.street_front" />
      </el-form-item>
    </el-col>
    <el-col :span="8">
      <el-form-item
        :label="__('Floor')"
        :error="form.errors['space.floor']"
        :show-message="form.errors['space.floor']"
      >
        <el-input v-model="space.floor" />
      </el-form-item>
    </el-col>
    <el-col :span="8">
      <el-form-item
        :label="__('Street Type')"
        :show-message="form.errors['space.street_type']"
        :error="form.errors['space.street_type']"
      >
        <el-select
          v-model="space.street_type"
          class="m-2"
          placeholder="Select a street type"
          :class="`full-width`"
        >
          <el-option
            v-for="streetType in streetTypes"
            :key="streetType"
            :label="streetType"
            :value="streetType"
          />
        </el-select>
      </el-form-item>
    </el-col>
    <el-col :span="8">
      <el-form-item
        :label="__('Grade')"
        :show-message="form.errors['space.grade']"
        :error="form.errors['space.grade']"
      >
        <el-select
          v-model="space.grade"
          class="m-2"
          placeholder="Select a grade"
          :class="`full-width`"
        >
          <el-option
            v-for="(num, i) in 10"
            :key="num"
            :label="num"
            :value="num"
          />
        </el-select>
      </el-form-item>
    </el-col>
    <el-col :span="8">
      <el-form-item
        :label="__('Bathroom')"
        :show-message="form.errors['space.bathroom']"
        :error="form.errors['space.bathroom']"
      >
        <el-select
          v-model="space.bathroom"
          class="m-2"
          placeholder="Bathroom"
          :class="`full-width`"
        >
          <el-option label="Yes" value="1" />
          <el-option label="No" value="0" />
        </el-select>
      </el-form-item>
    </el-col>
  </el-row>
</template>

<script lang="ts" setup>
  import { ShopTypes } from '~shared/enums/shop-types.enum';
  import { StreetTypes } from '~shared/enums/street-types.enum';
  const props = defineProps(['form']);
  const space = reactive(props.form.space);
  // enumes values
  const shopTypes = Object.values(ShopTypes);
  const streetTypes = Object.values(StreetTypes);
  const emits = defineEmits(['spaceChanged']);
  watch(
    space,
    (newValue, oldValue) => {
      emits('spaceChanged', space);
    },
    { deep: true }
  );
</script>

<style lang="css">
  .full-width {
    width: 100%;
  }
</style>

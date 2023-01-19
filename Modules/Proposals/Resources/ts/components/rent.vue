<template>
  <el-row :gutter="10">
    <el-col :span="24">
      <el-form-item
        :label="__('Price')"
        :error="form.errors['rent.price']"
        :show-message="form.errors['rent.price']"
      >
        <el-input v-model="rent.price" />
      </el-form-item>
    </el-col>
    <el-col :span="24">
      <el-form-item
        :label="__('Currency')"
        :show-message="form.errors['rent.currency']"
        :error="form.errors['rent.currency']"
      >
        <el-select
          v-model="rent.currency"
          class="m-2"
          placeholder="Select currency"
          :class="`full-width`"
        >
          <el-option
            v-for="currency in currencies"
            :key="currency"
            :label="currency"
            :value="currency"
          />
        </el-select>
      </el-form-item>
    </el-col>
    <el-col :span="24">
      <el-form-item
        :label="__('Payment type')"
        :show-message="form.errors['rent.payment_type']"
        :error="form.errors['rent.payment_type']"
      >
        <el-select
          v-model="rent.payment_type"
          class="m-2"
          placeholder="Select payment type"
          :class="`full-width`"
        >
          <el-option
            v-for="paymentType in paymentTypes"
            :key="paymentType"
            :label="paymentType"
            :value="paymentType"
          />
        </el-select>
      </el-form-item>
    </el-col>
  </el-row>
</template>

<script lang="ts" setup>
  const props = defineProps(['form']);
  const rent = reactive(props.form.rent);
  const currencies: string[] = ['RON', 'EUR', 'USD'];
  const paymentTypes: string[] = [
    'lunara',
    'trimestrial',
    'semestrial',
    'anual',
  ];
  const emits = defineEmits(['rentChanged']);
  watch(
    rent,
    (newValue, oldValue) => {
      emits('rentChanged', rent);
    },
    { deep: true }
  );
</script>

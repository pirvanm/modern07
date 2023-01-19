<template>
  <el-row :gutter="20">
    <el-col :span="12" :offset="6">
      <el-form :model="form" :rules="rules" status-icon label-width="200px">
        <el-form-item required :label="`${props.label} Name`" prop="name">
          <el-input v-model="form.name" style="width: 100%" />
        </el-form-item>
        <el-form-item label="Guard Name" prop="guard_name">
          <el-select
            v-model="form.guard_name"
            placeholder="Please select a guard type"
            style="width: 100%"
          >
            <el-option
              v-for="(guard, index) in guards"
              :key="index"
              :label="guard.label"
              :value="guard.value"
            />
          </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm(ruleFormRef)">
            Submit
          </el-button>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>

<!-- Layout setup for component-->
<script lang="ts">
  import GuestLayout from '~views/layouts/Guest.vue';

  export default {
    layout: GuestLayout,
  };
</script>
<!--End layout setup-->

<script setup lang="ts">
  import { onMounted, reactive, ref } from 'vue';
  import { useForm } from '@inertiajs/inertia-vue3';
  import type { FormInstance } from 'element-plus';
  import { ElMessage } from 'element-plus';
  import { GuardTypes } from '~shared/enums';

  const props = defineProps<{
    label: string;
    routeAlias: string;
    successMessage: string;
  }>();

  const submitForm = () => {
    //debugger;
    // if (!ruleFormRef.value) return;

    ruleFormRef.value?.validate((isFormValid) => {
      if (!isFormValid) {
        return ElMessage.error('Form invalid');
      }
    });

    try {
      useForm(form)?.post(route(props.routeAlias), {
        preserveScroll: true,
        onError: (errors: any) => {
          Object.values(errors).forEach((err: any) => {
            ElMessage.error(err);
          });
        },
        onSuccess: () => {
          ElMessage.success(props.successMessage);
        },
      });
    } catch (e) {
      ElMessage.error(`Eroare la adaugarea ${props.label}`);
    }
  };

  const checkName = (rule: any, value: string, callback: any) => {
    if (!value) {
      return callback(new Error('Please enter a name'));
    }
    if (value.trim().length < 5) {
      return callback(new Error('Please enter a longer name'));
    }
    callback();
  };

  onMounted(() => {
    Object.keys(GuardTypes).forEach((guardKey: string) => {
      guards.value.push({
        label: guardKey,
        value: GuardTypes[guardKey as keyof typeof GuardTypes],
      });
    });
  });

  const ruleFormRef = ref<FormInstance>();
  const form = reactive({
    name: '',
    guard_name: '',
  });
  const rules = reactive({
    name: [{ validator: checkName, trigger: 'change' }],
    guard_name: [
      {
        required: true,
        message: 'Please select a guard name',
        trigger: 'change',
      },
    ],
  });
  const guards: any = ref([]);
</script>

<style scoped>
  el-row {
    margin-top: 20vh;
    width: 100%;
  }
</style>

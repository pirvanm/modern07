<template>
  <el-row :gutter="20">
    <el-col :span="12" :offset="6">
      <el-form :model="form" status-icon :rules="rules" label-width="120px">
        <el-form-item label="Email" prop="email">
          <el-input v-model="form.email" />
        </el-form-item>
        <el-form-item label="Password" prop="pass">
          <el-input
            v-model="form.password"
            type="password"
            autocomplete="off"
          />
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm(form)">
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

<script lang="ts" setup>
  import { reactive } from 'vue';
  import { InertiaForm, useForm } from '@inertiajs/inertia-vue3';
  import { ElMessage } from 'element-plus';

  const form: InertiaForm<{ email: string; password: string }> = useForm({
    email: '',
    password: '',
  });

  function submitForm(
    formEl?: InertiaForm<{ email: string; password: string }>
  ) {
    if (formEl?.hasErrors) {
      return ElMessage.error('Date de conectare invalide!');
    }

    formEl?.post('/login', {
      preserveScroll: true,
      onError: (errors: any) => ElMessage.error(errors.email),
    });
  }

  const checkEmail = (rule: any, value: any, callback: any) => {
    if (!value) {
      form.setError('email', 'Please input the email');
      return callback(new Error('Please input the email'));
    }
    setTimeout(() => {
      ``;
      if (!value.match(/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/)) {
        form.setError('email', 'Please input valid email');
        return callback(new Error('Please input valid email'));
      }
      form.clearErrors('email');
      callback();
    }, 1000);
  };

  const validatePassword = (rule: any, value: any, callback: any) => {
    if (value === '' || value.length < 8) {
      const errorMessage = 'Please input minimum 8 characters';
      form.setError('password', errorMessage);
      return callback(new Error(errorMessage));
    }
    form.clearErrors('password');
    callback();
  };

  const rules = reactive({
    email: [{ validator: checkEmail, trigger: 'blur' }],
    password: [{ validator: validatePassword, trigger: 'blur' }],
  });
</script>

<style scoped>
  .el-row {
    margin-top: 20vh;
    width: 100%;
  }
</style>

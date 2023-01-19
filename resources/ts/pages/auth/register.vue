<template>
  <el-row :gutter="20">
    <el-col :span="12" :offset="6">
      <el-form :model="form" status-icon :rules="rules" label-width="120px">
        <el-form-item label="Nume" prop="name">
          <el-input v-model="form.name" />
        </el-form-item>
        <el-form-item label="Email" prop="email">
          <el-input v-model="form.email" />
        </el-form-item>
        <el-form-item label="Parola" prop="password">
          <el-input
            v-model="form.password"
            type="password"
            autocomplete="off"
          />
        </el-form-item>
        <el-form-item label="Confirmare Parola" prop="passwordConfirmation">
          <el-input
            v-model="form.passwordConfirmation"
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

  const form: InertiaForm<{
    email: string;
    name: string;
    password: string;
    passwordConfirmation: string;
  }> = useForm({
    email: '',
    name: '',
    password: '',
    passwordConfirmation: '',
  });

  function submitForm(
    formEl?: InertiaForm<{
      email: string;
      name: string;
      password: string;
      passwordConfirmation: string;
    }>
  ) {
    if (formEl?.hasErrors) {
      return ElMessage.error('Date de conectare invalide!');
    }

    formEl
      ?.transform(
        (data: {
          email?: string;
          password?: string;
          passwordConfirmation?: string;
          name?: string;
        }): object => {
          const formattedForm = Object.assign(
            { password_confirmation: data.passwordConfirmation },
            data
          );
          delete formattedForm.passwordConfirmation;
          return formattedForm;
        }
      )
      .post('/register', {
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
      if (!value.match(/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/)) {
        form.setError('email', 'Please input valid email');
        return callback(new Error('Please input valid email'));
      }
      form.clearErrors('email');
      callback();
    }, 1000);
  };

  const validatePassword = (rule: any, value: any, callback: any) => {
    setTimeout(() => {
      if (value === '' || value.length < 8) {
        const errorMessage = 'Please input minimum 8 characters';
        form.setError('password', errorMessage);
        return callback(new Error(errorMessage));
      }
      form.clearErrors('password');
      callback();
    }, 400);
  };

  const validateName = (rule: any, value: string, callback: any) => {
    if (value === '' || value.trim().length < 1) {
      const errorMessage = 'Please enter a name';
      form.setError('name', errorMessage);
      return callback(new Error(errorMessage));
    }
    form.clearErrors('name');
    callback();
  };

  const validatePasswordConfirmation = (
    rule: any,
    value: string,
    callback: any
  ) => {
    setTimeout(() => {
      if (
        value === '' ||
        value.trim().length < 1 ||
        value.trim() !== form.password.trim()
      ) {
        const errorMessage = 'Please enter a name';
        form.setError('name', errorMessage);
        return callback(new Error(errorMessage));
      }
      form.clearErrors('name');
      callback();
    }, 1000);
  };

  const rules = reactive({
    name: [{ validator: validateName, trigger: 'blur' }],
    email: [{ validator: checkEmail, trigger: 'blur' }],
    password: [{ validator: validatePassword, trigger: 'blur' }],
    passwordConfirmation: [
      { validator: validatePasswordConfirmation, trigger: 'blur' },
    ],
  });
</script>

<style scoped>
  .el-row {
    margin-top: 20vh;
    width: 100%;
  }
</style>

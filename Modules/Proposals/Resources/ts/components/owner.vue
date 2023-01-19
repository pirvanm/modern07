<template>
  <el-row :gutter="12">
    <el-col :span="12">
      <el-form-item
        :label="__('Name')"
        :error="form.errors['owner.name']"
        :show-message="form.errors['owner.company']"
      >
        <el-input v-model="owner.name" />
      </el-form-item>
    </el-col>
    <el-col :span="12">
      <el-form-item
        :label="__('Company')"
        :error="form.errors['owner.company']"
        :show-message="form.errors['owner.company']"
      >
        <el-input v-model="owner.company" />
      </el-form-item>
    </el-col>
  </el-row>
  <el-row :gutter="12">
    <el-col :span="12">
      <el-form-item
        :label="__('Phone')"
        :error="form.errors['owner.phone']"
        :show-message="form.errors['owner.phone']"
      >
        <el-input v-model="owner.phone" />
      </el-form-item>
    </el-col>
    <el-col :span="12">
      <el-form-item
        :label="__('Email')"
        :error="form.errors['owner.email']"
        :show-message="form.errors['owner.email']"
      >
        <el-input v-model="owner.email" />
      </el-form-item>
    </el-col>
  </el-row>
</template>

<script lang="ts" setup>
  const props = defineProps(['form']);
  const owner = reactive(props.form.owner);
  const emits = defineEmits(['ownerChanged']);
  watch(
    owner,
    (newValue, oldValue) => {
      emits('ownerChanged', owner);
    },
    { deep: true }
  );
</script>

<template>
  <el-form-item
    :label="__('Observations')"
    :error="form.errors.note"
    :show-message="form.errors.note"
    cols="50"
    rows="10"
  >
    <el-input v-model="note" type="textarea" cols="50" rows="10" />
  </el-form-item>
</template>

<script lang="ts" setup>
  const props = defineProps(['form']);

  const note = ref(props.form.note);

  const emits = defineEmits(['noteChanged']);

  watch(note, (newValue, oldValue) => {
    emits('noteChanged', note);
  });
</script>

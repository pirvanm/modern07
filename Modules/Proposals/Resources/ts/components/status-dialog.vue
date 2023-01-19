<template>
  <el-dialog :title="`Approve/Reject proposal #${proposal.id}`" width="40%">
    <el-form :model="form" label-position="top">
      <el-form-item
        label="Status"
        :show-message="form.errors.status"
        :error="form.errors.status"
      >
        <el-select
          v-model="form.status"
          class="m-2"
          placeholder="Select a status"
          :class="`full-width`"
          @change="changeStatus"
        >
          <el-option
            v-for="status in filteredStatuses"
            :key="status"
            :label="status"
            :value="status"
          />
        </el-select>
      </el-form-item>
      <el-form-item
        v-show="isRejectStatus"
        label="Reason"
        :error="form.errors.reason"
        :show-message="form.errors.reason"
      >
        <el-input v-model="form.reason" type="textarea" />
      </el-form-item>
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="closeDialog">Cancel</el-button>
        <el-button type="primary" @click="save()"> Confirm </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script lang="ts" setup>
  import { InertiaForm, useForm } from '@inertiajs/inertia-vue3';
  import { ProposalStatuses } from '~shared/enums/proposal-statuses.enum';
  const props = defineProps({
    proposal: {
      type: Object,
      required: true,
    },
  });
  const emits = defineEmits(['closeDialog']);

  const filteredStatuses = ref([]);
  const statusObj = {
    status: null,
    reason: null,
  };
  const form: InertiaForm<{ status: string | null; reason: string | null }> =
    useForm(statusObj);
  const closeDialog = () => {
    emits('closeDialog');
  };
  const save = () => {
    const method = 'patch';
    const url = route('proposals.update.status', {
      proposal: props.proposal.id,
    });
    form[method](url, {
      onSuccess: () => {
        form.clearErrors();
        closeDialog();
        ElMessage({
          message: 'Operation completed successfully!',
          type: 'success',
        });
      },
      onError: (errors: any) => {
        ElMessage({
          message: 'Something went wrong',
          type: 'error',
        });
      },
    });
  };

  const isRejectStatus = computed(() => {
    return [
      ProposalStatuses.REJECTION_OP,
      ProposalStatuses.REJECTION_LG,
    ].includes(form.status);
  });
  onMounted(() => {
    // if new show only operational statuses
    if (props.proposal.status === ProposalStatuses.NEW) {
      filteredStatuses.value = [
        ProposalStatuses.APPROVAL_OP,
        ProposalStatuses.REJECTION_OP,
      ];
    }
    // if APPROVAL operationally show only legal statuses
    if (props.proposal.status === ProposalStatuses.DOCS_MANAGER) {
      filteredStatuses.value = [
        ProposalStatuses.APPROVAL_LG,
        ProposalStatuses.REJECTION_LG,
      ];
    }
  });
</script>

<style lang="css">
  .full-width {
    display: block;
    width: 100%;
  }
</style>

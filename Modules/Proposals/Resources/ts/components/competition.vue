<template>
  <el-row style="justify-content: end; margin-bottom: 1rem">
    <el-button type="success" @click="addCompetitor"><i-ep-plus /></el-button>
  </el-row>
  <el-row
    v-for="(competitionItem, index) in competition"
    v-if="competition.length"
    style="align-items: end"
    :gutter="10"
  >
    <el-col :span="11">
      <el-form-item
        :label="__('Company')"
        :error="form.errors[`competition.${index}.name`]"
        :show-message="form.errors[`competition.${index}.name`]"
      >
        <el-select
          v-model="competitionItem.name"
          class="m-2"
          :label="__('Select a Competitor')"
          :class="`full-width`"
        >
          <el-option
            v-for="competitor in competitors"
            :key="competitor"
            :label="competitor"
            :value="competitor"
          />
        </el-select>
      </el-form-item>
    </el-col>
    <el-col :span="11">
      <el-form-item
        :label="__('Distance')"
        :error="form.errors[`competition.${index}.distance`]"
        :show-message="form.errors[`competition.${index}.distance`]"
      >
        <el-input v-model="competitionItem.distance" />
      </el-form-item>
    </el-col>
    <el-col :span="2">
      <el-button
        type="danger"
        style="margin-bottom: 18px"
        @click="removeCompetitor(index)"
        ><i-ep-delete
      /></el-button>
    </el-col>
  </el-row>
</template>

<script lang="ts" setup>
  import { reactive } from 'vue';

  const props = defineProps(['form']);

  const competition = reactive(props.form.competition);

  const emits = defineEmits(['competitionChanged']);

  const competitors: string[] = [
    'superbet',
    '888casino',
    'pokerstars',
    'stanleybet',
  ];

  const addCompetitor = () => {
    competition.push({
      name: '',
      distance: '',
    });
  };

  const removeCompetitor = (index) => {
    competition.splice(index, 1);
  };

  watch(
    competition,
    (newValue, oldValue) => {
      emits('competitionChanged', competition);
    },
    { deep: true }
  );

  onMounted(() => {
    if (competition.length === 0) {
      addCompetitor();
    }
  });
</script>

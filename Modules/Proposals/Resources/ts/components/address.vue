<template>
  <el-row :gutter="10">
    <el-col :span="2" class="big-atention">
      <i-ep-Warning />
    </el-col>
    <el-col :span="18" class="message">
      <p>
        {{ __('WarningMessage') }}
      </p>
      <p>
        {{ __('WarningMessageLinetwo') }}
      </p>

      <p class="bolded">
        {{ __('WarningMessageDoNot') }}
      </p>
    </el-col>
  </el-row>
  <el-row :gutter="10">
    <el-col :span="22">
      <el-form-item
        ref="ruleFormRef"
        :span="13"
        :error="form.errors['address.neighborhood']"
        :show-message="form.errors['address.neighborhood']"
        :model="ruleForm"
        status-icon
      >
        <el-input
          v-model="address.neighborhood"
          :placeholder="__('Neighborhood')"
        />
      </el-form-item>
    </el-col>
    <el-col :span="2" class="tooltip">
      <el-tooltip
        class="box-item"
        effect="dark"
        :content="__('InfoNeighborhood')"
        placement="right-start"
      >
        <el-button size="small" type="success">
          <i-ep-InfoFilled />
        </el-button>
      </el-tooltip>
    </el-col>
  </el-row>

  <el-row :gutter="10">
    <el-col :span="16">
      <el-form-item
        :error="form.errors['address.street_name']"
        :show-message="form.errors['address.street_name']"
      >
        <el-input
          v-model="address.street_name"
          :placeholder="__('Street Name')"
        />
      </el-form-item>
    </el-col>

    <el-col :span="2" class="tooltip">
      <el-tooltip
        class="box-item"
        effect="dark"
        :content="__('InfoStreetName')"
        placement="right-start"
      >
        <el-button size="small" type="success">
          <i-ep-InfoFilled />
        </el-button>
      </el-tooltip>
    </el-col>

    <el-col :span="4">
      <el-form-item
        :error="form.errors['address.street_number']"
        :show-message="form.errors['address.street_number']"
      >
        <el-input
          v-model="address.street_number"
          :placeholder="__('Street Number')"
        />
      </el-form-item>
    </el-col>

    <el-col :span="2" class="tooltip">
      <el-tooltip
        class="box-item"
        effect="dark"
        :content="__('InfoStreetNumber')"
        placement="right-start"
      >
        <el-button size="small" type="success">
          <i-ep-InfoFilled />
        </el-button>
      </el-tooltip>
    </el-col>
  </el-row>
  <el-row :gutter="10">
    <el-col :span="3">
      <el-form-item
        :error="form.errors['address.building_number']"
        :show-message="form.errors['address.building_number']"
      >
        <el-input
          v-model="address.building_number"
          :placeholder="__('Building Number')"
        />
      </el-form-item>
    </el-col>
    <el-col :span="2" class="tooltip">
      <el-tooltip
        class="box-item"
        effect="dark"
        :content="__('InfoBuildingNumber')"
        placement="right-start"
      >
        <el-button size="small" type="success">
          <i-ep-InfoFilled />
        </el-button>
      </el-tooltip>
    </el-col>
    <el-col :span="4">
      <el-form-item
        :error="form.errors['address.building_entrance']"
        :show-message="form.errors?.building_entrance"
      >
        <el-input
          v-model="address.building_entrance"
          :placeholder="__('Building Entrance')"
        />
      </el-form-item>
    </el-col>
    <el-col :span="2" class="tooltip">
      <el-tooltip
        class="box-item"
        effect="dark"
        :content="__('InfoBuildingEntrance')"
        placement="right-start"
      >
        <el-button size="small" type="success">
          <i-ep-InfoFilled />
        </el-button>
      </el-tooltip>
    </el-col>
    <el-col :span="4">
      <el-form-item
        :error="form.errors['address.apartment_floor']"
        :show-message="form.errors['address.apartment_floor']"
      >
        <el-input
          v-model="address.apartment_floor"
          :placeholder="__('Floor')"
        />
      </el-form-item>
    </el-col>
    <el-col :span="2" class="tooltip">
      <el-tooltip
        class="box-item"
        effect="dark"
        :content="__('InfoFloor')"
        placement="right-start"
      >
        <el-button size="small" type="success">
          <i-ep-InfoFilled />
        </el-button>
      </el-tooltip>
    </el-col>
    <el-col :span="4">
      <el-form-item
        :error="form.errors['address.apartment_number']"
        :show-message="form.errors?.apartment_number"
      >
        <el-input
          v-model="address.apartment_number"
          :placeholder="__('Apartment Number')"
        />
      </el-form-item>
    </el-col>

    <el-col :span="2" class="tooltip">
      <el-tooltip
        class="box-item"
        effect="dark"
        :content="__('InfoApartmentNumber')"
        placement="right-start"
      >
        <el-button size="small" type="success">
          <i-ep-InfoFilled />
        </el-button>
      </el-tooltip>
    </el-col>
  </el-row>

  <el-row :gutter="10">
    <el-col :span="22">
      <el-form-item
        :error="form.errors['address.notes']"
        :show-message="form.errors['address.notes']"
      >
        <el-input v-model="address.notes" :placeholder="__('Other')" />
      </el-form-item>
    </el-col>
    <el-col :span="2" class="tooltip">
      <el-tooltip
        class="box-item"
        effect="dark"
        :content="__('InfoOther')"
        placement="right-start"
      >
        <el-button size="small" type="success">
          <i-ep-InfoFilled />
        </el-button>
      </el-tooltip>
    </el-col>
  </el-row>
</template>
<script lang="ts" setup>
  import { reactive, ref } from 'vue';
  import type { FormInstance, FormRules } from 'element-plus';

  const formSize = ref('default');

  const ruleFormRef = ref<FormInstance>();

  const ruleForm = reactive({});

  const props = defineProps(['form']);
  const address = reactive(props.form.address);
  const emits = defineEmits(['addressChanged']);
  watch(
    address,
    (newValue, oldValue) => {
      emits('addressChanged', address);
    },
    { deep: true }
  );
</script>

<style lang="scss">
  .tooltip {
  }

  .big-atention {
    font-size: 43px;
    color: #e7505a !important;
    margin: auto;
    width: 50%;
  }

  .message {
    line-height: 8px;

    p {
      color: #e7505a !important;
    }

    .bolded {
      font-weight: bold;
    }
  }
</style>

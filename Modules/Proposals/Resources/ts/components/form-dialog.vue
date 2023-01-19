<template>
  <el-dialog
    :title="proposal ? __('Edit Proposal') : __('Add Proposal')"
    width="40%"
  >
    <el-steps :active="multiStep.currentStep" align-center>
      <el-step
        v-for="(step, index) in multiStep.steps"
        :key="index"
        :title="__(step.label)"
        @click="goToStep(index)"
      />
    </el-steps>

    <el-divider />

    <el-form v-loading="proposalLoading" :model="form" label-position="top">
      <div
        v-for="(step, index) in multiStep.steps"
        v-if="!proposalLoading"
        :key="index"
      >
        <div v-if="multiStep.currentStep === index">
          <component
            :is="__(multiStep.steps[index].component)"
            :form="form"
            @cityChanged="cityChanged"
            @addressChanged="addressChanged"
            @ownerChanged="ownerChanged"
            @spaceChanged="spaceChanged"
            @rentChanged="rentChanged"
            @competitionChanged="competitionChanged"
            @noteChanged="noteChanged"
          >
          </component>
        </div>
      </div>
    </el-form>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="closeDialog">{{ __('Cancel') }}</el-button>
        <el-button
          type="primary"
          :disabled="multiStep.currentStep === 0"
          @click="prevStep"
        >
          {{ __('Prev Step') }}
        </el-button>
        <el-button v-if="!isLastStep" type="primary" @click="nextStep">
          {{ __('Next Step') }}
        </el-button>
        <el-button v-else type="primary" @click="submit">
          {{ __('Save') }}
        </el-button>
        <el-button v-if="proposal" type="primary" @click="submit">
          {{ __('Edit') }}
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script lang="ts" setup>
  import { onMounted } from 'vue';
  import axios from 'axios';
  import { InertiaForm, useForm } from '@inertiajs/inertia-vue3';

  import { ICity } from '~shared/interfaces/settlements/city.interface';
  import { IProposal } from '@/shared/interfaces/proposals/proposal.interface';
  import { IOwner } from '@/shared/interfaces/proposals/owner.interface';
  import { ISpace } from '@/shared/interfaces/proposals/space.interface';
  import { IRent } from '@/shared/interfaces/proposals/rent.interface';
  import { IAddress } from '~shared/interfaces/address.interface';

  import SettlementComponent from '~shared/components/settlement.vue';
  import AddressComponent from './address.vue';
  import SpaceComponent from './space.vue';
  import RentComponent from './rent.vue';
  import OwnerComponent from './owner.vue';
  import CompetitionComponent from './competition.vue';
  import NoteComponent from './note.vue';

  // props and emits
  const props: any = defineProps(['proposal']);
  const emit: any = defineEmits(['closeDialog']);

  const multiStep = reactive({
    currentStep: 0,
    steps: [
      {
        label: 'Location',
        component: SettlementComponent,
      },
      {
        label: 'Address',
        component: AddressComponent,
      },
      {
        label: 'Owner',
        component: OwnerComponent,
      },
      {
        label: 'Space',
        component: SpaceComponent,
      },
      {
        label: 'Rent',
        component: RentComponent,
      },
      {
        label: 'Competition',
        component: CompetitionComponent,
      },
      {
        label: 'Observations',
        component: NoteComponent,
      },
    ],
  });

  const proposalObject = {
    id: null,
    city: null,
    city_id: null,
    note: null,
    address: {
      neighborhood: null,
      street_name: null,
      street_number: null,
      building_number: null,
      building_entrance: null,
      apartment_floor: null,
      apartment_number: null,
      notes: null,
    } as IAddress,
    owner: {
      name: null,
      company: null,
      phone: null,
      email: null,
    },
    space: {
      agency_type: null,
      space_type: null,
      total_area: null,
      floor: null,
      area_annexes: null,
      street_front: null,
      street_type: null,
      grade: null,
      bathroom: null,
      company_agency: null,
    } as ISpace,
    rent: {
      price: null,
      payment_type: null,
      currency: null,
    } as IRent,
    competition: [],
  } as IProposal;

  // when editing, we want to have a loading animation
  const proposalLoading = ref<boolean>(props.proposal ? true : false);

  // to keep track of the data
  let form: InertiaForm<IProposal> = useForm(proposalObject);

  // so we can refresh the grid
  const refreshGrid: any = inject('refreshGrid');

  // listen for changes in step components
  const cityChanged = (city: ICity) => {
    Object.assign(form, { city: city });
    Object.assign(form, { city_id: city?.id });
  };

  const addressChanged = (address: IAddress) => {
    Object.assign(form, { address: address });
  };

  const ownerChanged = (owner: IOwner) => {
    Object.assign(form, { owner });
  };

  const spaceChanged = (space: ISpace) => {
    Object.assign(form, { space });
  };

  const rentChanged = (rent: IRent) => {
    Object.assign(form, { rent });
  };

  const competitionChanged = (competition: []) => {
    Object.assign(form, { competition });
  };

  const noteChanged = (note: string) => {
    Object.assign(form, { note });
  };

  // for form subbmission
  function submit() {
    const url = form.id
      ? route('proposals.update', { proposal: proposalObject.id })
      : route('proposals.store');
    const method = form.id ? 'patch' : 'post';

    form[method](url, {
      preserveScroll: true,
      onSuccess: () => {
        refreshGrid.value = !refreshGrid.value;
        form.clearErrors();
        closeDialog();
        ElMessage({
          message: 'Operation completed successfully!',
          type: 'success',
        });
      },
      onError: (errors: any) => {
        ElMessage({
          message: 'Something went wrong, please check the steps!',
          type: 'error',
        });
      },
    });
  }

  // validate each step data
  function validateStep(step: string) {
    const method = 'post';
    const url = route('proposals.steps.validate', { step: step });

    proposalLoading.value = true;

    form[method](url, {
      preserveScroll: true,
      onSuccess: () => {
        form.clearErrors();
        multiStep.currentStep++;
        proposalLoading.value = false;
      },
      onError: (errors: any) => {
        proposalLoading.value = false;
        console.log(errors);
      },
    });
  }

  // closing the dialog
  const closeDialog = () => {
    emit('closeDialog');
  };

  // proposal loading data related
  function getProposal() {
    axios
      .get(`/api/proposals/${props.proposal.id}`)
      .then((response) => {
        form.address = { ...response.data.address };
        form.space = { ...response.data.space };
        form.owner = { ...response.data.owner };
        form.note = response.data.note;
        proposalLoading.value = false;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  const initProposalObject = () => {
    // if we are editing an user
    if (props.proposal) {
      Object.assign(proposalObject, props.proposal);
      proposalObject.city = {
        ...props.proposal.cities,
        county: { ...props.proposal.counties },
      };
      proposalObject.city_id = proposalObject.city?.id as number | null;

      form = useForm(proposalObject);
    }
  };

  // step related
  const nextStep = () => {
    if (multiStep.currentStep < multiStep.steps.length) {
      validateStep(
        multiStep.steps[multiStep.currentStep].label.toLocaleLowerCase()
      );
    }
  };

  const prevStep = () => {
    if (multiStep.currentStep > 0) {
      multiStep.currentStep--;
    }
  };

  const isLastStep = computed(() => {
    return multiStep.currentStep === multiStep.steps.length - 1;
  });

  const goToStep = (step: number) => {
    if (props.proposal) {
      multiStep.currentStep = step;
    }
  };

  onMounted(() => {
    // if we are editing, we had to load up all the data for the proposal
    if (props.proposal) {
      getProposal();
      initProposalObject();

      // remove location from steps when editing
      multiStep.steps.splice(0, 1);
    }
  });
</script>

<style lang="css">
  @media screen and (max-width: 1400px) {
    .el-dialog {
      width: 70% !important;
    }
  }
  @media screen and (max-width: 1024px) {
    .el-dialog {
      width: 100% !important;
    }
  }

  .el-step {
    cursor: pointer;
  }
  .el-step:hover .el-step__title {
    color: #409eff;
  }
  .el-step:hover .el-step__icon {
    border-color: #409eff;
  }
  .el-step:hover .is-text {
    color: #409eff;
  }
</style>

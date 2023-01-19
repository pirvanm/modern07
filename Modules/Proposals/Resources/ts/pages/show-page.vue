<template>
  <el-card class="box-card" shadow="never">
    <template #header>
      <div class="card-header">
        <span>
          {{ __('Proposal') }}
          #{{ proposal.id }} | {{ proposal.created_at }} |
          {{ proposal.status.toUpperCase() }}
        </span>
        <div v-if="!isProposalRejected">
          <el-button
            v-if="canUpdateStatus"
            type="primary"
            @click="showStatusDialog = true"
            >Approve - Reject</el-button
          >
          <el-button
            v-if="canProcessStatus"
            type="primary"
            @click="processStatus"
          >
            <i-ep-setting class="processing-icon" /> Processing
          </el-button>
        </div>
      </div>
    </template>
    <el-row :gutter="24">
      <el-col :xs="24" :lg="12">
        <el-row :gutter="24">
          <el-col :xs="24" :sm="12">
            <el-card class="box-card" shadow="never">
              <template #header>
                <div class="card-header">
                  <span>{{ __('Address') }}</span>
                </div>
              </template>
              <div class="card-item">
                <span class="item-label">{{ __('Country') }}:</span>
                <span class="item-value">Romania</span>
              </div>
              <div class="card-item">
                <span class="item-label"> {{ __('County') }}:</span>
                <span class="item-value">{{
                  proposal.city?.county?.name
                }}</span>
              </div>
              <div class="card-item">
                <span class="item-label"> {{ __('City') }} </span>
                <span class="item-value">{{ proposal.city?.name }}</span>
              </div>

              <div class="card-item">
                <span class="item-label"> {{ __('Address') }} :</span>
                <span class="item-value">
                  {{ __('Street') }} : {{ proposal.address?.street_name }},
                  {{ __(' Street Number') }} :
                  {{ proposal.address?.street_number }}
                </span>
              </div>
            </el-card>
          </el-col>
          <el-col :xs="24" :sm="12">
            <el-card class="box-card" shadow="never">
              <template #header>
                <div class="card-header">
                  <span> {{ __('Owner') }} </span>
                </div>
              </template>
              <div class="card-item">
                <span class="item-label"> {{ __('Name') }} :</span>
                <spna class="item-value">{{ proposal.owner?.name }}</spna>
              </div>
              <div class="card-item">
                <span class="item-label"> {{ __('Company') }} :</span>
                <span class="item-value">{{ proposal.owner?.company }}</span>
              </div>
              <div class="card-item">
                <span class="item-label"> {{ __('Phone') }} :</span>
                <span class="item-value">{{ proposal.owner?.phone }}</span>
              </div>
              <div class="card-item">
                <span class="item-label"> {{ __('Email') }} :</span>
                <span class="item-value">{{ proposal.owner?.email }}</span>
              </div>
            </el-card>
          </el-col>

          <el-col :xs="24" :sm="12">
            <el-card class="box-card" shadow="never">
              <template #header>
                <div class="card-header">
                  <span>{{ __('Space') }}</span>
                </div>
              </template>
              <div class="card-item">
                <span class="item-label">{{ __('agency_type') }}:</span>
                <span class="item-value">{{
                  proposal.space?.agency_type
                }}</span>
              </div>
              <div class="card-item">
                <span class="item-label">{{ __('total_area') }}:</span>
                <span class="item-value">{{ proposal.space?.total_area }}</span>
              </div>

              <div class="card-item">
                <span class="item-label">{{ __('area_annexes') }}:</span>
                <span class="item-value">{{
                  proposal.space?.area_annexes
                }}</span>
              </div>

              <div class="card-item">
                <span class="item-label">{{ __('street_front') }}</span>
                <span class="item-value">{{
                  proposal.space?.street_front
                }}</span>
              </div>

              <div class="card-item">
                <span class="item-label">{{ __('floor') }}:</span>
                <span class="item-value">{{ proposal.space?.floor }}</span>
              </div>

              <div class="card-item">
                <span class="item-label">{{ __('street_type') }}:</span>
                <span class="item-value">{{
                  proposal.space?.street_type
                }}</span>
              </div>

              <div class="card-item">
                <span class="item-label">{{ __('grade') }}:</span>
                <span class="item-value">{{ proposal.space?.grade }}</span>
              </div>

              <div class="card-item">
                <span class="item-label">{{ __('bathroom') }}:</span>
                <span class="item-value">{{ proposal.space?.bathroom }}</span>
              </div>
            </el-card>
          </el-col>

          <el-col :xs="24" :sm="12">
            <el-card class="box-card" shadow="never">
              <template #header>
                <div class="card-header">
                  <span>{{ __('Rent') }}</span>
                </div>
              </template>
              <div class="card-item">
                <span class="item-label">{{ __('Price') }}:</span>
                <spna class="item-value">{{ proposal.rent?.price }}</spna>
              </div>
              <div class="card-item">
                <span class="item-label">{{ __('Currency') }}:</span>
                <span class="item-value">{{ proposal.rent?.currency }}</span>
              </div>
              <div class="card-item">
                <span class="item-label">{{ __('Payment type') }}:</span>
                <span class="item-value">{{
                  proposal.rent?.payment_type
                }}</span>
              </div>
            </el-card>

            <el-card class="box-card card-competion" shadow="never">
              <template #header>
                <div class="card-header">
                  <span>{{ __('Competition') }}</span>
                </div>
              </template>
              <div class="card-item">
                <span class="item-label">Name:</span>
                <spna class="item-value">{{ proposal.owner?.name }}</spna>
              </div>
              <div class="card-item">
                <span class="item-label">Company:</span>
                <span class="item-value">{{ proposal.owner?.company }}</span>
              </div>
            </el-card>
          </el-col>
        </el-row>

        <el-row :gutter="24">
          <el-card class="box-card" shadow="never">
            <template #header>
              <div class="card-header">
                <span>{{ __('Observations') }}</span>
              </div>
            </template>
            <div class="card-item">
              <p>{{ proposal.note }}</p>
            </div>
          </el-card>
        </el-row>
      </el-col>
      <el-col :xs="24" :lg="12">
        <el-card class="box-card" shadow="never">
          <template #header>
            <div class="card-header">
              <span>Map</span>
              <el-button @click="showMapDialog = true">
                <i-ep-edit />
              </el-button>
            </div>
          </template>
          <GoogleMap
            api-key="AIzaSyDGFtcc7qO48HDV9XJxa0R_MLKZ9Cojmsc"
            style="width: 100%; height: 500px"
            :center="markerPosition"
            :zoom="15"
          >
            <Marker
              ref="googleMarker"
              :options="{ position: markerPosition }"
            />
          </GoogleMap>
        </el-card>
        <el-scrollbar
          v-if="proposal.activities"
          height="300px"
          style="margin-top: 1rem"
        >
          <div v-for="(activity, index) in proposal.activities" :key="index">
            <div class="log">
              <i-ep-position
                v-if="activity.event === 'event'"
                class="log-icon log-icon-orange"
              />
              <i-ep-bell v-else class="log-icon" />
              {{ __(activity.description, { name: activity.causer.name }) }}
              <div style="margin-left: auto">{{ activity.created_at }}</div>
            </div>
            <div
              v-for="(childActivity, indexChild) in activity.children"
              :key="indexChild"
              class="log"
            >
              <i-ep-position
                v-if="childActivity.event === 'event'"
                class="log-icon log-icon-orange"
              />
              <i-ep-bell v-else class="log-icon" />
              {{
                __(childActivity.description, {
                  name: childActivity.causer.name,
                })
              }}
              <div style="margin-left: auto">{{ activity.created_at }}</div>
            </div>
          </div>
        </el-scrollbar>
      </el-col>
    </el-row>
  </el-card>
  <map-dialog-component
    v-if="showMapDialog"
    v-model="showMapDialog"
    :proposal="proposal"
    @closeDialog="showMapDialog = false"
  />
  <status-dialog-component
    v-if="showStatusDialog"
    v-model="showStatusDialog"
    :proposal="proposal"
    @closeDialog="showStatusDialog = false"
  />
</template>

<script lang="ts" setup>
  import { GoogleMap, Marker } from 'vue3-google-map';
  import { reactive } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  import { ProposalStatuses } from '~shared/enums/proposal-statuses.enum';
  import MapDialogComponent from '../components/map-dialog.vue';
  import StatusDialogComponent from '../components/status-dialog.vue';

  const props = defineProps({
    proposal: {
      type: Object,
      required: true,
    },
  });

  const proposal = ref(props.proposal);
  const googleMarker = ref(null);

  const markerPosition = reactive({ lat: 44.439663, lng: 26.096306 });
  const showMapDialog = ref<boolean>(false);
  const showStatusDialog = ref<boolean>(false);

  const setGMap = () => {
    const map = JSON.parse(props.proposal.map);
    markerPosition.lat = map.lat;
    markerPosition.lng = map.lng;
  };

  const canUpdateStatus = computed(() => {
    return [ProposalStatuses.NEW, ProposalStatuses.DOCS_MANAGER].includes(
      props.proposal.status
    );
  });

  const canProcessStatus = computed(() => {
    return [
      ProposalStatuses.APPROVAL_OP,
      ProposalStatuses.APPROVAL_LG,
    ].includes(props.proposal.status);
  });

  const isProposalRejected = computed(() => {
    return [
      ProposalStatuses.REJECTION_OP,
      ProposalStatuses.REJECTION_LG,
      ProposalStatuses.WITHDRAWN,
    ].includes(props.proposal.status);
  });

  const processStatus = () => {
    if (props.proposal.status === ProposalStatuses.APPROVAL_OP) {
      juridicalDepartmentConfirm();
    }

    if (props.proposal.status === ProposalStatuses.APPROVAL_LG) {
      openingCreationConfirm();
    }
  };

  const juridicialDepartmentConfirm = () => {
    ElMessageBox.confirm(
      `The proposal will be sent to the juridical department for approval.`,
      `Process proposal ${props.proposal.id} ?`,
      {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }
    )
      .then(() => {
        Inertia.post(
          route('proposals.process.status', { proposal: props.proposal.id }),
          undefined,
          {
            onSuccess: () => {},
            onError: (error) => {
              console.log(error);
            },
          }
        );
      })
      .catch((error) => {
        console.log(error);
        ElMessage({
          type: 'info',
          message: 'Action canceled',
        });
      });
  };

  const openingCreationConfirm = () => {
    ElMessageBox.confirm(
      `A new opening and agency are going to be created. Please after this step add the contract.`,
      `Process proposal ${props.proposal.id} ?`,
      {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }
    )
      .then(() => {
        Inertia.post(
          route('proposals.process.status', { proposal: props.proposal.id }),
          undefined,
          {
            onSuccess: () => {},
            onError: (error) => {
              console.log(error);
            },
          }
        );
      })
      .catch((error) => {
        ElMessage({
          type: 'info',
          message: 'Action canceled',
        });
      });
  };

  watch(
    props,
    () => {
      proposal.value = props.proposal;
    },
    { deep: true }
  );

  onMounted(() => {
    if (props.proposal.map) {
      setGMap();
    } else {
      ElMessage({
        message: 'The location on the map has not been selected!',
        type: 'warning',
      });
    }
  });
</script>

<style>
  .is-guttered {
    margin-bottom: 20px;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
  }

  .card-item {
    display: flex;
    padding: 0.2rem 0;
    font-size: 0.8rem;
  }

  .card-competion {
    margin-top: 20px;
  }

  .item-label {
    min-width: 100px;
  }

  .item-value {
    color: #444;
    font-weight: 600;
  }

  .log {
    background-color: #eee;
    padding: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    margin-bottom: 0.5rem;
    color: #555;
  }

  .log-icon {
    background-color: #409eff;
    color: #fff;
    padding: 0.2rem;
  }
  .log-icon-orange {
    background: #67c23a;
  }

  .processing-icon {
    margin-right: 0.5rem;
  }
</style>

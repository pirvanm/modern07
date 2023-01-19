<template>
  <el-dialog title="Add Map" width="50%">
    <GoogleMap
      api-key="AIzaSyDGFtcc7qO48HDV9XJxa0R_MLKZ9Cojmsc"
      style="width: 100%; height: 500px"
      :center="markerPosition"
      :zoom="15"
      :draggable="true"
    >
      <Marker
        :options="{
          position: markerPosition,
          draggable: true,
          clickable: true,
        }"
        @drag="drag"
      />
    </GoogleMap>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="closeDialog">{{ __('Cancel') }}</el-button>
        <el-button type="primary" @click="save()">
          {{ __('Confirm') }}
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script lang="ts" setup>
  import { GoogleMap, Marker } from 'vue3-google-map';
  import { reactive } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  const props = defineProps({
    proposal: {
      type: Object,
      required: true,
    },
  });
  const emits = defineEmits(['closeDialog']);
  const markerPosition = reactive({ lat: 44.439663, lng: 26.096306 });
  const drag = (e) => {
    markerPosition.lat = e.latLng.lat();
    markerPosition.lng = e.latLng.lng();
  };
  const closeDialog = () => {
    emits('closeDialog');
  };
  const save = () => {
    Inertia.patch(
      route('proposals.update.map', { proposal: props.proposal.id }),
      {
        lat: markerPosition.lat,
        lng: markerPosition.lng,
      },
      {
        onSuccess: () => {
          emits('closeDialog');
          ElMessage({
            message: 'Operation completed successfully!',
            type: 'success',
          });
          location.reload();
        },
        onError: (err) => {
          console.log(err);
        },
      }
    );
  };
  const setGMap = () => {
    const map = JSON.parse(props.proposal.map);
    markerPosition.lat = map.lat;
    markerPosition.lng = map.lng;
  };
  onMounted(() => {
    if (props.proposal.map) {
      setGMap();
    }
  });
</script>

<style lang="css">
  .full-width {
    display: block;
    width: 100%;
  }
</style>

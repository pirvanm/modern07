<template>
  <kendo-grid :config="gridConfig"></kendo-grid>
</template>
<script setup lang="ts">
  import { gridConfig } from '../configs/grid.config';
  import KendoGrid from '~views/components/kendo-grid.vue';
</script>

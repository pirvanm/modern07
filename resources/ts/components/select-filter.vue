<template>
  <div>
    <GridColumnMenuCheckboxFilter
      :column="column"
      :filter="filter"
      :filterable="filterable"
      :unique-data="true"
      :search-box="true"
      :data-items="items"
      :expanded="true"
      @filterchange="filterChange"
      @expandchange="expandChange"
      @closemenu="closeMenu"
    />
  </div>
</template>
<script>
  import { GridColumnMenuCheckboxFilter } from '@progress/kendo-vue-grid';

  export default {
    components: {
      GridColumnMenuCheckboxFilter: GridColumnMenuCheckboxFilter,
    },
    props: {
      items: { type: Array, default: () => [] },
      column: { type: Object, default: () => ({}) },
      filter: { type: Object, default: () => ({ filters: [] }) },
      filterable: Boolean,
      uniqueData: {
        type: Boolean,
        default: false,
      },
    },
    emits: ['expandchange', 'closemenu', 'filterchange'],
    methods: {
      expandChange() {
        this.$emit('expandchange');
      },
      closeMenu() {
        this.$emit('closemenu');
      },
      filterChange(newDescriptor, e) {
        this.$emit('filterchange', newDescriptor, e);
      },
    },
  };
</script>

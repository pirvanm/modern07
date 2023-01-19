<template>
  <Grid
    :style="{ height: '640px' }"
    :data-items="dataItems"
    :total="totalItems"
    :skip="defaultGridConfig.skip"
    :resizable="defaultGridConfig.resizable"
    :reorderable="defaultGridConfig.reorderable"
    :take="defaultGridConfig.take"
    :sort="defaultGridConfig.sort"
    :filter-operators="defaultGridConfig.filterOperators"
    :sortable="defaultGridConfig.sortable"
    :filter="defaultGridConfig.filter"
    :filterable="defaultGridConfig.filterable"
    :pageable="defaultGridConfig.pageable"
    :loader="loader"
    :columns="columns"
    :column-menu="defaultGridConfig.columnMenu"
    @datastatechange="handleStateChange"
    @filterchange="filterChange"
    @columnreorder="handleColumnReorder"
    @columnresize="handleColumnResize"
  >
    <template #myTemplate="{ props }">
      <select-filter
        :unique-data="false"
        :filterable="props.filterable"
        :filter="props.filter"
        :column="props.column"
        :items="dataItems"
        @closemenu="
          () => {
            props.onClosemenu();
          }
        "
        @filterchange="filterChange"
      />
    </template>
    <grid-toolbar>
      <el-button type="primary" size="default" @click="addGridDialog()">
        <i-ep-plus />
      </el-button>
      <el-button type="info" size="small" @click="resetFilters">
        <i-ant-design-clear />
      </el-button>
      <el-button type="success" size="small" @click="getData"
        ><i-ep-refresh
      /></el-button>
      <el-dropdown>
        <el-button type="info"> Hide Collumns</el-button>
        <template #dropdown>
          <el-dropdown-menu
            style="padding: 10px; display: flex; flex-direction: row"
          >
            <div
              v-for="(column, index) in columns"
              :key="index"
              style="display: flex; padding: 5px"
            >
              <el-checkbox
                :model-value="!column.hidden"
                :label="column.title"
                size="small"
                @change="handleColumnHidden(column.field, $event)"
              ></el-checkbox>
            </div>
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </grid-toolbar>
  </Grid>
</template>
<script setup lang="ts">
  import {
    Grid,
    GridColumnProps,
    GridProps,
    GridToolbar,
  } from '@progress/kendo-vue-grid';
  import { Button } from '@progress/kendo-vue-buttons';
  import { GridDefaultConfig } from '../configs/grid-default.config';
  import { IKendoConfig } from '~shared/interfaces';
  import { debounce } from 'lodash';
  import { inject, onMounted, Ref, ref } from 'vue';
  import SelectFilter from '~views/components/select-filter.vue';
  import { VueCookies } from 'vue-cookies';
  import ActionsColumnComponent from './kendo-grid-column-actions.vue';

  const componentProps = defineProps<{ config: IKendoConfig }>();
  const defaultGridConfig: GridProps = GridDefaultConfig;
  const dataItems: Ref<any[]> = ref([]);
  const totalItems: Ref<number> = ref(0);
  const loader: Ref<boolean> = ref(defaultGridConfig.loader as boolean);
  const columns: Ref<GridColumnProps[] | undefined> = ref(
    componentProps.config.columns
  );

  // so we can refresh the grid from outside
  const refreshGrid = inject('refreshGrid');
  watch(refreshGrid, () => {
    getData();
  });

  // so we can refresh the filters from outside
  const refreshGridFilters = inject('refreshGridFilters');
  watch(refreshGridFilters, () => {
      if (defaultGridConfig.filter || defaultGridConfig.sort) {
          resetFilters();
      }
  })

  // so we can have our own custom column actions if we want, otherwise use the default
  let actionsColumn = columns?.value.find(
    (column: {}) => column.title === 'Actions'
  );
  if (!actionsColumn) {
    columns?.value.push({
      cell: markRaw(ActionsColumnComponent),
      width: '210px',
      title: 'Actions',
    });
  }

  const $cookies = inject<VueCookies>('$cookies')!;

  const emit = defineEmits(['addGridDialog']);
  const addGridDialog = () => emit('addGridDialog');

  onMounted(() => {
    initColumnsSettings();
    getData();
  });

  const getData = () => {
    loader.value = true;

    const params = {
      dataSource: componentProps?.config?.dataSource,
      columns: componentProps.config.columns?.map((column) => column.field),
      skip: defaultGridConfig.skip,
      take: defaultGridConfig.take,
      sort: defaultGridConfig.sort,
    };

    if (
      defaultGridConfig?.filter &&
      defaultGridConfig.filter.filters.length > 0 &&
      Object.keys(defaultGridConfig.filter).length !== 0
    ) {
      Object.assign(params, {
        filter: defaultGridConfig.filter,
      });
    }
    fetch(
      route(componentProps?.config?.route, {
        body: JSON.stringify(params),
      })
    )
      .then((response: any) => response.json())
      .then((json: any) => {
        loader.value = false;
        dataItems.value = json.data;
        totalItems.value = json.total;
      });
  };

  const handleStateChange = (event: any) => {
    defaultGridConfig.skip = event.data.skip;
    defaultGridConfig.take = event.data.take;
    defaultGridConfig.sort = event?.data?.sort;
    getData();
  };

  const debouncedFilterChange = debounce((event) => {
    defaultGridConfig.filter = event.filter;
    getData();
  }, 1000);

  const filterChange = (event: any) => {
    debouncedFilterChange(event);
  };

  const resetFilters = () => {
    defaultGridConfig.filter = undefined;
    defaultGridConfig.sort = undefined;
    getData();
  };

  const handleColumnReorder = (options: any) => {
    storeColumnsSettings(options.columns);
  };

  const handleColumnResize = (options: any) => {
    storeColumnsSettings(options.columns);
  };

  const handleColumnHidden = (columnField: string, checked: boolean) => {
    columns.value = columns.value?.map((column: GridColumnProps) => {
      if (column.field === columnField) {
        return { ...column, hidden: !checked };
      }
      return column;
    });
    debounce(() => {
      storeColumnsSettings(columns.value!);
    }, 2000)();
  };

  const storeColumnsSettings = (columnsSettings: GridColumnProps[]): void => {
    columns.value = columnsSettings;
    const dataSource = componentProps?.config?.dataSource;
    if (dataSource) {
      $cookies.set(dataSource, { columns: columnsSettings });
    }
  };

  const initColumnsSettings = () => {
    const viewKey: string | undefined = componentProps?.config?.dataSource;
    if (viewKey) {
      try {
        const columnsOrder: GridColumnProps[] | undefined =
          $cookies.get(viewKey)?.columns;
        if (componentProps?.config?.columns?.length !== columnsOrder?.length) {
          $cookies.remove(viewKey);
          return;
        }

        const newColumnsOrder: GridColumnProps[] = [];

        columnsOrder?.forEach((cookieColumn: GridColumnProps) => {
          const gridColumn: GridColumnProps | undefined = columns.value?.find(
            (columnConfig: GridColumnProps) =>
              columnConfig.field === cookieColumn.field
          );

          if (!gridColumn) {
            return;
          }

          newColumnsOrder.push({
            ...gridColumn,
            orderIndex: cookieColumn.orderIndex,
            width: cookieColumn.width,
            hidden: cookieColumn.hidden,
          });
        });

        columns.value = newColumnsOrder;
      } catch (e) {
        console.log(e);
      }
    }
  };
</script>

import { IKendoConfig } from '~shared/interfaces'; 

import KendoGridColumnActions from '../components/kendo-grid-column-actions.vue';

export const gridConfig: IKendoConfig = {
  dataSource: 'roles',
  route: 'roles.data',
  columns: [
    {
      field: 'id',
      title: 'Id',
      filter: 'numeric',
      sortable: true,
      filterable: true,
    },
    {
      field: 'name',
      title: 'Name',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'guard_name',
      title: 'Guard Name',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'display_name',
      title: 'Display Name',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'description',
      title: 'Description',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'created_at',
      title: 'Created at',
      filter: 'date',
      sortable: true,
      filterable: true,
    },
    {
      title: 'Actions', 
      cell: markRaw(KendoGridColumnActions),
      width: '210px',
    }
  ],
};

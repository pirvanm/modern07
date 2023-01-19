import { IKendoConfig } from '~shared/interfaces';

import KendoGridColumnActions from '../components/users/kendo-grid-column-actions.vue';

export const gridConfig: IKendoConfig = {
  dataSource: 'users',
  route: 'users.data',
  columns: [
    {
      field: 'id',
      title: 'Id',
      filter: 'numeric',
      sortable: true,
      filterable: true,
    },
    /*{
          field: 'userable_type',
          title: 'Type',
          filter: 'text',
          sortable: true,
          filterable: true,
        },*/
    {
      field: 'name',
      title: 'Nume',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'email',
      title: 'Email',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'roles.display_name',
      title: 'Role',
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
    },
  ],
};

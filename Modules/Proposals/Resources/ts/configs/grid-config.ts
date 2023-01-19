import { IKendoConfig } from '~shared/interfaces';
import KendoGridColumnActions from '../components/kendo-grid-column-actions.vue';

export const gridConfig: IKendoConfig = {
  dataSource: 'proposals',
  route: 'proposals.data',
  columns: [
    {
      field: 'id',
      title: 'Id',
      filter: 'numeric',
      type: 'numeric',
      sortable: true,
      filterable: true,
    },
    {
      field: 'counties.name',
      title: 'Judet',
      filter: 'text',
      type: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'cities.name',
      title: 'Oras',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'users.name',
      title: 'Utilizator',
      filter: 'text',
      type: 'text',
      sortable: true,
      filterable: true,
    },
    /*{
          field: 'code',
          title: 'Cod',
          filter: 'text',
          type: 'text',
        },*/
    /*{
          field: 'type',
          title: 'Tip',
          filter: 'text',
          type: 'text',
          sortable: true,
          filterable: true,
        },*/
    {
      field: 'status',
      title: 'Status',
      filter: 'date',
      type: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'created_at',
      title: 'Creat La',
      filter: 'date',
      type: 'date',
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

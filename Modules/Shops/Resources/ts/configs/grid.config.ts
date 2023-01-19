import { IKendoConfig } from '~shared/interfaces';

export const gridConfig: IKendoConfig = {
  dataSource: 'shops',
  columns: [
    {
      field: 'id',
      title: 'Id',
      filter: 'numeric',
      type: 'numeric',
    },
    {
      field: 'code',
      title: 'Cod',
      filter: 'text',
      type: 'text',
    },
    {
      field: 'type',
      title: 'Tip',
      filter: 'text',
      columnMenu: 'myTemplate',
    },
    {
      field: 'status',
      title: 'Status',
      filter: 'text',
      type: 'text',
    },
    /*{
      field: 'slots_priority',
      title: 'Prioritate sloturi',
      filter: 'text',
      type: 'text',
    },*/
    {
      field: 'slots_types',
      title: 'Tip Slots',
      filter: 'text',
      type: 'text',
    },
    {
      field: 'opened_at',
      title: 'Deschisa La',
      filter: 'date',
      type: 'date',
    },
    {
      field: 'closed_at',
      title: 'Inchisa La',
      filter: 'date',
      type: 'date',
    },
    {
      field: 'created_at',
      title: 'Creat La',
      filter: 'date',
      type: 'date',
    },
    {
      field: 'updated_at',
      title: 'Modificat La',
      filter: 'date',
      type: 'date',
    },
  ],
};

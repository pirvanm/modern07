import { IKendoConfig } from '~shared/interfaces';

export const gridConfig: IKendoConfig = {
  dataSource: 'proposals',
  route: 'openings.data',
  columns: [
    {
      field: 'id',
      title: 'Id',
      filter: 'numeric',
      type: 'numeric',
    },
    {
      field: 'status',
      title: 'Status',
      filter: 'date',
      type: 'text',
    },
    {
      field: 'created_at',
      title: 'Creat La',
      filter: 'date',
      type: 'date',
    },
  ],
};

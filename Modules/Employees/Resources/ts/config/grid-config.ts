import { IKendoConfig } from '~shared/interfaces';

export const gridConfig: IKendoConfig = {
  dataSource: 'employee',
  columns: [
    {
      field: 'id',
      title: 'Id',
      filter: 'numeric',
      type: 'numeric',
    },
    {
      field: 'fname',
      title: 'Nume',
      filter: 'text',
      type: 'text',
    },
    {
      field: 'lname',
      title: 'Prenume',
      filter: 'text',
      columnMenu: 'text',
    },
    {
      field: 'created_at',
      title: 'Creat La',
      filter: 'date',
      type: 'date',
    },
  ],
};

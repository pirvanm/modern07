import { IKendoConfig } from '~shared/interfaces'; 


export const gridConfig: IKendoConfig = {
  dataSource: 'permissions',
  route: 'permissions.data',
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
   
  ],
};

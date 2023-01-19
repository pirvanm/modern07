import { IKendoConfig } from '~shared/interfaces'; 

export const gridConfig: IKendoConfig = {
  dataSource: 'companies',
  route: 'companies.data',
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
      field: 'cui',
      title: 'CUI',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
      field: 'reg',
      title: 'Registration',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
        field: 'phone',
        title: 'Phone',
        filter: 'text',
        sortable: true,
        filterable: true,
    },
    {
        field: 'city.name',
        title: 'City',
        filter: 'text',
        sortable: true,
        filterable: true,
    },
    {
        field: 'type',
        title: 'Type',
        filter: 'text',
        sortable: true,
        filterable: true,
    },
    {
        field: 'status',
        title: 'Status',
        filter: 'text',
        sortable: true,
        filterable: true,
    },
    { cell: 'myTemplateActions', width: '210px' }
  ],
};

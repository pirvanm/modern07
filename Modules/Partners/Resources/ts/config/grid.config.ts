import { IKendoConfig } from '~shared/interfaces';

export const gridConfig: IKendoConfig = {
  dataSource: 'partners',
  route: 'partners.data',
  columns: [
    {
      field: 'id',
      title: 'Id',
      filter: 'numeric',
      sortable: true,
      filterable: true,
    },
    {
      field: 'fullName',
      title: 'Name',
      filter: 'text',
      sortable: true,
      filterable: true,
    },
    {
        field: 'company.name',
        title: 'Company',
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
        field: 'email',
        title: 'Email',
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
    {
      field: 'created_at',
      title: 'Created At',
      filter: 'date',
      sortable: true,
      filterable: true,
    },
  ],
};
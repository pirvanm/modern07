import { GridColumnProps } from '@progress/kendo-vue-grid/dist/npm/interfaces/GridColumnProps';
import { Ref } from 'vue';

export interface IKendoConfig {
  dataSource?: string;
  route?: string;
  columns?: GridColumnProps[];
  take?: number; //defaults to 15
  skip?: number;
  gridData?: Ref<[]>;
  filter?: Record<string, unknown>;
  loader?: Ref<boolean>;
  pageable?: boolean; //defaults to true
  sortable?: boolean; //defaults to true
  filterable?: boolean; //defaults to true
}

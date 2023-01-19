import { IAppRouteItem } from './app-route-item.interface';

export interface IMenuItem {
  label: string;
  index: string;
  icon?: any;
  route: IAppRouteItem;
}

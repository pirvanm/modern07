import { IMenuItem } from '~shared/interfaces/menu-item.interface';

export const leftSidebarMenuItems: IMenuItem[] = [
  {
    label: 'Dashboard',
    icon: 'icon',
    index: '1',
    route: {
      path: '/dashboard',
      fullPath: '/dashboard',
      name: 'Dashboard',
      meta: {
        title: 'Dashboard',
      },
    },
  },
  {
    label: 'Permissions',
    icon: 'icon',
    index: '2',
    route: {
      path: '/permissions',
      fullPath: '/permissions',
      name: 'Permissions',
      meta: {
        title: 'Permissions',
      },
    },
  },
];

import { usePage } from '@inertiajs/inertia-vue3';

export default function usePermissions() {
  const props = usePage().props.value;
  const permissions: Array<string> = props.permissions as Array<string>;

  const can = (permissionName: string): boolean => {
    return permissions.indexOf(permissionName) !== -1;
  };

  const canAny = (permissionsArray: string | Array<string>): boolean => {
    if (!Array.isArray(permissionsArray)) {
      permissionsArray = [permissionsArray];
    }

    for (const permission of permissionsArray) {
      if (can(permission)) {
        return true;
      }
    }

    return false;
  };

  return {
    can,
    canAny,
  };
}

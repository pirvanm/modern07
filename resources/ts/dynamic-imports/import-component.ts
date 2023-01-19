import buildPath from './build-path';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

export default async function importComponent(name: string): Promise<any> {
  // we can use the following syntax directory.component because of replacement
  // this helps consistency and code structuring
  // ex: pages.header
  if (/[.]/.test(name)) {
    name = name.replace(/\./g, '/');
  }

  // split path in order to reference laravel modules .vue files
  const pathSegments = name.split('::');
  const paths = buildPath(pathSegments);
  let metaGlobPages: Record<string, any>;
  switch (paths.globPath) {
    case 'Modules':
      metaGlobPages = import.meta.glob('#modules/**/Resources/**/*.vue');
      break;
    case 'Root':
      metaGlobPages = import.meta.glob('~views/**/*.vue');
      break;
  }

  // @ts-ignore
  delete paths.globPath;
  const regexVariables = Object.values(paths).map(
    (variable) => `(?=.*\\b${variable}\\b)`
  );
  const regex = new RegExp(`^${regexVariables.join('')}.+`, 'i');
  // @ts-ignore
  const componentPath = Object.keys(metaGlobPages).find((entry) => {
    return regex.test(entry);
  });

  if (!componentPath) {
    throw new Error(`Unable to find component ${name}`);
  }

  return resolvePageComponent(componentPath, metaGlobPages!);
}

function lowerCaseComponent(pathSegment: string): string {
  return pathSegment.toLowerCase();
}

export default function buildPath(pathSegments: string[]) {
  try {
    // All referenced .vue files should respect kebab-case convention
    // All reference laravel modules should have a title case name
    // ex: car.vue ; car-platform.vue
    if (pathSegments.length > 1) {
      // If module specified then find module in /Modules and get .vue component
      const [module, component] = pathSegments;
      const componentPath = `${lowerCaseComponent(component)}.vue`;
      return {
        globPath: `Modules`,
        componentPath: componentPath,
        modulePath: module,
      };
    } else {
      // Get root component instead
      const componentPath = `${lowerCaseComponent(pathSegments[0])}.vue`;
      return {
        globPath: `Root`,
        componentPath: componentPath,
      };
    }
  } catch (e) {
    //Throw exception if there is no such module;
    throw new Error('Undefined module name or component name');
  }
}

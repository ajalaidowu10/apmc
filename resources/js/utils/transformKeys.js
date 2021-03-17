import { camelCase, snakeCase } from 'lodash';

function isNonArrayObject(value) {
  const type = typeof value;
  const nonObjectTypes = [
    'string',
    'number',
    'boolean',
    'function',
    'undefined',
  ];
  return (
    value !== null &&
    !nonObjectTypes.includes(type) &&
    !Array.isArray(value) &&
    type === 'object'
  );
}

function recurse(object, transform) {
  if (Array.isArray(object)) {
    return object.map(arrayItem => recurse(arrayItem, transform));
  }

  if (!isNonArrayObject(object)) {
    return object;
  }

  const keys = Object.keys(object);

  const transformedObject = {};

  keys.map(key => {
    const newKey = transform(key);
    const value = object[key];
    transformedObject[newKey] = recurse(value, transform);
  });

  return transformedObject;
}

export default {
  camelCase(object) {
    return recurse(object, camelCase);
  },

  snakeCase(object) {
    return recurse(object, snakeCase);
  },
};

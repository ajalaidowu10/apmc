import transformKeys from './transformKeys';

async function catchApiCallError(procedure) {
  try {
    const result = await procedure();

    return transformKeys.camelCase(result);
  } catch (ex) {
    if (!ex.response) {
      throw ex;
    }

    const error = new Error(ex.response.data.message);
    error.status = ex.response.status;
    throw error;
  }
}

export default catchApiCallError;

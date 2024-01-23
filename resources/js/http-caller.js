import axios from "axios";
import { isEmpty, merge } from "lodash";

const createHeaders = (settings) => {
    const defaultHeaders = {
        /*Authorization: `Bearer ${accessToken}`*/
    };
    if (isEmpty(settings.headers)) {
      return { ...defaultHeaders };
    }
    return merge({}, defaultHeaders, settings.headers);
};
  
const createConfig = (url, method, params, settings) => {
    const { isQueryString = false, cancelToken = false } = settings;
    const defaultConfig = {
      url,
      method,
      cancelToken,
      timeout: 1000 * 120, // Wait for 120 seconds
      headers: createHeaders(settings)
    };
  
    switch (method) {
      case "GET":
        return {
          ...defaultConfig,
          params,
          paramsSerializer: (params) =>
            isQueryString ? qs.stringify(params, { encode: false }) : null
        };
      case "POST":
        return {
          ...defaultConfig,
          data: params
        };
      case "DELETE":
        return {
          ...defaultConfig,
          params
        };
      case "PUT":
        return {
          ...defaultConfig,
          data: params
        };
      case "PATCH":
        return {
          ...defaultConfig,
          data: params,
          params
        };
  
      default:
        return defaultConfig;
    }
  };
  
const http = async (url, method, params, settings = {}) => {
    const res = await axios(createConfig(url, method, params, settings));
    return res;
};
  
export default http;
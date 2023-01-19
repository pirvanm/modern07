import axios from 'axios';
import { ICity } from '~shared/interfaces/settlements/city.interface';
import { ICounty } from '~shared/interfaces/settlements/county.interface';

const apiEndpoint = `/api`;
export default {
  getStreetTypes(): Promise<{ id: number; name: string }[]> {
    const url = `${apiEndpoint}/getStreetTypes`;
    return axios.get(url).then(
      (resp) => resp.data,
      () => []
    );
  },

  getCities(): Promise<ICity[]> {
    const url = `${apiEndpoint}/getCities`;
    return axios.get(url).then(
      (resp) => resp.data,
      () => []
    );
  },

  getCounties(): Promise<ICounty[]> {
    const url = `${apiEndpoint}/getCounties`;
    return axios.get(url).then(
      (resp) => resp.data,
      () => []
    );
  },

  getCitiesByCountyId(id: number): Promise<ICity[]> {
    const url = `${apiEndpoint}/getCitiesByCountyId/${id}`;
    return axios.get(url).then(
      (resp) => resp.data,
      () => []
    );
  },

  getCountyById(id: number): Promise<ICounty[]> {
    const url = `${apiEndpoint}/getCountyById/${id}`;
    return axios.get(url).then(
      (resp) => resp.data,
      () => []
    );
  },

  getCityById(id: number): Promise<ICity> {
    const url = `${apiEndpoint}/getCityById/${id}`;
    return axios.get(url).then(
      (resp) => resp.data,
      () => []
    );
  },
};

import { ICity } from './settlement/city.interface';
import { IAddress } from '../address.interface';
import { IRent } from './rent.interface';
import { IOwner } from "./owner.interface";
import { ISpace } from './space.interface';

export interface IProposal {
  id: number | null;
  city: ICity | null;
  note: string | null;
  city_id: number | null;
  address: IAddress | null;
  rent: IRent | null;
}

import { IRole } from './role.interface';

export interface IUser {
  id: string;
  email: string;
  name: string;
  password: string;
  role: IRole,
  created_at: string;
  updated_at: string;
}

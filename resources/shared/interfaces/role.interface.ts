import { IPermission } from "./permission.interface";

export interface IRole {
    id: string;
    display_name: string | null;
    guard_name: string;
    name: string;
    description: string | null;
    permissions: IPermission[] | null;
}
import { defineStore } from 'pinia';
import axios from 'axios';

export const useGridDialog = defineStore("gridDialog", {
    state: () => ({
        dialogGrid: false as boolean,
    }),
    getters: {
        getDialogGrid(state: { dialogGrid: boolean}) {
            return state.dialogGrid;
        },
        getDialogDeleteGrid(state: { dialogGrid: boolean}) {
            return state.dialogGrid;
        }
    },
    actions: {
        setDialogGrid(visible: boolean) {
            this.dialogGrid = visible;
        },  
    }
    },
})
import { defineStore } from 'pinia';

export const useSidebarCollapse = defineStore('sidebarCollapse', {
    state: () => ({
        closed: true,
    }),

    getters: {
        getClosed: (state: { closed: boolean }) => state.closed,
    },

    actions: {
        switch() {
            this.closed = !this.closed;
        },
    },
});

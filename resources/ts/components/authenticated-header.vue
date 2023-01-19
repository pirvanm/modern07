<template>
    <div id="header" class="">
        <div class="menu-icon">
            <el-icon :color="'rgb(64, 158, 255)'" @click="toggle">
                <i-ant-design-menu-unfold-outlined />
            </el-icon>
        </div>
        <div id="left-menu">
            <LanguageSelector />
            <el-dropdown>
                <el-button type="primary">
                    <i-ep-avatar />

                    <p style="margin: 0 10px">
                        {{ $page?.props?.auth?.user?.name }}
                    </p>

                    <div
                        style="
              margin: 0 10px;
              width: 2px;
              height: 20px;
              background-color: white;
            "
                    ></div>
                    <i-ep-arrow-down-bold />
                </el-button>

                <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item>Profile</el-dropdown-item>
                        <el-dropdown-item @click="logout">Logout</el-dropdown-item>
                    </el-dropdown-menu>
                </template>
            </el-dropdown>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia';
import { useSidebarCollapse } from '../stores/sidebar';
import { usePage } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from 'vue';
import { IUser } from '~shared/interfaces';

import LanguageSelector from './language-selector.vue';

const user = ref({ name: '', email: '' });
onMounted(() => {
    const auth = usePage().props.value.auth as { user: IUser };
    if (auth && auth.user) {
        user.value = auth.user;
    }
});

const sidebarCollapse = useSidebarCollapse();
const toggle = () => {
    sidebarCollapse.switch();
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<style scoped lang="scss">
#header {
    width: 100%;
    min-height: 50px;
    padding: 5px 0;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.menu-icon {
    font-size: 25px;
    cursor: pointer;
}

#left-menu {
    display: flex;
    align-items: center;
    gap: 1rem;
}
</style>

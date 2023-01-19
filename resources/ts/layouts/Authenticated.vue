<template>
  <div
    v-loading="!user"
    class="common-layout"
    element-loading-text="loading user.."
    element-loading-background="white"
  >
    <el-container
      style="min-height: 100vh"
      :class="sidebarCollapse.closed ? 'sidebarClosed' : 'sidebarOpen'"
    >
      <el-aside class="sidebar">
        <left-sidebar-menu :is-collapse="true"></left-sidebar-menu>
      </el-aside>
      <el-container class="main-container">
        <el-header style="height: 56px">
          <intranet-header></intranet-header>
        </el-header>
        <el-main>
          <slot />
        </el-main>
      </el-container>
    </el-container>
  </div>
</template>

<script setup lang="ts">
  import IntranetHeader from '~views/components/authenticated-header.vue';
  import LeftSidebarMenu from '~views/components/left-sidebar-menu.vue';
  import { useSidebarCollapse } from '../stores/';
  import { onMounted, ref } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  import { Store } from 'pinia';
  import { IUser } from '~shared/interfaces';

  const user = ref({ name: '', email: '' });
  onMounted(() => {
    const auth = usePage().props.value.auth as { user: IUser };
    if (auth && auth.user) {
      user.value = auth.user;
    }
  });

  const sidebarCollapse: Store<'sidebarCollapse', { closed: boolean }> =
    useSidebarCollapse();
</script>

<style lang="scss">
  html,
  body,
  #app {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    font-size: 18px !important;
  }

  .sidebar {
    -webkit-transition: width 0.28s;
    transition: width 0.28s;
    width: 250px !important;
    height: 100%;
    position: fixed;
    font-size: 0;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 1001;
    overflow: hidden !important;
  }

  .main-container {
    min-height: 100%;
    -webkit-transition: margin-left 0.28s;
    transition: margin-left 0.28s;
    margin-left: 250px;
    position: relative;
    width: 100%;
  }

  .sidebarClosed .main-container {
    margin-left: 64px !important;
  }

  .sidebarClosed .el-aside {
    width: 64px !important;
  }

  .sidebarOpen .menu-icon svg {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }
  .el-header {
    box-shadow: 0 1px 4px rgb(0 21 41 / 8%);
  }
</style>

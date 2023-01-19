<template>
  <el-menu
    default-active="1"
    style="min-height: 100%"
    :collapse="sidebarCollapsedState.closed"
    :router="true"
  >
    <el-menu-item index="1" @click="goToRoute('dashboard')">
      <el-icon>
        <icon-menu />
      </el-icon>
      <template #title>Dashboard</template>
    </el-menu-item>
    <el-sub-menu index="2">
      <template #title>
        <el-icon>
          <setting />
        </el-icon>
        <span>Admin</span>
      </template>
      <el-menu-item-group>
        <template #title><span>Admin Dashboard</span></template>
        <el-menu-item
          v-if="canAny(['users_index'])"
          index="2-1"
          @click="goToRoute('users.index')"
          >Users
        </el-menu-item>
        <el-menu-item
          v-if="canAny(['roles_index'])"
          index="2-2"
          @click="goToRoute('roles.index')"
          >Roles
        </el-menu-item>
        <el-menu-item
          v-if="canAny(['permisions_index'])"
          index="2-3"
          @click="goToRoute('permissions.index')"
          >Permissions
        </el-menu-item>
      </el-menu-item-group>
      <el-menu-item-group title="Group Two">
        <template #title><span>Debug</span></template>
        <el-menu-item index="2-3">Logs</el-menu-item>
      </el-menu-item-group>
    </el-sub-menu>
    <el-sub-menu index="3">
      <template #title>
        <el-icon>
          <flag />
        </el-icon>
        <span>Cities</span>
      </template>
      <el-menu-item-group>
        <template #title><span>Cities</span></template>
        <el-menu-item index="3-1" @click="goToRoute('cities.index')"
          >Cities
        </el-menu-item>
      </el-menu-item-group>
    </el-sub-menu>
    <el-sub-menu index="4">
      <template #title>
        <el-icon>
          <briefcase />
        </el-icon>
        <span>Companies</span>
      </template>
      <el-menu-item-group>
        <template #title><span>Companies</span></template>
        <el-menu-item index="4-1" @click="goToRoute('companies.index')"
          >Companies
        </el-menu-item>
      </el-menu-item-group>
      <el-menu-item-group>
        <template #title><span>Partners</span></template>
        <el-menu-item index="4-2" @click="goToRoute('partners.index')"
          >Partners
        </el-menu-item>
      </el-menu-item-group>
    </el-sub-menu>
    <el-sub-menu index="5">
      <template #title>
        <el-icon>
          <i-ep-management />
        </el-icon>
        <span>Operational</span>
      </template>
      <el-menu-item-group>
        <template #title><span>Retail</span></template>
        <el-menu-item
          v-if="canAny('proposals_index')"
          index="5-1"
          @click="goToRoute('proposals.index')"
          >Proposals
        </el-menu-item>
        <el-menu-item
          v-if="canAny(['opens_index'])"
          index="5-2"
          @click="goToRoute('openings.index')"
          >Openings
        </el-menu-item>
        <el-menu-item
          v-if="canAny(['shops_index'])"
          index="5-3"
          @click="goToRoute('shops.index')"
          >Shops
        </el-menu-item>
      </el-menu-item-group>
    </el-sub-menu>
  </el-menu>
</template>
<script setup lang="ts">
  import { useSidebarCollapse } from '../stores/sidebar';
  import {
    Menu as IconMenu,
    Setting,
    Flag,
    Briefcase,
  } from '@element-plus/icons-vue';
  import { Store } from 'pinia';
  import { Inertia } from '@inertiajs/inertia';
  import usePermissions from '~views/composables/usePermissions';

  const { can, canAny } = usePermissions();

  const sidebarCollapsedState: Store<'sidebarCollapse', { closed: boolean }> =
    useSidebarCollapse();

  const goToRoute = (aliasPath: string) => {
    Inertia.visit(route(aliasPath));
  };
</script>
<style>
  .el-menu .el-image {
    padding: 7px;
    margin: 10px 0;
    -webkit-transition: padding, height 0.28s;
    transition: padding, height 0.28s;
  }

  .sidebarOpen .el-menu .el-image {
    -webkit-transition: padding, height 0.28s;
    transition: padding, height 0.28s;
  }
</style>

<script setup lang="ts">
  import GuestHeader from '~views/components/guest-header.vue';
</script>

<template>
  <el-container>
    <el-header>
      <guest-header></guest-header>
    </el-header>
    <el-main>
      <slot />
    </el-main>
  </el-container>
</template>

<style lang="sass">
  @import "~element-plus/theme-chalk/src/index.scss"
  html, body, #app
      margin: 0
      padding: 0
      height: 100%
      width: 100%
</style>

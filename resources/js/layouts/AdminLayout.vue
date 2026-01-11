<script setup lang="ts">
import AdminSidebar from '@/components/admin/AdminSidebar.vue'
import AdminHeader from '@/components/admin/AdminHeader.vue'
import AdminFooter from '@/components/admin/AdminFooter.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-50 flex">
    <AdminSidebar />
    <div class="flex-1 flex flex-col">
      <AdminHeader />
      <main class="flex-1 p-6">
        <slot />
      </main>
      <AdminFooter />
    </div>
  </div>
</template>

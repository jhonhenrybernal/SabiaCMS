<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
const page = usePage()
</script>

<template>
  <header class="h-14 bg-white border-b flex items-center justify-between px-6">
    <div class="text-sm text-gray-600">
      Panel Administrativo
    </div>

    <div class="text-sm text-gray-700">
      {{ (page.props.auth as any)?.user?.name }}
    </div>
  </header>
</template>

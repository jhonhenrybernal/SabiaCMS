<script setup lang="ts">
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const isAdmin = computed(() => Boolean((page.props.auth as any)?.user?.is_admin))

const nav = [
  { label: 'Dashboard', href: '/admin' },
  { label: 'Mensajes', href: '/admin/messages' },
  { label: 'SEO', href: '/admin/seo' },
  { label: 'Robots', href: '/admin/robots' },
  { label: 'Sitemap', href: '/admin/sitemap' },
  { label: 'Telescope', href: '/admin/telescope' },
]
</script>

<template>
  <aside class="w-64 border-r bg-white flex flex-col">
    <div class="px-4 py-4 border-b">
      <div class="text-sm font-semibold">{{ $page.props.name }}</div>
      <div class="text-xs text-gray-500">Admin</div>
    </div>

    <nav class="p-2 space-y-1 flex-1">
      <a
        v-for="item in nav"
        :key="item.href"
        :href="item.href"
        class="block rounded px-3 py-2 text-sm hover:bg-gray-100"
      >
        {{ item.label }}
      </a>
    </nav>

    <div class="p-3 border-t text-xs text-gray-500" v-if="!isAdmin">
      No eres admin.
    </div>
  </aside>
</template>

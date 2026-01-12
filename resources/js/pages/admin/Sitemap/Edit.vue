<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps<{
  publicUrl: string
  isCached: boolean
}>()

const regenerate = () => {
  router.post('/admin/sitemap/regenerate', {}, { preserveScroll: true })
}
</script>

<template>
  <AdminLayout>
    <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
    <div class="flex flex-col gap-2">
      <h1 class="text-xl font-semibold">Sitemap</h1>

      <div class="rounded-md border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900">
        <strong>¿Qué es este panel?</strong><br />
        El sitemap (<code>sitemap.xml</code>) le indica a los motores de búsqueda qué URLs existen
        en tu sitio para rastrearlas e indexarlas más rápido.
        <br /><br />
        Este sitemap es <strong>dinámico</strong> y se <strong>cachea</strong> para performance.
        Si publicas nuevas secciones o cambias URLs, usa <strong>Regenerar</strong>.
      </div>

      <div class="mt-4 rounded-lg border bg-white p-4">
        <div class="text-sm font-medium text-gray-700">URL pública</div>
        <a :href="props.publicUrl" target="_blank" class="underline text-sm">
          {{ props.publicUrl }}
        </a>

        <div class="mt-2 text-xs text-gray-600">
          Estado de caché:
          <span class="rounded px-2 py-1 text-xs"
                :class="props.isCached ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
            {{ props.isCached ? 'CACHED' : 'NO CACHE' }}
          </span>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
          <a
            :href="props.publicUrl"
            target="_blank"
            class="rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:opacity-90"
          >
            Abrir sitemap
          </a>

          <button
            type="button"
            class="rounded-md border px-4 py-2 text-sm hover:bg-gray-50"
            @click="regenerate"
          >
            Regenerar (limpiar caché)
          </button>
        </div>

        <p class="mt-3 text-xs text-gray-500">
          Tip: también debes declarar esta URL en <code>robots.txt</code>.
        </p>
      </div>
    </div>
    </div>
  </AdminLayout>
</template>

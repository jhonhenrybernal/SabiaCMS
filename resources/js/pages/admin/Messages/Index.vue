<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

type Message = {
  id: number
  content: string
  author: string | null
  language: string
  source: string | null
  created_at: string
}

type Pagination<T> = {
  data: T[]
  links: { url: string | null; label: string; active: boolean }[]
}

const props = defineProps<{
  messages: Pagination<Message>
  filters: { q: string; language: string }
}>()

const form = reactive({
  q: props.filters.q ?? '',
  language: props.filters.language ?? '',
})

const applyFilters = () => {
  router.get(
    '/admin/messages',
    { ...form },
    { preserveState: true, preserveScroll: true, replace: true }
  )
}

const clearFilters = () => {
  form.q = ''
  form.language = ''
  applyFilters()
}

const excerpt = (text: string, n = 140) => (text.length > n ? text.slice(0, n) + '…' : text)

const removeMessage = (id: number) => {
  if (!confirm('¿Eliminar este mensaje?')) return
  router.delete(`/admin/messages/${id}`, { preserveScroll: true })
}
</script>

<template>
  <AdminLayout>
    <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <div>
        <h1 class="text-xl font-semibold">Mensajes</h1>
        <p class="text-sm text-gray-600">CRUD + búsqueda + filtro por idioma + paginación.</p>
      </div>

      <Link
        href="/admin/messages/create"
        class="inline-flex items-center justify-center rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:opacity-90"
      >
        Nuevo mensaje
      </Link>
    </div>

    <!-- Filtros -->
    <div class="mt-6 rounded-lg border bg-white p-4">
      <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
        <input
          v-model="form.q"
          type="text"
          placeholder="Buscar contenido, autor o fuente…"
          class="w-full rounded-md border px-3 py-2 text-sm"
          @keyup.enter="applyFilters"
        />

        <select v-model="form.language" class="w-full rounded-md border px-3 py-2 text-sm">
          <option value="">Todos los idiomas</option>
          <option value="es">Español</option>
          <option value="en">Inglés</option>
          <option value="fr">Francés</option>
          <option value="it">Italiano</option>
        </select>

        <div class="flex gap-2">
          <button
            type="button"
            class="w-full rounded-md bg-black px-3 py-2 text-sm font-medium text-white hover:opacity-90"
            @click="applyFilters"
          >
            Aplicar
          </button>
          <button
            type="button"
            class="w-full rounded-md border px-3 py-2 text-sm hover:bg-gray-50"
            @click="clearFilters"
          >
            Limpiar
          </button>
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <div class="mt-6 overflow-hidden rounded-lg border bg-white">
      <table class="w-full text-left text-sm">
        <thead class="border-b bg-gray-50 text-xs uppercase text-gray-600">
          <tr>
            <th class="px-4 py-3">Mensaje</th>
            <th class="px-4 py-3">Autor</th>
            <th class="px-4 py-3">Idioma</th>
            <th class="px-4 py-3">Fuente</th>
            <th class="px-4 py-3 text-right">Acciones</th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="!messages.data.length">
            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No hay mensajes.</td>
          </tr>

          <tr v-for="m in messages.data" :key="m.id" class="border-b last:border-b-0">
            <td class="px-4 py-3 align-top">
              <div class="font-medium text-gray-900">{{ excerpt(m.content) }}</div>
            </td>

            <td class="px-4 py-3 align-top">
              <span class="text-gray-800">{{ m.author ?? '—' }}</span>
            </td>

            <td class="px-4 py-3 align-top">
              <span class="rounded bg-gray-100 px-2 py-1 text-xs">
                {{ m.language.toUpperCase() }}
              </span>
            </td>

            <td class="px-4 py-3 align-top">
              <span class="text-gray-700">{{ m.source ?? '—' }}</span>
            </td>

            <td class="px-4 py-3 align-top text-right">
              <Link
                :href="`/admin/messages/${m.id}/edit`"
                class="rounded-md border px-3 py-1.5 text-sm hover:bg-gray-50"
              >
                Editar
              </Link>

              <button
                type="button"
                class="ml-2 rounded-md border border-red-300 px-3 py-1.5 text-sm text-red-700 hover:bg-red-50"
                @click="removeMessage(m.id)"
              >
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginación -->
      <div class="flex flex-wrap gap-2 border-t p-3">
        <Link
          v-for="l in messages.links"
          :key="l.label"
          :href="l.url ?? ''"
          class="rounded-md border px-3 py-1.5 text-sm"
          :class="l.active ? 'bg-black text-white border-black' : 'hover:bg-gray-50'"
          v-html="l.label"
          :disabled="!l.url"
        />
      </div>
    </div>
    </div>
  </AdminLayout>
</template>

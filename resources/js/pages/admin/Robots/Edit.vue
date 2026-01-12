<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps<{
  robots: string
  publicUrl: string
}>()

const form = useForm({
  robots: props.robots,
})

const save = () => form.post('/admin/robots')

const resetDefault = () => {
  if (!confirm('¿Restaurar robots.txt a los valores por defecto?')) return
  form.post('/admin/robots/reset', { preserveScroll: true })
}

// ✅ No uses new URL() en template
const siteOrigin = window.location.origin
</script>

<template>
  <AdminLayout>
    <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <div>
        <h1 class="text-xl font-semibold">Robots.txt</h1>
        <div class="mt-2 rounded-md border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900">
          <strong>¿Qué es este panel?</strong><br />
          Desde aquí puedes configurar el archivo <code>robots.txt</code>, el cual
          indica a los motores de búsqueda qué partes del sitio pueden rastrear e indexar.
          <br /><br />
          Es recomendable:
          <ul class="ml-4 list-disc">
            <li>Bloquear rutas privadas como <code>/admin</code> o <code>/login</code></li>
            <li>Declarar siempre la URL del <code>sitemap.xml</code></li>
            <li>No usar robots.txt como mecanismo de seguridad</li>
          </ul>
        </div>
        <p class="text-sm text-gray-600">
          Edita el contenido de
          <a :href="publicUrl" class="underline" target="_blank">{{ publicUrl }}</a>
        </p>
      </div>

      <div class="flex gap-2">
        <button
          type="button"
          class="rounded-md border px-4 py-2 text-sm hover:bg-gray-50"
          @click="resetDefault"
          :disabled="form.processing"
        >
          Restaurar
        </button>

        <button
          type="button"
          class="rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:opacity-90"
          @click="save"
          :disabled="form.processing"
        >
          Guardar
        </button>
      </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="rounded-lg border bg-white p-4">
        <h2 class="mb-3 text-sm font-medium text-gray-700">Contenido</h2>

        <textarea
          v-model="form.robots"
          rows="18"
          class="w-full rounded-md border px-3 py-2 font-mono text-sm"
          spellcheck="false"
        />

        <div v-if="form.errors.robots" class="mt-2 text-xs text-red-600">
          {{ form.errors.robots }}
        </div>

        <p class="mt-2 text-xs text-gray-500">
          Tip: agrega siempre la línea
          <code class="font-mono">Sitemap: {{ siteOrigin }}/sitemap.xml</code>
        </p>
      </div>

      <div class="rounded-lg border bg-white p-4">
        <h2 class="mb-3 text-sm font-medium text-gray-700">Vista previa</h2>
        <pre class="whitespace-pre-wrap rounded-md bg-gray-50 p-3 text-sm">{{ form.robots }}</pre>

        <div class="mt-4 rounded-md border bg-gray-50 p-3 text-sm">
          <div class="font-medium">Acceso público:</div>
          <a :href="publicUrl" class="underline" target="_blank">{{ publicUrl }}</a>
        </div>
      </div>
    </div>
    </div>
  </AdminLayout>
</template>

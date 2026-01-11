<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps<{
  adsense: {
    enabled: boolean
    client: string
    slot_default: string
  }
}>()

const form = useForm({
  enabled: props.adsense.enabled,
  client: props.adsense.client ?? '',
  slot_default: props.adsense.slot_default ?? '',
})

const save = () => form.post('/admin/adsense')
</script>

<template>
  <AdminLayout>
    <div class="flex flex-col gap-2">
      <h1 class="text-xl font-semibold">Google AdSense</h1>

      <div class="rounded-md border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900">
        <strong>¿Qué es este panel?</strong><br />
        Administra la monetización del sitio con Google AdSense.
        Aquí puedes activar/desactivar AdSense globalmente, configurar tu <code>ca-pub</code> y un slot por defecto.
        <br /><br />
        <strong>Importante:</strong> si desactivas AdSense, el script no se carga en el sitio (OFF real).
      </div>

      <div class="mt-4 rounded-lg border bg-white p-4">
        <div class="flex items-center justify-between">
          <div>
            <div class="text-sm font-medium text-gray-700">Activar AdSense global</div>
            <div class="text-xs text-gray-500">Aplica para TODO el sitio.</div>
          </div>

          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" v-model="form.enabled" />
            <span>{{ form.enabled ? 'Activo' : 'Desactivado' }}</span>
          </label>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="text-sm font-medium">Publisher ID (data-ad-client)</label>
            <input
              v-model="form.client"
              class="mt-1 w-full rounded-md border px-3 py-2 text-sm"
              placeholder="ca-pub-1234567890"
              :disabled="!form.enabled"
            />
            <div v-if="form.errors.client" class="mt-1 text-xs text-red-600">{{ form.errors.client }}</div>
          </div>

          <div>
            <label class="text-sm font-medium">Slot por defecto (data-ad-slot)</label>
            <input
              v-model="form.slot_default"
              class="mt-1 w-full rounded-md border px-3 py-2 text-sm"
              placeholder="1234567890"
              :disabled="!form.enabled"
            />
            <div v-if="form.errors.slot_default" class="mt-1 text-xs text-red-600">{{ form.errors.slot_default }}</div>
          </div>
        </div>

        <div class="mt-4">
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

      <!-- Instrucciones -->
      <div class="mt-6 rounded-lg border bg-white p-4">
        <h2 class="text-sm font-semibold">Cómo agregar anuncios en futuras páginas</h2>
        <p class="mt-2 text-sm text-gray-600">
          1) Importa el componente:
        </p>
        <pre class="mt-2 rounded-md bg-gray-50 p-3 text-xs overflow-auto"><code>import AdSense from '@/components/AdSense.vue'</code></pre>

        <p class="mt-3 text-sm text-gray-600">
          2) Úsalo donde quieras:
        </p>
        <pre class="mt-2 rounded-md bg-gray-50 p-3 text-xs overflow-auto"><code>&lt;AdSense class="my-6" /&gt;</code></pre>

        <p class="mt-3 text-sm text-gray-600">
          3) Si quieres un slot específico (sobrescribe el default):
        </p>
        <pre class="mt-2 rounded-md bg-gray-50 p-3 text-xs overflow-auto"><code>&lt;AdSense slot="1234567890" /&gt;</code></pre>

        <p class="mt-3 text-xs text-gray-500">
          Nota: si AdSense está desactivado globalmente, el componente no renderiza nada.
        </p>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps<{
  seo: {
    site_name: string
    title: string
    description: string
    keywords: string
  }
}>()

const form = useForm({
  site_name: props.seo.site_name ?? '',
  title: props.seo.title ?? '',
  description: props.seo.description ?? '',
  keywords: props.seo.keywords ?? '',
})

const save = () => form.post('/admin/seo')

const previewTitle = computed(() => {
  const t = form.title?.trim()
  return t ? t : form.site_name
})

const origin = computed(() => (typeof window !== 'undefined' ? window.location.origin : 'https://tudominio.com'))
const robotsUrl = computed(() => `${origin.value}/robots.txt`)
const sitemapUrl = computed(() => `${origin.value}/sitemap.xml`)
const searchConsoleUrl = computed(() => 'https://search.google.com/search-console')
const pagespeedUrl = computed(() => `https://pagespeed.web.dev/report?url=${encodeURIComponent(origin.value)}`)

const previewDesc = computed(() => (form.description || '').trim())
</script>

<template>
  <AdminLayout>
    <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
    <div class="flex flex-col gap-2">
      <h1 class="text-xl font-semibold">SEO Settings</h1>

      <div class="rounded-md border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900">
        <strong>¿Qué hace este panel?</strong><br />
        Configura el SEO base del sitio (título, descripción, palabras clave). Estos valores se usan como
        <em>fallback</em> en todas las páginas públicas.
      </div>

      <div class="mt-4 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Form -->
        <div class="rounded-lg border bg-white p-5">
          <form class="space-y-4" @submit.prevent="save">
            <div>
              <label class="text-sm font-medium">Nombre del sitio</label>
              <input v-model="form.site_name" class="mt-1 w-full rounded-md border px-3 py-2 text-sm" />
              <div v-if="form.errors.site_name" class="mt-1 text-xs text-red-600">{{ form.errors.site_name }}</div>
            </div>

            <div>
              <label class="text-sm font-medium">Título base (fallback)</label>
              <input
                v-model="form.title"
                class="mt-1 w-full rounded-md border px-3 py-2 text-sm"
                placeholder="Ej: SabiaCMS — CMS moderno en Laravel"
              />
              <div v-if="form.errors.title" class="mt-1 text-xs text-red-600">{{ form.errors.title }}</div>
              <div class="mt-1 text-xs text-gray-500">Ideal: 50–60 caracteres.</div>
            </div>

            <div>
              <label class="text-sm font-medium">Descripción base</label>
              <textarea
                v-model="form.description"
                rows="4"
                class="mt-1 w-full rounded-md border px-3 py-2 text-sm"
                placeholder="Describe el sitio en 1–2 frases…"
              />
              <div class="mt-1 text-xs text-gray-500">
                {{ (form.description || '').length }} / 500 • Ideal: 140–160 caracteres.
              </div>
              <div v-if="form.errors.description" class="mt-1 text-xs text-red-600">{{ form.errors.description }}</div>
            </div>

            <div>
              <label class="text-sm font-medium">Keywords (opcional)</label>
              <input
                v-model="form.keywords"
                class="mt-1 w-full rounded-md border px-3 py-2 text-sm"
                placeholder="cms, laravel, seo, sabiduria..."
              />
              <div v-if="form.errors.keywords" class="mt-1 text-xs text-red-600">{{ form.errors.keywords }}</div>
              <div class="mt-1 text-xs text-gray-500">Hoy tienen poco peso en Google, pero pueden ayudar a organización interna.</div>
            </div>

            <button
              type="submit"
              class="rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:opacity-90"
              :disabled="form.processing"
            >
              Guardar
            </button>
          </form>
        </div>

        <!-- Preview Google -->
        <div class="rounded-lg border bg-white p-5">
          <h2 class="text-sm font-semibold text-gray-800">Vista previa (Google)</h2>

          <div class="mt-4 rounded-lg border bg-gray-50 p-4">
            <div class="text-blue-700 text-lg leading-snug">
              {{ previewTitle }}
            </div>
            <div class="mt-1 text-sm text-green-700">
              {{ origin }}
            </div>
            <div class="mt-2 text-sm text-gray-700">
              {{ previewDesc || 'Agrega una descripción para mejorar CTR en resultados de búsqueda.' }}
            </div>
          </div>

          <div class="mt-4 text-xs text-gray-500">
            Tip: esto es una aproximación visual. El snippet real depende de Google y del contenido.
          </div>
        </div>
      </div>

      <!-- ✅ Indicaciones para indexación -->
      <div class="mt-6 rounded-lg border bg-white p-5">
        <h2 class="text-sm font-semibold text-gray-900">Indicaciones para indexación (Google)</h2>

        <div class="mt-3 rounded-md border border-yellow-200 bg-yellow-50 p-3 text-sm text-yellow-900">
          <strong>Nota importante:</strong> en <code>localhost</code> Google no puede indexar.  
          Para indexar necesitas un dominio público (HTTPS recomendado).
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
          <div class="rounded-lg border bg-gray-50 p-4">
            <div class="text-sm font-medium">1) Verifica endpoints SEO</div>
            <ul class="mt-2 list-disc pl-5 text-sm text-gray-700">
              <li>
                Robots: <a :href="robotsUrl" target="_blank" class="underline">{{ robotsUrl }}</a>
              </li>
              <li>
                Sitemap: <a :href="sitemapUrl" target="_blank" class="underline">{{ sitemapUrl }}</a>
              </li>
            </ul>
            <p class="mt-2 text-xs text-gray-600">
              Robots debe incluir la línea <code>Sitemap: {{ sitemapUrl }}</code>.
            </p>
          </div>

          <div class="rounded-lg border bg-gray-50 p-4">
            <div class="text-sm font-medium">2) Conecta Google Search Console</div>
            <ol class="mt-2 list-decimal pl-5 text-sm text-gray-700">
              <li>Entra a <a :href="searchConsoleUrl" target="_blank" class="underline">Search Console</a></li>
              <li>Agrega tu dominio y verifícalo (DNS recomendado)</li>
              <li>Envía el sitemap: <code>{{ sitemapUrl }}</code></li>
            </ol>
          </div>

          <div class="rounded-lg border bg-gray-50 p-4">
            <div class="text-sm font-medium">3) Checklist mínimo de SEO</div>
            <ul class="mt-2 list-disc pl-5 text-sm text-gray-700">
              <li>Landing pública con contenido real (texto visible)</li>
              <li><code>&lt;title&gt;</code> y <code>meta description</code> configurados</li>
              <li>HTTPS activo</li>
              <li>No bloquear todo en robots (evitar <code>Disallow: /</code>)</li>
              <li>Sitemap accesible y con URLs reales</li>
            </ul>
          </div>

          <div class="rounded-lg border bg-gray-50 p-4">
            <div class="text-sm font-medium">4) Pruebas recomendadas</div>
            <ul class="mt-2 list-disc pl-5 text-sm text-gray-700">
              <li>
                PageSpeed/Lighthouse:
                <a :href="pagespeedUrl" target="_blank" class="underline">Abrir PageSpeed</a>
              </li>
              <li>Revisar “Ver código fuente” y confirmar meta tags</li>
            </ul>
            <p class="mt-2 text-xs text-gray-600">
              Si tu landing es SPA (Inertia), para máxima indexación se recomienda SSR en producción.
            </p>
          </div>
        </div>
      </div>
    </div>
    </div>
  </AdminLayout>
</template>

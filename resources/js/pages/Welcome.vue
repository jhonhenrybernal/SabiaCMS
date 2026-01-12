<script setup lang="ts">
import { computed } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'

const page = usePage()

withDefaults(
  defineProps<{
    canRegister: boolean
  }>(),
  { canRegister: true },
)

const appName = computed(() => (page.props.name as string) || 'SabiaCMS')

// Props compartidos por HandleInertiaRequests
const seo = computed(() => (page.props.seo as any) ?? {})

// Helpers SEO
const title = computed(() => seo.value.title || `${appName.value} — CMS enfocado en SEO`)
const description = computed(
  () =>
    seo.value.description ||
    'Un CMS en Laravel + Inertia + Vue, optimizado para SEO, sitemap, robots, rendimiento y administración de contenidos.',
)
const keywords = computed(() => seo.value.keywords || 'cms, laravel, inertia, vue, seo, sitemap, robots')
const robots = computed(() => seo.value.robots || 'index,follow')

// Canonical: si no hay base, no lo forzamos.
const canonical = computed(() => {
  const base = (seo.value.canonical_base || '').trim()
  if (!base) return ''
  // evita doble slash
  const path = window?.location?.pathname ?? '/'
  return `${base.replace(/\/$/, '')}${path}`
})

// OG image opcional
const ogImage = computed(() => (seo.value.og_image || '').trim())

const user = computed(() => (page.props.auth as any)?.user)
</script>

<template>
  <Head :title="title">
    <meta name="description" :content="description" />
    <meta name="keywords" :content="keywords" />
    <meta name="robots" :content="robots" />

    <link v-if="canonical" rel="canonical" :href="canonical" />

    <!-- OpenGraph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" :content="title" />
    <meta property="og:description" :content="description" />
    <meta v-if="canonical" property="og:url" :content="canonical" />
    <meta v-if="ogImage" property="og:image" :content="ogImage" />

    <!-- Verificaciones -->
    <meta v-if="seo.google_site_verification" name="google-site-verification" :content="seo.google_site_verification" />
    <meta v-if="seo.bing_site_verification" name="msvalidate.01" :content="seo.bing_site_verification" />
  </Head>

  <div class="min-h-screen bg-background text-foreground">
    <!-- Top bar -->
    <header class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-5">
      <div class="flex items-center gap-3">
        <img src="/public/icon-sabiacms.png" alt="SabiaCMS" class="h-9 w-9 rounded-md" />
        <div class="leading-tight">
          <div class="font-semibold">{{ appName }}</div>
          <div class="text-xs text-muted-foreground">CMS en Laravel + Inertia + Vue</div>
        </div>
      </div>

      <nav class="flex items-center gap-3 text-sm">
        <Link v-if="user" href="/dashboard" class="rounded-md px-3 py-2 hover:bg-muted">
          Dashboard
        </Link>

        <template v-else>
          <Link href="/login" class="rounded-md px-3 py-2 hover:bg-muted">Login</Link>
          <Link v-if="canRegister" href="/register" class="rounded-md px-3 py-2 hover:bg-muted">Register</Link>
        </template>
      </nav>
    </header>

    <!-- Hero -->
    <main class="mx-auto grid w-full max-w-6xl grid-cols-1 gap-10 px-6 pb-16 pt-6 lg:grid-cols-2 lg:items-center">
      <section>
        <div class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs text-muted-foreground">
          <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
          Construyendo un CMS “tipo WordPress”, pero con Laravel
        </div>

        <h1 class="mt-4 text-4xl font-semibold leading-tight tracking-tight">
          Un CMS rápido, moderno y
          <span class="underline decoration-primary/40 underline-offset-4">pensado para SEO</span>
        </h1>

        <p class="mt-4 text-base text-muted-foreground">
          SabiaCMS nace para publicar contenido con estructura, control y rendimiento:
          SEO administrable, robots, sitemap, panel, mensajes y analítica con Telescope.
        </p>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
          <Link
            href="/dashboard"
            class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:opacity-90"
          >
            Entrar al panel
          </Link>

          <a
            href="/sitemap.xml"
            class="inline-flex items-center justify-center rounded-md border px-4 py-2 text-sm hover:bg-muted"
          >
            Ver sitemap.xml
          </a>

          <a
            href="/robots.txt"
            class="inline-flex items-center justify-center rounded-md border px-4 py-2 text-sm hover:bg-muted"
          >
            Ver robots.txt
          </a>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div class="rounded-xl border p-4">
            <div class="text-sm font-medium">SEO administrable</div>
            <div class="mt-1 text-sm text-muted-foreground">
              Título, descripción, keywords, robots, canonical, OpenGraph y verificaciones.
            </div>
          </div>

          <div class="rounded-xl border p-4">
            <div class="text-sm font-medium">Índice y rastreo</div>
            <div class="mt-1 text-sm text-muted-foreground">
              robots.txt y sitemap.xml configurables para buscadores.
            </div>
          </div>

          <div class="rounded-xl border p-4">
            <div class="text-sm font-medium">Contenido con estructura</div>
            <div class="mt-1 text-sm text-muted-foreground">
              Mensajes por idioma (es/en/fr/it) con autor separado y CRUD.
            </div>
          </div>

          <div class="rounded-xl border p-4">
            <div class="text-sm font-medium">Observabilidad</div>
            <div class="mt-1 text-sm text-muted-foreground">
              Telescope para requests, jobs, excepciones y performance.
            </div>
          </div>
        </div>
      </section>

      <!-- Visual card -->
      <section class="rounded-2xl border bg-card p-6 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <div class="text-sm font-medium">Estado del proyecto</div>
            <div class="text-sm text-muted-foreground">Base lista para crecer como CMS</div>
          </div>
          <span class="rounded-full bg-muted px-3 py-1 text-xs">v0.1</span>
        </div>

        <div class="mt-6 space-y-3">
          <div class="flex items-center justify-between rounded-lg border p-3">
            <div>
              <div class="text-sm font-medium">Panel SEO</div>
              <div class="text-xs text-muted-foreground">Configurar meta, robots, canonical, OG</div>
            </div>
            <Link href="/dashboard" class="text-sm underline underline-offset-4">Abrir</Link>
          </div>

          <div class="flex items-center justify-between rounded-lg border p-3">
            <div>
              <div class="text-sm font-medium">Mensajes</div>
              <div class="text-xs text-muted-foreground">CRUD y búsqueda por idioma</div>
            </div>
            <Link href="/dashboard" class="text-sm underline underline-offset-4">Abrir</Link>
          </div>

          <div class="flex items-center justify-between rounded-lg border p-3">
            <div>
              <div class="text-sm font-medium">Telescope</div>
              <div class="text-xs text-muted-foreground">Monitoreo interno</div>
            </div>
            <Link href="/dashboard" class="text-sm underline underline-offset-4">Abrir</Link>
          </div>
        </div>

        <div class="mt-6 rounded-xl bg-muted p-4">
          <div class="text-sm font-medium">Objetivo</div>
          <p class="mt-1 text-sm text-muted-foreground">
            Convertir SabiaCMS en un CMS “tipo WordPress” pero con mejor control técnico:
            SEO, performance, seguridad, y estructura por componentes.
          </p>
        </div>
      </section>
    </main>

    <footer class="border-t py-10">
      <div class="mx-auto flex w-full max-w-6xl flex-col gap-2 px-6 text-sm text-muted-foreground md:flex-row md:items-center md:justify-between">
        <div>© {{ new Date().getFullYear() }} {{ appName }} — Hecho con Laravel + Inertia + Vue</div>
        <div class="flex gap-4">
          <a class="hover:underline" href="/sitemap.xml">sitemap.xml</a>
          <a class="hover:underline" href="/robots.txt">robots.txt</a>
        </div>
      </div>
    </footer>
  </div>
</template>

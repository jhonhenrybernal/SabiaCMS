<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/layouts/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar'
import type { NavItem } from '@/types'
import { Link } from '@inertiajs/vue3'
import { LayoutGrid, MessageSquare, Search, Bot, Map, Telescope, BadgeDollarSign  } from 'lucide-vue-next'
import AppLogo from './AppLogo.vue'

const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: '/admin',
    icon: LayoutGrid,
  },
  {
    title: 'Mensajes',
    href: '/admin/messages',
    icon: MessageSquare,
  },
  {
    title: 'SEO',
    href: '/admin/seo',
    icon: Search,
  },
  {
    title: 'Robots',
    href: '/admin/robots',
    icon: Bot,
  },
  {
    title: 'Sitemap',
    href: '/admin/sitemap',
    icon: Map,
  },
  {
    title: 'AdSense',
    href: '/admin/adsense',
    icon: BadgeDollarSign,
  },
  {
    title: 'Telescope',
    href: '/admin/telescope',
    icon: Telescope,
  },
]

// ✅ Quitamos Github/Docs. Si no quieres footer, déjalo vacío.
const footerNavItems: NavItem[] = []

// ✅ Link del logo
const logoHref = '/admin'
</script>

<template>
  <Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="logoHref">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <SidebarFooter>
      <!-- Si tu NavFooter no soporta array vacío, puedes borrar esta línea -->
      <NavFooter v-if="footerNavItems.length" :items="footerNavItems" />

      <NavUser />
    </SidebarFooter>
  </Sidebar>

  <slot />
</template>

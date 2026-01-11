<script setup lang="ts">
import UserInfo from '@/components/UserInfo.vue'
import {
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu'
import type { User } from '@/types'
import { Link, router } from '@inertiajs/vue3'
import { LogOut, Settings } from 'lucide-vue-next'

interface Props {
  user: User
}

defineProps<Props>()

// ✅ Ajusta estas rutas si tus endpoints reales son distintos
const profileEditUrl = '/user/profile' // Fortify normalmente usa /user/profile
const logoutUrl = '/logout'

const handleLogout = () => {
  // Limpia el estado SPA de Inertia (opcional)
  router.flushAll()

  // ✅ Logout real (Fortify: POST /logout)
  router.post(logoutUrl)
}
</script>

<template>
  <DropdownMenuLabel class="p-0 font-normal">
    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
      <UserInfo :user="user" :show-email="true" />
    </div>
  </DropdownMenuLabel>

  <DropdownMenuSeparator />

  <DropdownMenuGroup>
    <DropdownMenuItem :as-child="true">
      <Link class="block w-full cursor-pointer" :href="profileEditUrl" prefetch>
        <Settings class="mr-2 h-4 w-4" />
        Settings
      </Link>
    </DropdownMenuItem>
  </DropdownMenuGroup>

  <DropdownMenuSeparator />

  <!-- ✅ Logout correcto: botón que hace POST -->
  <DropdownMenuItem :as-child="true">
    <button
      type="button"
      class="block w-full cursor-pointer text-left"
      @click="handleLogout"
      data-test="logout-button"
    >
      <span class="inline-flex items-center">
        <LogOut class="mr-2 h-4 w-4" />
        Log out
      </span>
    </button>
  </DropdownMenuItem>
</template>

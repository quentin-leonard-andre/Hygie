<script setup>
import { ref } from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>

  <div class="bg-base-100 min-h-screen">
    <!-- Barre de navigation -->
    <div class="navbar bg-base-100">
      <div class="navbar-start">
        <div class="dropdown">
          <label tabindex="0" class="btn btn-ghost lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
          </label>
          <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
            <li>
            <a :href="route('dashboard')" :class="{active: route().current('dashboard')}">
                Tableau de bord
            </a>
          </li>
          <li><a :href="route('seances.index')" :class="{active: route().current('seances.*') || route().current('exercices.*')}">Séances</a></li>
          <li><a :href="route('machines.index')" :class="{active: route().current('machines.*')}">Machines</a></li>
          <li>
              <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                  Déconnexion
              </BreezeDropdownLink>
          </li>
          </ul>
        </div>
        <a class="btn btn-ghost normal-case text-xl hidden sm:inline-flex">
            <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                    <BreezeApplicationLogo class="block h-9 w-auto" />
                </Link>
            </div>
            <span class="ml-2">Hygie</span>
        </a>
      </div>


      <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal p-0 gap-2">
          <li>
            <a :href="route('dashboard')" :class="{active: route().current('dashboard')}">
                Tableau de bord
            </a>
          </li>
          <li><a :href="route('seances.index')" :class="{active: route().current('seances.*') || route().current('exercices.*')}">Séances</a></li>
          <li><a :href="route('machines.index')" :class="{active: route().current('machines.*')}">Machines</a></li>
        </ul>
      </div>
      <div class="navbar-end hidden sm:inline-flex">
        <ul class="menu menu-horizontal p-0">
            <li tabindex="0">
                <a>
                    {{ $page.props.auth.user.name }}
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/></svg>
                </a>
                <ul class="p-2 bg-white border ">
                    <li>
                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                            Déconnexion
                        </BreezeDropdownLink>
                    </li>
                </ul>
            </li>
        </ul>
      </div>
    </div>

    <!-- Contenu -->
    <div class="py-6" >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-4">
          <slot />
        </div>
    </div>

  </div>

</template>

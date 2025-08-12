<template>
  <!-- ========== Menu ========== -->
  <div class="app-menu">
    <!-- Brand Logo -->
    <div class="logo-box">
      <!-- Brand Logo Light -->
      <a href="index.html" class="logo-light">
        <img :src="logoLight" alt="logo" class="logo-lg">
        <img :src="logoSm" alt="small logo" class="logo-sm">
      </a>

      <!-- Brand Logo Dark -->
      <a href="index.html" class="logo-dark">
        <img :src="logoDark" alt="dark logo" class="logo-lg">
        <img :src="logoSm" alt="small logo" class="logo-sm">
      </a>
    </div>

    <!-- menu-left -->
    <div class="scrollbar">
      <!-- User box -->
      <div class="user-box text-center">
        <img :src="userAvatar" alt="user-img" :title="userName" class="rounded-circle avatar-md">
        <div class="dropdown">
          <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown">{{ userName }}</a>
          <div class="dropdown-menu user-pro-dropdown">
            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
              <i class="fe-user me-1"></i>
              <span>Minha Conta</span>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item">
              <i class="fe-settings me-1"></i>
              <span>Configurações</span>
            </a>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item" @click="handleLogout">
              <i class="fe-log-out me-1"></i>
              <span>Sair</span>
            </a>
          </div>
        </div>
        <p class="text-muted mb-0">{{ userRole }}</p>
      </div>

      <!--- Menu -->
      <ul class="menu">
        <li class="menu-title">Sistema</li>

        <!-- <li class="menu-item">
          <router-link to="/" class="menu-link">
            <span class="menu-icon"><i class="mdi mdi-home"></i></span>
            <span class="menu-text">Dashboard</span>
          </router-link>
        </li> -->

        <li class="menu-item">
          <router-link to="/chamados" class="menu-link">
            <span class="menu-icon"><i class="mdi mdi-ticket"></i></span>
            <span class="menu-text">Chamados</span>
          </router-link>
        </li>

        <!-- <li class="menu-item">
          <a href="#menuProjects" data-bs-toggle="collapse" class="menu-link">
            <span class="menu-icon"><i data-feather="briefcase"></i></span>
            <span class="menu-text"> Projects </span>
            <span class="menu-arrow"></span>
          </a>
          <div class="collapse" id="menuProjects">
            <ul class="sub-menu">
              <li class="menu-item">
                <a href="project-list.html" class="menu-link">
                  <span class="menu-text">List</span>
                </a>
              </li>
              <li class="menu-item">
                <a href="project-detail.html" class="menu-link">
                  <span class="menu-text">Detail</span>
                </a>
              </li>
              <li class="menu-item">
                <a href="project-create.html" class="menu-link">
                  <span class="menu-text">Create Project</span>
                </a>
              </li>
            </ul>
          </div>
        </li> -->
      </ul>
      <!--- End Menu -->
      <div class="clearfix"></div>
    </div>
  </div>
  <!-- ========== Left menu End ========== -->
</template>

<script>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import authService from '@/services/authService'
// Importando as imagens do logo internamente
import logoLight from '@/assets/images/logo-light.png'
import logoDark from '@/assets/images/logo-dark.png'
import logoSm from '@/assets/images/logo-sm.png'

export default {
  name: 'Menu',
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  setup(props) {
    const router = useRouter()

    const userName = computed(() => {
      return props.user?.name || 'Usuário'
    })

    const userRole = computed(() => {
      return props.user?.role || 'Usuário'
    })

    const userAvatar = computed(() => {
      // Se o usuário tiver uma imagem, usar ela, senão usar uma imagem padrão
      return props.user?.avatar || 'https://via.placeholder.com/150/667eea/ffffff?text=' + userName.value.charAt(0).toUpperCase()
    })

    const handleLogout = async () => {
      try {
        await authService.logout()
        router.push('/login')
      } catch (error) {
        // Mesmo com erro, limpar dados locais e redirecionar
        authService.clearAuthData()
        router.push('/login')
      }
    }

    return {
      logoLight,
      logoDark,
      logoSm,
      userName,
      userRole,
      userAvatar,
      handleLogout
    }
  }
}
</script>

<style scoped>
/* Estilos específicos do Menu podem ser adicionados aqui */
</style>

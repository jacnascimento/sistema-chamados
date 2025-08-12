<template>
  <div id="wrapper">
    <!-- Mostrar menu e topbar apenas se estiver autenticado -->
    <template v-if="isAuthenticated">
      <Menu
        :user="currentUser"
      />
      <div class="content-page">
         <Topbar
           :user1="user1Image"
           :user2="user2Image"
           :user4="user4Image"
         />

         <router-view />

         <Footer 
           companyName="Cellar Vinhos"
           companyUrl="#"
           companyUrlText="Powered by Jac Nascimento - Servido pela Cellar Vinhos"
         />
       </div>
    </template>
    
    <!-- Se não estiver autenticado, mostrar apenas o router-view (página de login) -->
    <template v-else>
      <router-view />
    </template>
  </div>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import authService from '@/services/authService'
// Testando importação dinâmica das imagens
const user1Image = new URL('@/assets/images/users/avatar-1.jpg', import.meta.url).href
const user2Image = new URL('@/assets/images/users/avatar-2.jpg', import.meta.url).href
const user4Image = new URL('@/assets/images/users/avatar-4.jpg', import.meta.url).href

import Menu from '@/components/Menu.vue'
import Topbar from '@/components/Topbar.vue'
import Footer from '@/components/Footer.vue'

export default {
  name: 'App',
  components: {
    Menu,
    Topbar,
    Footer
  },
  setup() {
    const route = useRoute()
    const isAuthenticated = ref(false)
    const currentUser = ref(null)

    const checkAuthStatus = () => {
      isAuthenticated.value = authService.isAuthenticated()
      currentUser.value = authService.getCurrentUser()
    }

    const currentYear = computed(() => new Date().getFullYear())

    // Verificar status de autenticação ao montar o componente
    onMounted(() => {
      checkAuthStatus()
      // Debug: verificar se as imagens estão sendo importadas
      console.log('Imagens importadas:', { user1Image, user2Image, user4Image })
      // Teste alternativo: usar URLs diretas
      console.log('URLs alternativas:', {
        user1: '/src/assets/images/users/avatar-1.jpg',
        user2: '/src/assets/images/users/avatar-2.jpg',
        user4: '/src/assets/images/users/avatar-4.jpg'
      })
    })

    // Observar mudanças na rota para verificar autenticação
    watch(route, () => {
      checkAuthStatus()
    })

    return {
      isAuthenticated,
      currentUser,
      user1Image,
      user2Image,
      user4Image,
      currentYear
    }
  }
}
</script>

<style>
</style>
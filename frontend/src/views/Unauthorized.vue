<template>
  <div class="unauthorized-container">
    <div class="unauthorized-card">
      <div class="unauthorized-icon">
        <i class="mdi mdi-shield-lock"></i>
      </div>
      
      <div class="unauthorized-content">
        <h1>Acesso Negado</h1>
        <p>Você não tem permissão para acessar esta página.</p>
        <p class="text-muted">Entre em contato com o administrador do sistema se acredita que isso é um erro.</p>
      </div>

      <div class="unauthorized-actions">
        <router-link to="/" class="btn btn-primary">
          <i class="mdi mdi-home me-2"></i>
          Voltar ao Início
        </router-link>
        
        <button @click="handleLogout" class="btn btn-outline-secondary">
          <i class="mdi mdi-logout me-2"></i>
          Fazer Logout
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import authService from '@/services/authService'

export default {
  name: 'Unauthorized',
  setup() {
    const router = useRouter()

    const handleLogout = async () => {
      try {
        await authService.logout()
        router.push('/login')
      } catch (error) {
        console.error('Erro ao fazer logout:', error)
        authService.clearAuthData()
        router.push('/login')
      }
    }

    return {
      handleLogout
    }
  }
}
</script>

<style scoped>
.unauthorized-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 20px;
}

.unauthorized-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
  padding: 40px;
  text-align: center;
  max-width: 500px;
  width: 100%;
}

.unauthorized-icon {
  margin-bottom: 30px;
}

.unauthorized-icon i {
  font-size: 80px;
  color: #dc3545;
}

.unauthorized-content h1 {
  color: #333;
  font-size: 32px;
  font-weight: 600;
  margin-bottom: 20px;
}

.unauthorized-content p {
  color: #666;
  font-size: 16px;
  margin-bottom: 15px;
  line-height: 1.6;
}

.unauthorized-content .text-muted {
  color: #999;
  font-size: 14px;
}

.unauthorized-actions {
  margin-top: 30px;
  display: flex;
  gap: 15px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn {
  padding: 12px 24px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  cursor: pointer;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-color: transparent;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.btn-outline-secondary {
  background: transparent;
  color: #6c757d;
  border-color: #6c757d;
}

.btn-outline-secondary:hover {
  background: #6c757d;
  color: white;
  transform: translateY(-2px);
}

@media (max-width: 480px) {
  .unauthorized-card {
    padding: 30px 20px;
  }
  
  .unauthorized-actions {
    flex-direction: column;
  }
  
  .btn {
    width: 100%;
    justify-content: center;
  }
}
</style>

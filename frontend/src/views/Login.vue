<template>
  <div class="login-container w-100">
    <div class="login-card">
      <div class="login-header">
        <h1>Sistema de Chamados</h1>
        <p>Faça login para acessar o sistema</p>
      </div>

      <form @submit.prevent="handleLogin" class="login-form">
        <div class="form-group">
          <label for="email">E-mail</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="form-control"
            :class="{ 'is-invalid': errors.email }"
            placeholder="Digite seu e-mail"
            required
            @keyup.enter="handleLogin"
          />
          <div v-if="errors.email" class="invalid-feedback">
            {{ errors.email }}
          </div>
        </div>

        <div class="form-group">
          <label for="password">Senha</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="form-control"
            :class="{ 'is-invalid': errors.password }"
            placeholder="Digite sua senha"
            required
            @keyup.enter="handleLogin"
          />
          <div v-if="errors.password" class="invalid-feedback">
            {{ errors.password }}
          </div>
        </div>

        <div v-if="loginError" class="alert alert-danger">
          {{ loginError }}
        </div>

        <button
          type="submit"
          class="btn btn-primary btn-block"
          :disabled="loading"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
          {{ loading ? 'Entrando...' : 'Entrar' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import authService from '@/services/authService'

export default {
  name: 'Login',
  setup() {
    const router = useRouter()
    
    const form = reactive({
      email: '',
      password: ''
    })

    const errors = reactive({})
    const loading = ref(false)
    const loginError = ref('')

    const validateForm = () => {
      // Limpar erros anteriores
      errors.email = ''
      errors.password = ''

      let hasErrors = false

      // Validar email
      if (!form.email || form.email.trim() === '') {
        errors.email = 'E-mail é obrigatório'
        hasErrors = true
      } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email.trim())) {
        errors.email = 'E-mail inválido'
        hasErrors = true
      }

      // Validar senha
      if (!form.password || form.password.trim() === '') {
        errors.password = 'Senha é obrigatória'
        hasErrors = true
      } else if (form.password.length < 6) {
        errors.password = 'Senha deve ter pelo menos 6 caracteres'
        hasErrors = true
      }

      return !hasErrors
    }

    const handleLogin = async () => {
      // Validar formulário
      const isValid = validateForm()
      
      if (!isValid) {
        return
      }

      loading.value = true
      loginError.value = ''

      try {
        await authService.login({
          email: form.email.trim(),
          password: form.password
        })

        // Redirecionar para a página principal
        router.push('/')
      } catch (error) {
        if (error.response?.status === 401) {
          loginError.value = 'E-mail ou senha incorretos'
        } else if (error.response?.data?.message) {
          loginError.value = error.response.data.message
        } else {
          loginError.value = 'Erro ao fazer login. Tente novamente.'
        }
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      errors,
      loading,
      loginError,
      handleLogin
    }
  }
}
</script>


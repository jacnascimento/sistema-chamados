import axios from 'axios'
import apiConfig from './api'
import { ENV_CONFIG } from './environment'

// Criar instância do Axios com configurações base
const apiClient = axios.create({
  baseURL: apiConfig.baseURL,
  timeout: apiConfig.timeout,
  headers: apiConfig.headers
})

// Interceptor para requisições
apiClient.interceptors.request.use(
  (config) => {
    // Adicionar token de autenticação se existir
    const token = localStorage.getItem(ENV_CONFIG.AUTH_TOKEN_KEY)
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }

    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Interceptor para respostas
apiClient.interceptors.response.use(
  (response) => {
    return response
  },
  (error) => {
    // Tratamento de erros globais
    if (error.response) {
      // Erro do servidor (status 4xx, 5xx)

      // Tratar erro de autenticação
      if (error.response.status === 401) {
        localStorage.removeItem(ENV_CONFIG.AUTH_TOKEN_KEY)
        localStorage.removeItem(ENV_CONFIG.AUTH_REFRESH_TOKEN_KEY)
        localStorage.removeItem('user')

        // Redirecionar para login se não estiver já na página de login
        if (window.location.pathname !== '/login') {
          window.location.href = '/login'
        }
      }
    }

    return Promise.reject(error)
  }
)

export default apiClient

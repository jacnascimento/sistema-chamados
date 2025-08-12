import apiClient from '@/config/axios'
import { ENV_CONFIG } from '@/config/environment'
import { API_ENDPOINTS } from '@/config/endpoints'

class AuthService {
    /**
     * Realizar login do usuário
     * @param {Object} credentials - Credenciais (email, password)
     * @returns {Promise<Object>} Dados do usuário e token
     */
    async login(credentials) {
        try {
            const response = await apiClient.post(API_ENDPOINTS.AUTH.LOGIN, credentials)
            const { user, access_token, refresh_token } = response.data

            // Salvar tokens no localStorage
            localStorage.setItem(ENV_CONFIG.AUTH_TOKEN_KEY, access_token)
            if (refresh_token) {
                localStorage.setItem(ENV_CONFIG.AUTH_REFRESH_TOKEN_KEY, refresh_token)
            }

            // Salvar dados do usuário
            localStorage.setItem('user', JSON.stringify(user))

            return { user, access_token, refresh_token }
        } catch (error) {
            throw error
        }
    }

    /**
     * Realizar logout do usuário
     */
    async logout() {
        try {
            // Chamar API para invalidar token (se necessário)
            await apiClient.post(API_ENDPOINTS.AUTH.LOGOUT)
        } catch (error) {
            // Erro no logout
        } finally {
            // Limpar dados locais
            this.clearAuthData()
        }
    }

    /**
     * Verificar se o usuário está autenticado
     * @returns {boolean} True se autenticado
     */
    isAuthenticated() {
        const token = localStorage.getItem(ENV_CONFIG.AUTH_TOKEN_KEY)
        return !!token
    }

    /**
     * Obter dados do usuário atual
     * @returns {Object|null} Dados do usuário ou null
     */
    getCurrentUser() {
        const userStr = localStorage.getItem('user')
        return userStr ? JSON.parse(userStr) : null
    }

    /**
     * Obter token de acesso
     * @returns {string|null} Token ou null
     */
    getAccessToken() {
        return localStorage.getItem(ENV_CONFIG.AUTH_TOKEN_KEY)
    }

    /**
     * Limpar dados de autenticação
     */
    clearAuthData() {
        localStorage.removeItem(ENV_CONFIG.AUTH_TOKEN_KEY)
        localStorage.removeItem(ENV_CONFIG.AUTH_REFRESH_TOKEN_KEY)
        localStorage.removeItem('user')
    }

    /**
     * Verificar se o token expirou
     * @returns {boolean} True se expirado
     */
    isTokenExpired() {
        const token = this.getAccessToken()
        if (!token) return true

        try {
            const payload = JSON.parse(atob(token.split('.')[1]))
            const currentTime = Date.now() / 1000
            return payload.exp < currentTime
        } catch (error) {
            return true
        }
    }

    /**
     * Renovar token usando refresh token
     * @returns {Promise<Object>} Novo token
     */
    async refreshToken() {
        try {
            const refreshToken = localStorage.getItem(ENV_CONFIG.AUTH_REFRESH_TOKEN_KEY)
            if (!refreshToken) {
                throw new Error('Refresh token não encontrado')
            }

            const response = await apiClient.post(API_ENDPOINTS.AUTH.REFRESH, {
                refresh_token: refreshToken
            })

            const { access_token, refresh_token } = response.data

            // Atualizar tokens
            localStorage.setItem(ENV_CONFIG.AUTH_TOKEN_KEY, access_token)
            if (refresh_token) {
                localStorage.setItem(ENV_CONFIG.AUTH_REFRESH_TOKEN_KEY, refresh_token)
            }

            return { access_token, refresh_token }
        } catch (error) {
            // Erro ao renovar token
            this.clearAuthData()
            throw error
        }
    }

    /**
     * Obter dados do usuário atual da API
     * @returns {Promise<Object>} Dados do usuário
     */
    async getMe() {
        try {
            const response = await apiClient.get(API_ENDPOINTS.AUTH.ME)
            const user = response.data

            // Atualizar dados do usuário no localStorage
            localStorage.setItem('user', JSON.stringify(user))

            return user
        } catch (error) {
            // Erro ao obter dados do usuário
            throw error
        }
    }

    /**
     * Verificar configuração da API
     * @returns {Promise<Object>} Status da configuração
     */
    async checkConfiguration() {
        try {
            // Testar conectividade com um endpoint simples
            const response = await apiClient.get('/api/health')
            return {
                status: 'success',
                baseURL: apiClient.defaults.baseURL,
                endpoints: API_ENDPOINTS,
                config: ENV_CONFIG,
                connectivity: response.data
            }
        } catch (error) {
            return {
                status: 'error',
                baseURL: apiClient.defaults.baseURL,
                endpoints: API_ENDPOINTS,
                config: ENV_CONFIG,
                error: {
                    message: error.message,
                    status: error.response?.status,
                    data: error.response?.data
                }
            }
        }
    }
}

export default new AuthService()

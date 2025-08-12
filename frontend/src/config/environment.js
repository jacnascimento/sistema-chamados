// Configurações de ambiente
export const ENV_CONFIG = {
  // API
  API_BASE_URL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:8080',
  API_TIMEOUT: parseInt(import.meta.env.VITE_API_TIMEOUT) || 10000,
  
  // Aplicação
  APP_TITLE: import.meta.env.VITE_APP_TITLE || 'Sistema de Chamados',
  APP_VERSION: import.meta.env.VITE_APP_VERSION || '1.0.0',
  
  // Autenticação
  AUTH_TOKEN_KEY: import.meta.env.VITE_AUTH_TOKEN_KEY || 'auth_token',
  AUTH_REFRESH_TOKEN_KEY: import.meta.env.VITE_AUTH_REFRESH_TOKEN_KEY || 'auth_refresh_token',
  
  // Ambiente
  IS_PRODUCTION: import.meta.env.PROD,
  IS_DEVELOPMENT: import.meta.env.DEV,
  IS_TESTING: import.meta.env.MODE === 'test'
}

export default ENV_CONFIG

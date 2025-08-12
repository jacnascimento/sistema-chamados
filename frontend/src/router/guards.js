import authService from '@/services/authService'

/**
 * Guarda de rota para verificar autenticação
 * @param {Object} to - Rota de destino
 * @param {Object} from - Rota de origem
 * @param {Function} next - Função para continuar navegação
 */
export function requireAuth(to, from, next) {
  // Verificar se o usuário está autenticado
  if (authService.isAuthenticated()) {
    // Verificar se o token não expirou
    if (authService.isTokenExpired()) {
      // Tentar renovar o token
      authService.refreshToken()
        .then(() => {
          next()
        })
        .catch(() => {
          // Se falhar ao renovar, redirecionar para login
          authService.clearAuthData()
          next('/login')
        })
    } else {
      // Usuário autenticado e token válido
      next()
    }
  } else {
    // Usuário não autenticado, redirecionar para login
    next('/login')
  }
}

/**
 * Guarda de rota para páginas que não devem ser acessadas por usuários autenticados
 * @param {Object} to - Rota de destino
 * @param {Object} from - Rota de origem
 * @param {Function} next - Função para continuar navegação
 */
export function requireGuest(to, from, next) {
  if (authService.isAuthenticated()) {
    // Usuário já está autenticado, redirecionar para página principal
    next('/')
  } else {
    // Usuário não autenticado, permitir acesso
    next()
  }
}

/**
 * Guarda de rota para verificar permissões específicas
 * @param {Array} requiredRoles - Array de roles necessários
 * @returns {Function} Função guarda de rota
 */
export function requireRole(requiredRoles) {
  return (to, from, next) => {
    if (!authService.isAuthenticated()) {
      next('/login')
      return
    }

    const user = authService.getCurrentUser()

    if (!user || !user.role) {
      next('/login')
      return
    }

    if (requiredRoles.includes(user.role)) {
      next()
    } else {
      // Usuário não tem permissão, redirecionar para página de acesso negado
      next('/unauthorized')
    }
  }
}

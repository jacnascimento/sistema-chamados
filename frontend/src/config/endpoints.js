// Endpoints da API
export const API_ENDPOINTS = {
    // Autenticação
    AUTH: {
        LOGIN: '/api/login',
        LOGOUT: '/api/auth/logout',
        REFRESH: '/api/auth/refresh',
        ME: '/api/auth/user'
    },

    // Usuários
    USERS: {
        LIST: '/api/users',
        SHOW: (id) => `/api/users/${id}`,
        CREATE: '/api/users',
        UPDATE: (id) => `/api/users/${id}`,
        DELETE: (id) => `/api/users/${id}`
    },

    // Tickets
    TICKETS: {
        LIST: '/api/tickets',
        SHOW: (id) => `/api/tickets/${id}`,
        CREATE: '/api/tickets',
        UPDATE: (id) => `/api/tickets/${id}`,
        DELETE: (id) => `/api/tickets/${id}`,
        ASSIGN: (id) => `/api/tickets/${id}/assign`,
        CHANGE_STATUS: (id) => `/api/tickets/${id}/status`
    },

    // Categorias
    CATEGORIES: {
        LIST: '/api/categories',
        SHOW: (id) => `/api/categories/${id}`,
        CREATE: '/api/categories',
        UPDATE: (id) => `/api/categories/${id}`,
        DELETE: (id) => `/api/categories/${id}`
    }
}

export default API_ENDPOINTS

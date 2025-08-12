import apiClient from '@/config/axios'
import { API_ENDPOINTS } from '@/config/endpoints'

class TicketService {
    /**
     * Buscar todos os tickets
     * @param {Object} params - Parâmetros de filtro e paginação
     * @returns {Promise<Array>} Lista de tickets
     */
    async getTickets(params = {}) {
        try {
            const response = await apiClient.get(API_ENDPOINTS.TICKETS.LIST, { params })
            return response.data
        } catch (error) {
            console.error('Erro ao buscar tickets:', error)
            throw error
        }
    }

    /**
     * Buscar ticket por ID
     * @param {number|string} id - ID do ticket
     * @returns {Promise<Object>} Dados do ticket
     */
    async getTicket(id) {
        try {
            const response = await apiClient.get(API_ENDPOINTS.TICKETS.SHOW(id))
            return response.data
        } catch (error) {
            console.error(`Erro ao buscar ticket ${id}:`, error)
            throw error
        }
    }

    /**
     * Criar novo ticket
     * @param {Object} ticketData - Dados do ticket
     * @returns {Promise<Object>} Ticket criado
     */
    async createTicket(ticketData) {
        try {
            const response = await apiClient.post(API_ENDPOINTS.TICKETS.CREATE, ticketData)
            return response.data
        } catch (error) {
            console.error('Erro ao criar ticket:', error)
            throw error
        }
    }

    /**
     * Atualizar ticket existente
     * @param {number|string} id - ID do ticket
     * @param {Object} ticketData - Dados para atualização
     * @returns {Promise<Object>} Ticket atualizado
     */
    async updateTicket(id, ticketData) {
        try {
            const response = await apiClient.put(API_ENDPOINTS.TICKETS.UPDATE(id), ticketData)
            return response.data
        } catch (error) {
            console.error(`Erro ao atualizar ticket ${id}:`, error)
            throw error
        }
    }

    /**
     * Deletar ticket
     * @param {number|string} id - ID do ticket
     * @returns {Promise<boolean>} True se deletado com sucesso
     */
    async deleteTicket(id) {
        try {
            await apiClient.delete(API_ENDPOINTS.TICKETS.DELETE(id))
            return true
        } catch (error) {
            console.error(`Erro ao deletar ticket ${id}:`, error)
            throw error
        }
    }

    /**
     * Atribuir ticket a um usuário
     * @param {number|string} id - ID do ticket
     * @param {number|string} userId - ID do usuário
     * @returns {Promise<Object>} Ticket atualizado
     */
    async assignTicket(id, userId) {
        try {
            const response = await apiClient.post(API_ENDPOINTS.TICKETS.ASSIGN(id), { user_id: userId })
            return response.data
        } catch (error) {
            console.error(`Erro ao atribuir ticket ${id}:`, error)
            throw error
        }
    }

    /**
     * Alterar status do ticket
     * @param {number|string} id - ID do ticket
     * @param {string} status - Novo status
     * @returns {Promise<Object>} Ticket atualizado
     */
    async changeTicketStatus(id, status) {
        try {
            const response = await apiClient.patch(API_ENDPOINTS.TICKETS.CHANGE_STATUS(id), { status })
            return response.data
        } catch (error) {
            console.error(`Erro ao alterar status do ticket ${id}:`, error)
            throw error
        }
    }

    /**
     * Adicionar comentário ao ticket
     * @param {number|string} id - ID do ticket
     * @param {string} comment - Comentário
     * @returns {Promise<Object>} Comentário criado
     */
    async addComment(id, comment) {
        try {
            const response = await apiClient.post(API_ENDPOINTS.TICKETS.ADD_COMMENT(id), { comment })
            return response.data
        } catch (error) {
            console.error(`Erro ao adicionar comentário ao ticket ${id}:`, error)
            throw error
        }
    }
}

export default new TicketService()

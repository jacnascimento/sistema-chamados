<template>
  <div class="content">
    <div class="container-fluid">
      <Breadcrumb
        :breadcrumbItems="breadcrumbItems"
        pageTitle="Lista de Chamados"
      />
      
      <!-- Conteúdo da lista de tickets -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Chamados</h4>
              <div class="card-tools">
                <button class="btn btn-primary">
                  <i class="mdi mdi-plus"></i> Novo Chamado
                </button>
              </div>
            </div>
            <div class="card-body">
              <!-- Filtros -->
              <div class="row mb-3">
                <div class="col-md-3">
                  <select v-model="filters.status" class="form-select">
                    <option value="">Todos os Status</option>
                    <option value="aberto">Aberto</option>
                    <option value="em progresso">Em Andamento</option>
                    <option value="resolvido">Resolvido</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <button @click="clearFilters" class="btn btn-outline-secondary me-2">
                    <i class="mdi mdi-filter-remove"></i> Limpar
                  </button>
                  <button @click="refreshTickets" class="btn btn-outline-primary">
                    <i class="mdi mdi-refresh"></i> Atualizar
                  </button>
                </div>
              </div>

              <!-- Indicador de Loading -->
              <div v-if="loading" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Carregando...</span>
                </div>
                <p class="mt-2">Carregando chamados...</p>
              </div>

              <!-- Mensagem de Erro -->
              <div v-else-if="error" class="alert alert-danger" role="alert">
                <i class="mdi mdi-alert-circle"></i>
                {{ error }}
                <button @click="loadTickets" class="btn btn-sm btn-outline-danger ms-2">
                  Tentar Novamente
                </button>
              </div>

              <!-- Tabela de Tickets -->
              <div v-else class="table-responsive">
                <table class="table table-centered table-nowrap mb-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Título</th>
                      <th>Status</th>
                      <th>Responsável</th>
                      <th>Data Criação</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="filteredTickets.length === 0">
                      <td colspan="7" class="text-center py-4">
                        <i class="mdi mdi-inbox-outline text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-2 text-muted">Nenhum chamado encontrado</p>
                      </td>
                    </tr>
                    <tr v-for="ticket in filteredTickets" :key="ticket.id">
                      <td>#{{ ticket.id || 'N/A' }}</td>
                      <td>{{ ticket.title || 'Sem título' }}</td>
                      <td>
                        <span :class="getStatusClass(ticket.status)">
                          {{ ticket.status || 'Não definido' }}
                        </span>
                      </td>
                      <td>{{ ticket.assignee || 'Não atribuído' }}</td>
                      <td>{{ formatDate(ticket.created_at) }}</td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                            <i class="mdi mdi-eye"></i>
                          </button>
                          <button class="btn btn-sm btn-outline-secondary" title="Editar">
                            <i class="mdi mdi-pencil"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Breadcrumb from '@/components/Breadcrumb.vue'
import ticketService from '@/services/ticketService'

export default {
  name: 'TicketList',
  components: {
    Breadcrumb
  },
  data() {
    return {
      tickets: [],
      loading: false,
      error: null,
      filters: {
        status: '',
      }
    }
  },
  computed: {
    breadcrumbItems() {
      return [
        { text: 'Sistema', href: '/', active: false },
        { text: 'Chamados', href: '/chamados', active: false },
        { text: 'Lista', href: '', active: true }
      ]
    },
    filteredTickets() {
      let filtered = [...this.tickets]
      
      if (this.filters.status) {
        filtered = filtered.filter(ticket => ticket.status === this.filters.status)
      }
      
      return filtered
    }
  },
  async mounted() {
    await this.loadTickets()
  },
  methods: {
    async loadTickets() {
      this.loading = true
      this.error = null
      
      try {
        // Buscar tickets da API
        const response = await ticketService.getTickets()
        console.log('Resposta da API:', response)
        this.tickets = response.data || response || []
        
        // Log dos tickets para debug
        console.log('Tickets carregados:', this.tickets)
        if (this.tickets.length > 0) {
          console.log('Primeiro ticket:', this.tickets[0])
        }
      } catch (error) {
        console.error('Erro ao carregar tickets:', error)
        this.error = 'Erro ao carregar os chamados. Tente novamente.'
      } finally {
        this.loading = false
      }
    },
    
    async refreshTickets() {
      await this.loadTickets()
    },
    
    getStatusClass(status) {
      if (!status) {
        return 'badge bg-secondary'
      }
      
      const classes = {
        'Aberto': 'badge bg-warning',
        'Em Andamento': 'badge bg-info',
        'Fechado': 'badge bg-success',
        'Cancelado': 'badge bg-danger'
      }
      return classes[status] || 'badge bg-secondary'
    },
    
    formatDate(date) {
      if (!date) {
        return 'N/A'
      }
      
      if (typeof date === 'string') {
        return new Date(date).toLocaleDateString('pt-BR')
      }
      
      if (date instanceof Date) {
        return date.toLocaleDateString('pt-BR')
      }
      
      return 'N/A'
    },
    
    clearFilters() {
      this.filters = {
        status: '',
      }
    }
  }
}
</script>

<style scoped>
.card-tools {
  float: right;
}

.btn-group .btn {
  margin-right: 5px;
}

.btn-group .btn:last-child {
  margin-right: 0;
}
</style>


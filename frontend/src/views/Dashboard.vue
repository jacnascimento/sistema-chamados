<template>
  <div class="content">
    <div class="container-fluid">
      <Breadcrumb
        :breadcrumbItems="breadcrumbItems"
        pageTitle="Dashboard"
      />
      
      <!-- Cards de Estatísticas -->
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avatar-sm rounded">
                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                      <i class="mdi mdi-ticket font-20"></i>
                    </span>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="mb-1">{{ stats.totalTickets }}</h5>
                  <p class="text-muted mb-0">Total de Chamados</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avatar-sm rounded">
                    <span class="avatar-title bg-warning-lighten text-warning rounded">
                      <i class="mdi mdi-clock font-20"></i>
                    </span>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="mb-1">{{ stats.openTickets }}</h5>
                  <p class="text-muted mb-0">Chamados Abertos</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avatar-sm rounded">
                    <span class="avatar-title bg-info-lighten text-info rounded">
                      <i class="mdi mdi-progress-clock font-20"></i>
                    </span>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="mb-1">{{ stats.inProgressTickets }}</h5>
                  <p class="text-muted mb-0">Em Andamento</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avatar-sm rounded">
                    <span class="avatar-title bg-success-lighten text-success rounded">
                      <i class="mdi mdi-check-circle font-20"></i>
                    </span>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="mb-1">{{ stats.closedTickets }}</h5>
                  <p class="text-muted mb-0">Chamados Fechados</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Gráfico e Tabela de Chamados Recentes -->
      <div class="row">
        <div class="col-xl-8">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Chamados por Status</h4>
            </div>
            <div class="card-body">
              <div class="text-center">
                <div class="row">
                  <div class="col-4">
                    <div class="text-center">
                      <h3 class="text-warning">{{ stats.openTickets }}</h3>
                      <p class="text-muted">Abertos</p>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="text-center">
                      <h3 class="text-info">{{ stats.inProgressTickets }}</h3>
                      <p class="text-muted">Em Andamento</p>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="text-center">
                      <h3 class="text-success">{{ stats.closedTickets }}</h3>
                      <p class="text-muted">Fechados</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-4">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Chamados por Prioridade</h4>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                  <span>Alta</span>
                  <span>{{ stats.highPriorityTickets }}</span>
                </div>
                <div class="progress" style="height: 6px;">
                  <div class="progress-bar bg-danger" :style="{ width: getPriorityPercentage('Alta') + '%' }"></div>
                </div>
              </div>
              <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                  <span>Média</span>
                  <span>{{ stats.mediumPriorityTickets }}</span>
                </div>
                <div class="progress" style="height: 6px;">
                  <div class="progress-bar bg-warning" :style="{ width: getPriorityPercentage('Média') + '%' }"></div>
                </div>
              </div>
              <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                  <span>Baixa</span>
                  <span>{{ stats.lowPriorityTickets }}</span>
                </div>
                <div class="progress" style="height: 6px;">
                  <div class="progress-bar bg-success" :style="{ width: getPriorityPercentage('Baixa') + '%' }"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabela de Chamados Recentes -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Chamados Recentes</h4>
              <div class="card-tools">
                <router-link to="/chamados" class="btn btn-primary btn-sm">
                  Ver Todos
                </router-link>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Título</th>
                      <th>Status</th>
                      <th>Prioridade</th>
                      <th>Responsável</th>
                      <th>Data</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="ticket in recentTickets" :key="ticket.id">
                      <td>#{{ ticket.id }}</td>
                      <td>{{ ticket.title }}</td>
                      <td>
                        <span :class="getStatusClass(ticket.status)">
                          {{ ticket.status }}
                        </span>
                      </td>
                      <td>
                        <span :class="getPriorityClass(ticket.priority)">
                          {{ ticket.priority }}
                        </span>
                      </td>
                      <td>{{ ticket.assignee }}</td>
                      <td>{{ formatDate(ticket.createdAt) }}</td>
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

export default {
  name: 'Dashboard',
  components: {
    Breadcrumb
  },
  data() {
    return {
      tickets: [
        {
          id: 1,
          title: 'Problema com impressora',
          status: 'Aberto',
          priority: 'Alta',
          assignee: 'João Silva',
          createdAt: new Date('2024-01-15')
        },
        {
          id: 2,
          title: 'Sistema lento',
          status: 'Em Andamento',
          priority: 'Média',
          assignee: 'Maria Santos',
          createdAt: new Date('2024-01-14')
        },
        {
          id: 3,
          title: 'Erro no login',
          status: 'Fechado',
          priority: 'Baixa',
          assignee: 'Pedro Costa',
          createdAt: new Date('2024-01-13')
        },
        {
          id: 4,
          title: 'Falha na rede',
          status: 'Aberto',
          priority: 'Alta',
          assignee: 'Ana Oliveira',
          createdAt: new Date('2024-01-12')
        },
        {
          id: 5,
          title: 'Atualização de software',
          status: 'Em Andamento',
          priority: 'Média',
          assignee: 'Carlos Lima',
          createdAt: new Date('2024-01-11')
        }
      ]
    }
  },
  computed: {
    breadcrumbItems() {
      return [
        { text: 'Sistema', href: '/', active: false },
        { text: 'Dashboard', href: '', active: true }
      ]
    },
    stats() {
      const total = this.tickets.length
      const open = this.tickets.filter(t => t.status === 'Aberto').length
      const inProgress = this.tickets.filter(t => t.status === 'Em Andamento').length
      const closed = this.tickets.filter(t => t.status === 'Fechado').length
      const highPriority = this.tickets.filter(t => t.priority === 'Alta').length
      const mediumPriority = this.tickets.filter(t => t.priority === 'Média').length
      const lowPriority = this.tickets.filter(t => t.priority === 'Baixa').length

      return {
        totalTickets: total,
        openTickets: open,
        inProgressTickets: inProgress,
        closedTickets: closed,
        highPriorityTickets: highPriority,
        mediumPriorityTickets: mediumPriority,
        lowPriorityTickets: lowPriority
      }
    },
    recentTickets() {
      return this.tickets.slice(0, 5) // Mostra apenas os 5 mais recentes
    }
  },
  methods: {
    getStatusClass(status) {
      const classes = {
        'Aberto': 'badge bg-warning',
        'Em Andamento': 'badge bg-info',
        'Fechado': 'badge bg-success',
        'Cancelado': 'badge bg-danger'
      }
      return classes[status] || 'badge bg-secondary'
    },
    getPriorityClass(priority) {
      const classes = {
        'Alta': 'badge bg-danger',
        'Média': 'badge bg-warning',
        'Baixa': 'badge bg-success'
      }
      return classes[priority] || 'badge bg-secondary'
    },
    getPriorityPercentage(priority) {
      const total = this.tickets.length
      const count = this.tickets.filter(t => t.priority === priority).length
      return total > 0 ? Math.round((count / total) * 100) : 0
    },
    formatDate(date) {
      return date.toLocaleDateString('pt-BR')
    }
  }
}
</script>

<style scoped>
.card-tools {
  float: right;
}

.avatar-sm {
  width: 48px;
  height: 48px;
}

.avatar-title {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
}

.progress {
  background-color: #f8f9fa;
}
</style>

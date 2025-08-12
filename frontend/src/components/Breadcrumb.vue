<template>
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li 
              v-for="(item, index) in breadcrumbItems" 
              :key="index"
              :class="['breadcrumb-item', { 'active': item.active }]"
            >
              <a v-if="!item.active" :href="item.href">{{ item.text }}</a>
              <span v-else>{{ item.text }}</span>
            </li>
          </ol>
        </div>
        <h4 class="page-title">{{ pageTitle }}</h4>
      </div>
    </div>
  </div>
  <!-- end page title -->
</template>

<script>
export default {
  name: 'Breadcrumb',
  props: {
    breadcrumbItems: {
      type: Array,
      required: true,
      default: () => [
        { text: 'UBold', href: 'javascript: void(0);', active: false },
        { text: 'Extra Pages', href: 'javascript: void(0);', active: false },
        { text: 'Starter', href: '', active: true }
      ]
    },
    pageTitle: {
      type: String,
      required: true,
      default: 'Starter'
    }
  }
}
</script>

<style scoped>
/* Estilos específicos do Breadcrumb podem ser adicionados aqui */
</style>

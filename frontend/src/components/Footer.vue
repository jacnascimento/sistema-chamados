<template>
  <!-- Footer Start -->
  <footer class="footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div>{{ currentYear }} © {{ companyName }} - <a :href="companyUrl" target="_blank">{{ companyUrlText }}</a></div>
        </div>
      </div>
    </div>
  </footer>
  <!-- end Footer -->
</template>

<script>
export default {
  name: 'Footer',
  props: {
    companyName: {
      type: String,
      required: true,
      default: 'Ubold'
    },
    companyUrl: {
      type: String,
      required: true,
      default: 'https://coderthemes.com/'
    },
    companyUrlText: {
      type: String,
      required: true,
      default: 'Coderthemes.com'
    }
  },
  computed: {
    currentYear() {
      return new Date().getFullYear()
    }
  }
}
</script>

<style scoped>
/* Estilos específicos do Footer podem ser adicionados aqui */
</style>

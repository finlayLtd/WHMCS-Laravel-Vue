<template>
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <li class="page-item" :class="{ disabled: currentPage === 1 }">
        <a class="page-link" href="#" @click="changePage(currentPage - 1)">{{ $t('Previous') }}</a>
      </li>
      <li v-if="currentPage > 3" class="page-item">
        <a class="page-link" href="#" @click="changePage(1)">1</a>
      </li>
      <li v-if="currentPage > 4" class="page-item disabled">
        <span class="page-link">...</span>
      </li>
      <li v-for="page in pagesToShow" :key="page" class="page-item" :class="{ active: currentPage === page }">
        <a class="page-link" href="#" @click="changePage(page)">{{ page }}</a>
      </li>
      <li v-if="currentPage < totalPages - 3" class="page-item disabled">
        <span class="page-link">...</span>
      </li>
      <li v-if="currentPage < totalPages - 2" class="page-item">
        <a class="page-link" href="#" @click="changePage(totalPages)">{{ totalPages }}</a>
      </li>
      <li class="page-item" :class="{ disabled: currentPage === totalPages }">
        <a class="page-link" href="#" @click="changePage(currentPage + 1)">{{ $t('Next') }}</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: {
    currentPage: Number,
    totalPages: Number,
  },
  computed: {
    pagesToShow() {
      const pages = [];
      let startPage = Math.max(1, this.currentPage - 2);
      let endPage = Math.min(this.totalPages, this.currentPage + 2);
      for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
      }
      return pages;
    },
  },
  methods: {
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.$emit('page-changed', page);
      }
    },
  },
};
</script>
<!-- <template>
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" href="#" @click="changePage(currentPage - 1)">{{ $t('Previous') }}</a>
        </li>
        <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: currentPage === page }">
          <a class="page-link" href="#" @click="changePage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" href="#" @click="changePage(currentPage + 1)">{{ $t('Next') }}</a>
        </li>
      </ul>
    </nav>
  </template>
  
  <script>
  export default {
    props: {
      currentPage: Number,
      totalPages: Number,
    },
    methods: {
      changePage(page) {
        if (page >= 1 && page <= this.totalPages) {
          this.$emit('page-changed', page);
        }
      },
    },
  };
  </script> -->
  
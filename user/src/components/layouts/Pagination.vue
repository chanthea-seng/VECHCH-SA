<template>
<loadingView v-if="article.loading"/>
<div class="mb-5 mt-2" :class="{'d-none' : totalPage == 1}">
  <nav aria-label="Page">
    <ul class="pagination page_component">
      <li class="page-item" :class="{'page-item unactive':currentPage === 1}">
        <a class="page-link prev icon" href="#" aria-label="Previous" @click.prevent="changePage(currentPage - 1)">
          <i class="fa-solid fa-chevron-left"></i>
        </a>
      </li>
      <!-- ========================== -->
      <li v-for="page in pages" :key="page" class="page-item" :class="{ 'active': page === currentPage, 'unactive': page === '...'}">
        <a v-if="loadingPagination === page" class="page-link" :class="{'loading':article.paginationLoading == true}" @click.prevent="changePage(page)">
          <div class="loader"></div>
        </a>
        <a v-else class="page-link btn" @click.prevent="changePage(page)">
          {{ page }}
        </a>
      </li>
      <!-- ========================== -->
      <li class="page-item" :class="{'page-item unactive':currentPage === totalPage}">
        <a class="page-link next icon" href="#" aria-label="Next" @click.prevent="changePage(currentPage + 1)">
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </li>
    </ul>
  </nav>
</div>
</template>
<script setup>
import loadingView from '@/views/loading/loadingView.vue';
import { onMounted, ref, computed, watch, onBeforeUnmount } from 'vue';
import { articleStore } from '@/stores/articalStore';

const article = articleStore();
const pages = ref([]);
const currentPage = computed(() => article.currentPage);
const totalPage = computed(() => article.totalPage); 
const loadingPagination = ref(null);
onMounted(() => {
  article.fetchAllFunctions();
  article.paginateArticle(currentPage.value);
})
onBeforeUnmount(() => {
  sessionStorage.removeItem('currentPage');
  article.paginateArticle(1); 
});
const generatePagination = () => {
  let pagination = [];
  if(totalPage.value <= 4){
    pagination = Array.from({length: totalPage.value}, (_, i)=> i + 1);
  }
  else{
    if(currentPage.value < 4){
      pagination = [1, 2 , 3, 4,"...", totalPage.value]
    }
    else if(currentPage.value > totalPage.value - 3){
      pagination = [1, "...", totalPage.value-3, totalPage.value-2, totalPage.value-1, totalPage.value]
    }else{
      pagination = [1, "...", currentPage.value-1, currentPage.value, currentPage.value + 1, "...", totalPage.value]
    }
  }
  pages.value = pagination
}

watch([totalPage, currentPage], () => {
  generatePagination();
}, { immediate: true });

const changePage = (p) => {
  if(p === '...' || p < 1 || p > totalPage.value) return;
  loadingPagination.value = p
  article.paginateArticle(p).finally(() => {
    loadingPagination.value = null
    window.scrollTo({top: 0, behavior: 'smooth'});
  });
  generatePagination();
}

</script>
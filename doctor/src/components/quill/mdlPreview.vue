<template>
  <div
    class="modal fade"
    id="mdlPreview"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-10 mx-auto">
                <div class="content">
                  <div class="d-flex justify-content-between">
                    <span
                      class="sc-title-tag box-shadow"
                      v-if="art.category_id"
                    >
                      {{
                        postArticleStore.getCategoryLocalName(art.category_id)
                      }}
                    </span>
                  </div>
                  <div class="my-3">
                    <h4
                      class="sc-title-meduim text-color-900 mb-0 text-white w-75"
                    >
                      {{ art.title }}
                    </h4>
                    <p>
                      {{ art.short_description }}
                    </p>
                  </div>
                  <div class="col-12 position-relative">
                    <img
                      :src="art.thumbnail"
                      class="thumbnail-img"
                      alt="thumbnail"
                    />
                  </div>
                  <div v-html="art.content" class="mb-3 content-control"></div>
                  <div class="d-flex column-gap-3">
                    <p>
                      {{
                        postArticleStore
                          .getTagLocalNames(art.tag_ids)
                          .join(", ")
                      }}
                    </p>

                    <!-- <div
                      class="section-title-tag mb-3"
                      v-for="tag in art.tags"
                      :key="tag.id"
                    >
                      {{ tag.local_name }}
                    </div> -->
                  </div>
                  <!-- <div class="d-flex align-items-center">
                    <i class="bi bi-clock-history me-2 fs-5"></i>
                    <p class="mb-0 text-color-text fw-medium txt-small">
                      ចុះផ្សាយនៅថ្ងៃ៖
                      {{ postArticleStore.articaleDetails.local_updated_at }}
                    </p>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="container">
            <div class="col-10">
              <div class="d-flex justify-content-end">
                <button
                  type="button"
                  class="cancel-btn"
                  data-bs-dismiss="modal"
                >
                  ចាកចេញ
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import primaryBtn from "../global/primaryBtn.vue";
import { Modal } from "bootstrap/dist/js/bootstrap.bundle";
import { usePostArticle } from "@/stores/postArticleStore";
import { computed, onMounted, ref, watch } from "vue";

const postArticleStore = usePostArticle();
const art = computed(() => postArticleStore.article);

onMounted(async () => {
  postArticleStore.MdlPreview = Modal.getOrCreateInstance(
    document.getElementById("mdlPreview")
  );
//   postArticleStore.articleId = sessionStorage.getItem("articleId");
//   if (postArticleStore.articleId != 0) {
//     await postArticleStore.getSingleArticle(postArticleStore.articleId);
//   }
});

// watch(
//   () => postArticleStore.article,
//   (newDetails) => {
//     console.log("Updated Article Details:", newDetails);	
//   }
// );
</script>

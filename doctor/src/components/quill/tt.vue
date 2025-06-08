<template>
  <div class="col-12">
    <div class="quill-wrapper">
      <div class="custom-toolbar">
        <div class="d-flex column-gap-1">
          <!-- Text Size -->
          <select
            class="form-select"
            @change="formatText('size', $event.target.value)"
          >
            <option value="small">Small</option>
            <option value="">Normal</option>
            <option value="large">Large</option>
            <option value="huge">Huge</option>
          </select>

          <!-- Text Formatting -->
          <button @click="formatText('bold')">
            <i class="fas fa-bold"></i>
          </button>
          <button @click="formatText('italic')">
            <i class="fas fa-italic"></i>
          </button>
          <button @click="formatText('underline')">
            <i class="fas fa-underline"></i>
          </button>
          <button @click="formatText('strike')">
            <i class="fas fa-strikethrough"></i>
          </button>

          <!-- Headers -->
          <button @click="formatText('header', 1)">H1</button>
          <button @click="formatText('header', 2)">H2</button>

          <!-- Alignment -->
          <button @click="formatText('align', '')">
            <i class="fas fa-align-left"></i>
          </button>
          <button @click="formatText('align', 'center')">
            <i class="fas fa-align-center"></i>
          </button>
          <button @click="formatText('align', 'right')">
            <i class="fas fa-align-right"></i>
          </button>
          <button @click="formatText('align', 'justify')">
            <i class="fas fa-align-justify"></i>
          </button>

          <!-- Lists -->
          <button @click="formatText('list', 'ordered')">
            <i class="fas fa-list-ol"></i>
          </button>
          <button @click="formatText('list', 'bullet')">
            <i class="fas fa-list-ul"></i>
          </button>

          <!-- Blockquote -->
          <button @click="formatText('blockquote')">
            <i class="fas fa-quote-right"></i>
          </button>

          <!-- Insert Link & Image -->
          <button @click="insertLink"><i class="fas fa-link"></i></button>
          <button @click="insertImage"><i class="fas fa-image"></i></button>

          <!-- Text Direction -->
          <button @click="formatText('direction', 'ltr')">LTR</button>
          <button @click="formatText('direction', 'rtl')">RTL</button>
        </div>
        <div>
          <a role="button" class="secondary-btn" @click="onClickMdlPreview()">
            <span><i class="fas fa-eye"></i> មើលជាមុន</span>
          </a>
        </div>
      </div>

      <div id="editor" ref="editorRef"></div>
      <mdlPreview />
    </div>
  </div>
</template>
<script setup>
import mdlPreview from "./mdlPreview.vue";
import { ref, onMounted, watch } from "vue";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import axios from "axios";
import { usePostArticle } from "@/stores/postArticleStore";

const storePostArticle = usePostArticle();

const onClickMdlPreview = () => {
  storePostArticle.getSingleArticle(storePostArticle.articleId);
  storePostArticle.MdlPreview.show();
};

const editorRef = ref(null);
let quill = ref();
const uploadedImages = ref([]);

onMounted(() => {
  quill = new Quill("#editor", {
    theme: "snow",
    modules: { toolbar: false },
  });
  quill.root.innerHTML = storePostArticle.article.content || "";
  quill.on("text-change", () => {
    cleanupImages();
    storePostArticle.article.content = quill.root.innerHTML;
  });
});

// Function to apply formatting
const formatText = (format, value = true) => {
  if (quill) {
    quill.format(format, value);
  }
};

// Function to insert a link
const insertLink = () => {
  const url = prompt("Enter link URL:");
  if (url) {
    quill.format("link", url);
  }
};

// Function to insert image
const insertImage = () => {
  const input = document.createElement("input");
  input.setAttribute("type", "file");
  input.setAttribute("accept", "image/*");
  input.click();

  input.onchange = async () => {
    const file = input.files[0];
    if (file) {
      try {
        // console.log(file);
        const imageUrl = await uploadImage(file);
        if (imageUrl) {
          const range = quill.getSelection();
          const index = range ? range.index : quill.getLength(); // If no selection, insert at end
          quill.insertEmbed(index, "image", imageUrl);
          uploadedImages.value.push(imageUrl); // Store inserted image
        }
      } catch (error) {
        // console.error("Image upload failed:", error);
        // alert("Image upload failed. Please try again.");
      }
    }
  };
};

// Function to upload image
const uploadImage = async (file) => {
  const formData = new FormData();
  formData.append("image", file);
  try {
    alert(storePostArticle.articleId);
    const response = await axios.post(
      `/api/articles/upload-image/${storePostArticle.articleId}`,
      formData
    );
    storePostArticle.isPublish = 0;
    storePostArticle.onClickSubmit();
    return response.data.url;
  } catch (error) {
    // console.error("Upload failed:", error);
  }
};

// Function to clean up deleted images
const cleanupImages = async () => {
  storePostArticle.article.content = quill.root.innerHTML;
  const currentImages = Array.from(quill.root.querySelectorAll("img")).map(
    (img) => img.getAttribute("src")
  );

  // Find images that were uploaded but are now missing
  const removedImages = uploadedImages.value.filter(
    (url) => !currentImages.includes(url)
  );

  for (const imageUrl of removedImages) {
    await deleteImage(imageUrl);
    uploadedImages.value = uploadedImages.value.filter(
      (url) => url !== imageUrl
    );
  }
};

const deleteImage = async (imageUrl) => {
  try {
    const params = new URLSearchParams();
    params.append("url", imageUrl);

    await axios.delete(
      `/api/articles/delete-image/${storePostArticle.articleId}`,
      {
        data: params,
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );
    storePostArticle.isPublish = 0;
    storePostArticle.onClickSubmit();
  } catch (error) {
    // console.error("Failed to delete image:", error);
  }
};
</script>

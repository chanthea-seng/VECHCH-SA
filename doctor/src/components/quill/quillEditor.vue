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
import { ref, onMounted, watch, nextTick, shallowRef } from "vue";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import axios from "axios";
import { usePostArticle } from "@/stores/postArticleStore";
import { useNotyfStore } from "@/stores/notfyStore";
const storePostArticle = usePostArticle();
const notyf = useNotyfStore();
const editorRef = ref(null);
const quillInstance = shallowRef(null);
const uploadedImages = ref([]);

const onClickMdlPreview = async () => {
//   await storePostArticle.getSingleArticle(storePostArticle.articleId);
  storePostArticle.MdlPreview.show();
};
const Size = Quill.import("attributors/class/size"); // Use class-based sizes
Size.whitelist = ["small", "large", "huge", false];
Quill.register(Size, true);

onMounted(() => {
  nextTick(() => {
    if (!editorRef.value) {
      return;
    }
    quillInstance.value = new Quill(editorRef.value, {
      theme: "snow",
      modules: {
        toolbar: false, // Custom toolbar
      },
      formats: [
        "bold",
        "italic",
        "underline",
        "strike",
        "size",
        "header",
        "align",
        "list",
        "blockquote",
        "link",
        "image",
        "direction",
      ],
    });
    quillInstance.value.on("text-change", () => {
      cleanupImages();
      storePostArticle.article.content = quillInstance.value.root.innerHTML;
    });
  });
});

const cleanupImages = () => {
  // Use a shorter debounce or ensure content is stable
  setTimeout(async () => {
    // Ensure content is up-to-date
    const currentContent = quillInstance.value.root.innerHTML;
    storePostArticle.article.content = currentContent;

    const currentImages = Array.from(
      quillInstance.value.root.querySelectorAll("img")
    ).map((img) => img.getAttribute("src"));

    // Find images that are no longer in the editor
    const removedImages = uploadedImages.value.filter(
      (url) => url && !currentImages.includes(url)
    );

    // Delete removed images
    for (const imageUrl of removedImages) {
      try {
        await deleteImage(imageUrl);
        uploadedImages.value = uploadedImages.value.filter(
          (url) => url !== imageUrl
        );
      } catch (error) {
        // console.error(`Failed to delete image ${imageUrl}:`, error);
      }
    }
  }, 100); // Reduced debounce to 100ms for faster response
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
  } catch (error) {}
};
watch(
  () => storePostArticle.article.content,
  (newContent) => {
    if (!quillInstance.value || newContent == null) {
      return;
    }

    if (newContent !== quillInstance.value.root.innerHTML) {
      quillInstance.value.root.innerHTML = newContent;
      const initialImages = Array.from(
        quillInstance.value.root.querySelectorAll("img")
      ).map((img) => img.getAttribute("src"));
      uploadedImages.value = [
        ...new Set([...uploadedImages.value, ...initialImages]),
      ]; // Avoid duplicates
    }
  }
);
const formatText = (format, value = true) => {
  if (!quillInstance.value) {
    return;
  }
  const toggleFormats = ["bold", "italic", "underline", "strike", "blockquote"];

  const resetFormats = {
    align: "", // Default: left
    size: "", // Default: normal
    header: false, // Default: paragraph
    list: false, // Default: no list
    direction: "ltr", // Default: LTR
  };

  if (toggleFormats.includes(format)) {
    const currentFormat = quillInstance.value.getFormat()[format];
    quillInstance.value.format(format, !currentFormat);
  } else if (format in resetFormats) {
    // Handle non-boolean formats with reset
    const currentFormat = quillInstance.value.getFormat()[format];
    // If the same value is selected, reset to default; otherwise, apply the value
    if (currentFormat === value) {
      quillInstance.value.format(format, resetFormats[format]);
    } else {
      quillInstance.value.format(format, value);
    }
  } else {
    // Other formats (e.g., link)
    quillInstance.value.format(format, value);
  }
};

const insertLink = () => {
  if (!quillInstance.value) {
    return;
  }

  const url = prompt("Enter link URL:");
  if (url) {
    quillInstance.value.format("link", url);
  }
};

const insertImage = () => {
  if (!quillInstance.value) {
    return;
  }
  const input = document.createElement("input");
  input.type = "file";
  input.accept = "image/*";
  input.click();

  input.onchange = async () => {
    const file = input.files?.[0];
    if (file) {
      const maxSizeInMB = 1;
      const maxSizeInBytes = maxSizeInMB * 1024 * 1024;

      if (file.size > maxSizeInBytes) {
        notyf.warning("ទំហំរូបភាពធំពេក។ ត្រូវតែតិចជាង 1mb");
        return;
      }

      try {
        const imageUrl = await uploadImage(file);
        if (imageUrl) {
          await nextTick();
          const range = quillInstance.value.getSelection() || {
            index: quillInstance.value.getLength(),
          };
          quillInstance.value.insertEmbed(range.index, "image", imageUrl);
          uploadedImages.value.push(imageUrl);
          await storePostArticle.onClickSubmit();
        }
      } catch (error) {}
    }
  };
};

const uploadImage = async (file) => {
  const formData = new FormData();
  formData.append("image", file);
  try {
    const response = await axios.post(
      `/api/articles/upload-image/${storePostArticle.articleId}`,
      formData
    );
    storePostArticle.isPublish = 0;
    return response.data.url;
  } catch (error) {
    notyf.warning(
      "សូមអភ័យទោស អ្នកអាចបង្ហោះរូបភាពបានតែ 6 ប៉ុណ្ណោះ រួមទាំងរូបភាពតូចៗផងដែរ។"
    );
  }
};
</script>

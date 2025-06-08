<template>
  <button
    class="ripple-btn"
    :disabled="disabled || loading"
    @mousedown="handleRipple"
    @click="handleClick"
  >
    <span v-html="label"></span>
    <!-- Allow HTML inside label -->
    <span v-if="loading" class="d-inline-block ms-1 loader"></span>
    <span
      v-for="ripple in ripples"
      :key="ripple.id"
      class="ripple"
      :style="ripple.style"
    ></span>
  </button>
</template>

<script>
import { ref } from "vue";
import { useRipple } from "@/assets/js/globalScript";

export default {
  props: {
    label: { type: String, default: "Click Me" },
    disabled: { type: Boolean, default: false },
    clickEvent: { type: Function, required: false },
  },
  setup(props) {
    const { ripples, addRipple } = useRipple();
    const loading = ref(false);

    const handleClick = async (e) => {
      e.preventDefault();
      if (loading.value || props.disabled) return;
      loading.value = true;
      try {
        await props.clickEvent();
      } catch (error) {
        // console.log("Button action failed:", error);
      } finally {
        loading.value = false;
        // console.log(props.label);
      }
    };

    const handleRipple = (event) => {
      if (!props.disabled && !loading.value) {
        addRipple(event, event.currentTarget);
      }
    };

    return { ripples, loading, handleClick, handleRipple };
  },
};
</script>

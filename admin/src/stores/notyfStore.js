import { defineStore } from "pinia";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";

export const useNotyfStore = defineStore("notyf", () => {
  const notyf = new Notyf({
    duration: 4000, // Notification stays for 4 seconds
    position: { x: "right", y: "bottom" }, // Adjust position
    dismissible: true, // Allow closing notifications
    types: [
      {
        type: "success",
        background: "#4CAF50", // Green
        duration: 3000,
        icon: false,
      },
      {
        type: "error",
        background: "#F44336", // Red
        duration: 4000,
        icon: false,
      },
      {
        type: "warning",
        background: "#FFC107", // Yellow
        duration: 3500,
        icon: false,
      },
      {
        type: "info",
        background: "#2196F3", // Blue
        duration: 3500,
        icon: false,
      },
    ],
  });

  function success(message) {
    notyf.open({ type: "success", message });
  }

  function error(message) {
    notyf.open({ type: "error", message });
  }

  function warning(message) {
    notyf.open({ type: "warning", message });
  }

  function info(message) {
    notyf.open({ type: "info", message });
  }

  return { success, error, warning, info };
});

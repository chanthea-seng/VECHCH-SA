// useRipple.js

import { ref } from "vue";

export function useRipple() {
    const ripples = ref([]);  // This state is now scoped to each button instance.

    const addRipple = (event, targetElement) => {
        const rect = targetElement.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        const ripple = {
            id: Date.now(),
            style: {
                width: `${size}px`,
                height: `${size}px`,
                left: `${x}px`,
                top: `${y}px`,
            },
        };

        ripples.value.push(ripple);

        setTimeout(() => {
            ripples.value = ripples.value.filter((r) => r.id !== ripple.id);
        }, 600); // Remove ripple after animation
    };

    return { ripples, addRipple };
}

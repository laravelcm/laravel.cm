import "@tailwindplus/elements";

import "../../vendor/laravelcm/livewire-slide-overs/resources/js/slide-over";
import "./utils/helpers";
import "./utils/scrollspy";
import markdownEditor from "./components/markdown-editor";

// Enregistrer le composant Alpine globalement
document.addEventListener("alpine:init", () => {
  Alpine.data("markdownEditor", markdownEditor);
});

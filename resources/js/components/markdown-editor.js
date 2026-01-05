import Editor from "@toast-ui/editor";
import "@toast-ui/editor/dist/i18n/fr-fr";
import "@toast-ui/editor/dist/i18n/en-us";
import "@toast-ui/editor/dist/toastui-editor.css";
import "@toast-ui/editor/dist/theme/toastui-editor-dark.css";
import codeSyntaxHighlight from "@toast-ui/editor-plugin-code-syntax-highlight";
import Prism from "prismjs";
import "prismjs/themes/prism.css";

export default (config = {}) => ({
  editor: null,
  isDark: false,

  init() {
    this.isDark = document.documentElement.classList.contains("dark");

    const defaultConfig = {
      el: this.$refs.editor,
      height: config.height || "350px",
      initialEditType: "markdown",
      previewStyle:
        config.preview === true ? config.previewStyle || "vertical" : "tab",
      usageStatistics: false,
      hideModeSwitch: config.hideModeSwitch ?? true,
      theme: this.isDark ? "dark" : "light",
      toolbarItems: config.toolbarItems || [
        ["heading", "bold", "italic", "strike"],
        ["hr", "quote"],
        ["ul", "ol", "task", "indent", "outdent"],
        ["table", "link", "image"],
        ["code", "codeblock"],
      ],
      placeholder: config.placeholder || "",
      initialValue: this.$wire.$get(config.model) || "",
      language: config.language,
      plugins: [[codeSyntaxHighlight, { highlighter: Prism }]],
    };

    this.editor = new Editor(defaultConfig);

    // Sync avec Livewire
    this.editor.on("change", () => {
      this.$wire.$set(config.model, this.editor.getMarkdown());
    });

    // Écouter les changements depuis Livewire
    this.$watch("$wire." + config.model, (value) => {
      if (this.editor.getMarkdown() !== value) {
        this.editor.setMarkdown(value || "");
      }
    });

    // Observer les changements de dark mode
    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (mutation.attributeName === "class") {
          const isDarkNow = document.documentElement.classList.contains("dark");
          if (this.isDark !== isDarkNow) {
            this.isDark = isDarkNow;
            // Recréer l'éditeur avec le nouveau thème
            const currentValue = this.editor.getMarkdown();
            this.editor.destroy();

            const newConfig = {
              ...defaultConfig,
              theme: this.isDark ? "dark" : "light",
              initialValue: currentValue,
            };

            this.editor = new Editor(newConfig);

            // Re-synchroniser avec Livewire
            this.editor.on("change", () => {
              this.$wire.$set(config.model, this.editor.getMarkdown());
            });
          }
        }
      });
    });

    observer.observe(document.documentElement, {
      attributes: true,
      attributeFilter: ["class"],
    });

    this.observer = observer;
  },

  destroy() {
    if (this.observer) {
      this.observer.disconnect();
    }

    if (this.editor) {
      this.editor.destroy();
    }
  },
});

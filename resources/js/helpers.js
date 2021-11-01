import hljs from 'highlight.js';
import Choices from 'choices.js';

// Create a multiselect element.
window.choices = (element) => {
  return new Choices(element, { maxItemCount: 3, removeItemButton: true });
};

// Syntax highlight code blocks.
window.highlightCode = (element) => {
  element.querySelectorAll('pre code').forEach((block) => {
    hljs.highlightBlock(block);
  });
};

// Create Capitalize string
window.capitalize = (string) => string.replace(/^\w/, (c) => c.toUpperCase());
// Create a snake case string
window.snakeCase = (string) => string && string.match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g).map(s => s.toLowerCase()).join('_');

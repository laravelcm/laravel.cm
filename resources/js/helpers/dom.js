import htm from 'htm/mini'

/**
 * Trouve la position de l'élément par rapport au haut de la page de manière recursive
 *
 * @param {HTMLElement} element
 * @param {HTMLElement|null} parent
 */
export function offsetTop(element, parent = null) {
  let top = element.offsetTop
  while ((element = element.offsetParent)) {
    if (parent === element) {
      return top
    }
    top += element.offsetTop
  }
  return top
}

/**
 * Crée un élément HTML
 *
 * Cette fonction ne couvre que les besoins de l'application, jsx-dom pourrait remplacer cette fonction
 *
 * @param {string} tagName
 * @param {object} attributes
 * @param {...HTMLElement|string} children
 * @return HTMLElement
 */
export function createElement(tagName, attributes = {}, ...children) {
  if (typeof tagName === "function") {
    return tagName(attributes)
  }

  const svgTags = ["svg", "use", "path", "circle", "g"]
  // On construit l'élément
  const e = !svgTags.includes(tagName)
    ? document.createElement(tagName)
    : document.createElementNS("http://www.w3.org/2000/svg", tagName)

  // On lui associe les bons attributs
  for (const k of Object.keys(attributes || {})) {
    if (typeof attributes[k] === "function" && k.startsWith("on")) {
      e.addEventListener(k.substr(2).toLowerCase(), attributes[k])
    } else if (k === "xlink:href") {
      e.setAttributeNS("http://www.w3.org/1999/xlink", "href", attributes[k])
    } else {
      e.setAttribute(k, attributes[k])
    }
  }

  // On aplatit les enfants
  children = children.reduce((acc, child) => {
    return Array.isArray(child) ? [...acc, ...child] : [...acc, child];
  }, []);

  // On ajoute les enfants à l'élément
  for (const child of children) {
    if (typeof child === "string" || typeof child === "number") {
      e.appendChild(document.createTextNode(child));
    } else if (child instanceof HTMLElement || child instanceof SVGElement) {
      e.appendChild(child);
    } else {
      console.error("Impossible d'ajouter l'élément", child, typeof child);
    }
  }
  return e;
}

/**
 * CreateElement version Tagged templates
 * @type {(strings: TemplateStringsArray, ...values: any[]) => (HTMLElement[] | HTMLElement)}
 */
export const html = htm.bind(createElement)

/**
 * Génère une classe à partir de différentes variables
 *
 * @param  {...string|null} classnames
 */
export function classNames(...classnames) {
  return classnames.filter((classname) => classname !== null && classname !== false).join(" ")
}

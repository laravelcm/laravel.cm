/**
 * Créer une chaîne de cas de serpent
 *
 * @param string
 * @returns {*}
 */
window.snakeCase = (string) => string && string.match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g).map(s => s.toLowerCase()).join('_');

/**
 * Injecte la fonction dans le contexte global
 *
 * @param {number} number
 * @returns
 */
window.formatMoney = (number) => formatMoney(number);

/**
 * Ajoute des sauts de ligne automatiquement sur une chaine
 *
 * @param {string} str
 * @return {string}
 */
export function nl2br (str) {
  return str.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2')
}

/**
 * Formate un nombre
 *
 * @param {number} amount
 * @return {string}
 */
export function formatMoney (amount) {
  return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XAF' }).format(amount)
}

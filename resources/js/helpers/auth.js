/**
 * Vérifie si l'utilisateur est un modérateur
 *
 * @return {boolean}
 */
export function isAdmin () {
  return window.laravel.isModerator === true
}

/**
 * Vérifie si l'utilisateur est connecté
 *
 * @return {boolean}
 */
export function isAuthenticated () {
  return window.laravel.user !== null
}

/**
 * Retourne l'utilisateur connecté
 *
 * @returns {*}
 */
export function currentUser () {
  return window.laravel.currentUser
}

/**
 * Vérifie si l'utilisateur est connecté
 *
 * @return {boolean}
 */
export function lastNotificationRead () {
  return window.laravel.notification
}

/**
 * Renvoie l'id de l'utilisateur
 *
 * @return {number|null}
 */
export function getUserId () {
  return window.laravel.user
}

/**
 * Vérifie si l'utilisateur connecté correspond à l'id passé en paramètre
 *
 * @param {number} userId
 * @return {boolean}
 */
export function canManage (userId) {
  if (isAdmin()) {
    return true
  }

  if (! userId) {
    return false
  }

  return window.laravel.user === parseInt(userId, 10)
}

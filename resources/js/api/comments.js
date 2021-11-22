import { jsonFetch } from '@helpers/api.js'

/**
 * Représentation d'un commentaire de l'API
 * @typedef {{id: number, username: string, avatar: string, content: string, createdAt: number, replies: ReplyResource[]}} ReplyResource
 */

/**
 * @param {number} target
 * @return {Promise<ReplyResource[]>}
 */
export async function findAllReplies (target) {
  return jsonFetch(`/api/replies/${target}`)
}

/**
 * @param {{target: number, user_id: int, body: string}} body
 * @return {Promise<Object>}
 */
export async function addReply (body) {
  return jsonFetch('/api/replies', {
    method: 'POST',
    body
  })
}

/**
 * @param {int} id
 * @param {int} userId
 * @return {Promise<ReplyResource>}
 */
export async function likeReply(id, userId) {
  return jsonFetch(`/api/like/${id}`, {
    method: 'POST',
    body: JSON.stringify({ userId })
  })
}

/**
 * @param {int} id
 * @return {Promise<null>}
 */
export async function deleteReply (id) {
  return jsonFetch(`/api/replies/${id}`, {
    method: 'DELETE'
  })
}

/**
 * @param {int} id
 * @param {string} body
 * @return {Promise<ReplyResource>}
 */
export async function updateReply (id, body) {
  return jsonFetch(`/api/replies/${id}`, {
    method: 'PUT',
    body: JSON.stringify({ body })
  })
}

import { jsonFetch } from '@helpers/api.js'

/**
 * @return {Promise<PremiumUserResource[]>}
 */
 export async function findPremiumUsers () {
  return jsonFetch(`/api/premium-users`)
}

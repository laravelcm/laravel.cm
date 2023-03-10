import Loader from '@components/Loader'
import { classNames } from '@helpers/dom.js'

export function PrimaryButton ({ children, ...props }) {
  return (
    <Button className='border border-transparent text-white bg-green-600 hover:bg-green-700' {...props}>
      {children}
    </Button>
  )
}

export function DefaultButton ({ children, ...props }) {
  return (
    <Button className='border border-skin-input shadow-sm bg-skin-button text-skin-base hover:bg-skin-button-hover' {...props}>
      {children}
    </Button>
  )
}

/**
 *
 * @param {*} children
 * @param {string} className
 * @param {string} size
 * @param {boolean} loading
 * @param {Object} props
 * @return {*}
 */
export function Button ({ children, className = '', loading = false, ...props }) {
  className = classNames('inline-flex items-center justify-center py-2 px-4 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500', className)
  return (
    <button className={className} disabled={loading} {...props}>
      {loading && <Loader />}
      {children}
    </button>
  )
}

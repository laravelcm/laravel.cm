import { useEffect, useState, useRef } from 'preact/hooks'

/**
 * Focus le premier champ dans l'élément correspondant à la ref
 *
 * @param {boolean} focus
 */
export function useAutofocus (ref, focus) {
  useEffect(() => {
    if (focus && ref.current) {
      const input = ref.current.querySelector('input, textarea')
      if (input) {
        input.focus()
      }
    }
  }, [focus, ref])
}

export function useAsyncEffect (fn, deps = []) {
  /* eslint-disable */
  useEffect(() => {
    fn()
  }, deps)
  /* eslint-enable */
}

/**
 * Hook permettant de détecter quand un élément devient visible à l'écran
 *
 * @export
 * @param {DOMNode reference} node
 * @param {Boolean} once
 * @param {Object} [options={}]
 * @returns {object} visibility
 */
export function useVisibility (node, once = true, options = {}) {
  const [visible, setVisibilty] = useState(false)
  const isIntersecting = useRef()

  const handleObserverUpdate = entries => {
    const ent = entries[0]

    if (isIntersecting.current !== ent.isIntersecting) {
      setVisibilty(ent.isIntersecting)
      isIntersecting.current = ent.isIntersecting
    }
  }

  const observer = once && visible ? null : new IntersectionObserver(handleObserverUpdate, options)

  useEffect(() => {
    const element = node instanceof HTMLElement ? node : node.current

    if (!element || observer === null) {
      return
    }

    observer.observe(element)

    return function cleanup () {
      observer.unobserve(element)
    }
  })

  return visible
}


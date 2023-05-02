import { createContext } from 'preact'
import { useContext, useEffect, useLayoutEffect, useRef, useState } from 'preact/hooks'
import { useMemo } from 'preact/compat'
import { useAutofocus } from '@helpers/hooks.js'

/**
 * Représente un champ, dans le contexte du formulaire
 *
 * @param {string} type
 * @param {string} name
 * @param {function} onInput
 * @param {string} value
 * @param {string} error
 * @param {boolean} autofocus
 * @param {function} component
 * @param {React.Children} children
 * @param {string} className
 * @param {string} wrapperClass
 * @param props
 */
export function Field ({
   name,
   onInput,
   value,
   error,
   children,
   type = 'text',
   className = '',
   wrapperClass = '',
   component = null,
   ...props
 }) {
  // Hooks
  const [dirty, setDirty] = useState(false)
  const ref = useRef(null)
  useAutofocus(ref, props.autofocus)
  const showError = error && !dirty

  function handleInput (e) {
    if (dirty === false) {
      setDirty(true)
    }
    if (onInput) {
      onInput(e)
    }
  }

  // Si le champs a une erreur et n'a pas été modifié
  if (showError) {
    className += ' border-red-300 text-red-500 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500'
  }

  // Les attributs à passer aux champs
  const attr = {
    name,
    id: name,
    className,
    onInput: handleInput,
    type,
    ...(value === undefined ? {} : { value }),
    ...props
  }

  // On trouve le composant à utiliser
  const FieldComponent = useMemo(() => {
    if (component) {
      return component
    }
    switch (type) {
      case 'textarea':
        return FieldTextarea
      case 'editor':
        return FieldEditor
      default:
        return FieldInput
    }
  }, [component, type])

  // Si l'erreur change on considère le champs comme "clean"
  useLayoutEffect(() => {
    setDirty(false)
  }, [error])

  return (
    <div className={`relative ${wrapperClass}`} ref={ref}>
      {children && <label htmlFor={name} className="block text-sm font-medium leading-5 text-skin-base">{children}</label>}
      <FieldComponent {...attr} />
      {showError && <p className='mt-2 text-sm text-red-500'>{error}</p>}
    </div>
  )
}

function FieldTextarea (props) {
  return <textarea {...props} />
}

function FieldInput (props) {
  return <input {...props} />
}

function FieldEditor (props) {
  const ref = useRef(null)
  useEffect(() => {
    if (ref.current) {
      ref.current.syncEditor()
    }
  }, [props.value])
  return <textarea {...props} is='markdown-editor' ref={ref} />
}

/**
 * Version contextualisée des champs pour le formulaire
 */

export const FormContext = createContext({
  errors: {},
  loading: false,
  emptyError: () => {}
})

/**
 * Représente un champs, dans le contexte du formulaire
 *
 * @param {string} type
 * @param {string} name
 * @param {React.Children} children
 * @param {object} props
 */
export function FormField ({ type = 'text', name, children, ...props }) {
  const { errors, emptyError, loading } = useContext(FormContext)
  const error = errors[name] || null
  return (
    <Field type={type} name={name} error={error} onInput={() => emptyError(name)} readonly={loading} {...props}>
      {children}
    </Field>
  )
}

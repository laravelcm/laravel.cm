import { memo } from 'preact/compat'
import { useCallback, useEffect, useMemo, useRef, useState } from 'preact/hooks'
import ContentLoader from 'react-content-loader'
import { ChatAltIcon } from '@heroicons/react/solid'
import { findAllReplies, addReply, updateReply, deleteReply, likeReply } from '@api/comments';
import { DefaultButton, PrimaryButton } from '@components/Button';
import { Field } from '@components/Form'
import { Markdown } from '@components/Markdown'
import { ChatIcon, HeartIcon } from '@components/Icon'
import { canManage, currentUser, isAuthenticated, getUserId } from '@helpers/auth'
import { scrollTo } from '@helpers/animation'
import { catchViolations } from '@helpers/api'
import { classNames } from '@helpers/dom'
import { useVisibility, useAsyncEffect } from '@helpers/hooks'

/**
 * Affiche les commentaires associé à un contenu
 *
 * @param {{target: number}} param
 */
export function Comments ({ target, parent }) {
  target = parseInt(target, 10)
  const element = useRef(null)
  const [state, setState] = useState({
    editing: null, // ID du commentaire en cours d'édition
    comments: null, // Liste des commentaires
    focus: null, // Commentaire à focus
    reply: null // Commentaire auquel on souhaite répondre
  })
  const count = state.comments ? state.comments.length : null
  const isVisible = useVisibility(parent)
  const comments = useMemo(() => {
    if (state.comments === null) {
      return null
    }
    return state.comments.filter(c => c.model_type === 'discussion')
  }, [state.comments])

  // Trouve les commentaire enfant d'un commentaire
  function repliesFor (comment) {
    return state.comments.filter(c => c.model_type === 'reply' && c.model_id === comment.id)
  }

  // On commence l'édition d'un commentaire
  const handleEdit = useCallback(comment => {
    setState(s => ({ ...s, editing: s.editing === comment.id ? null : comment.id }))
  }, [])

  // On met à jour (via l'API un commentaire)
  const handleUpdate = useCallback(async (comment, body) => {
    const newComment = { ...(await updateReply(comment.id, body)), parent: comment.model_id }
    setState(s => ({
      ...s,
      editing: null,
      comments: s.comments.map(c => (c === comment ? newComment : c))
    }))
  }, [])

  // On supprime un commentaire
  const handleDelete = useCallback(async comment => {
    await deleteReply(comment.id)
    setState(s => ({
      ...s,
      comments: s.comments.filter(c => c !== comment)
    }))
  }, [])

  // On répond à un commentaire
  const handleReply = useCallback(comment => {
    setState(s => ({ ...s, reply: comment.id }))
  }, [])
  const handleCancelReply = useCallback(() => {
    setState(s => ({ ...s, reply: null }))
  }, [])

  // On crée un nouveau commentaire
  const handleCreate = useCallback(
    async (data, parent) => {
      data = { ...data, target, parent, user_id: getUserId() }
      const newComment = await addReply(data)
      setState(s => ({
        ...s,
        focus: newComment.id,
        reply: null,
        comments: [...s.comments, newComment]
      }))
    },
    [target]
  )

  // On like un commentaire
  const handleLike = useCallback(async (comment) => {
    const likeComment = await likeReply(comment.id, getUserId())
    setState(s => ({
      ...s,
      editing: null,
      comments: s.comments.map(c => (c === comment ? likeComment : c))
    }))
  }, [])

  // On scroll jusqu'à l'élément si l'ancre commence par un "c"
  useAsyncEffect(async () => {
    if (window.location.hash.startsWith('#c')) {
      const comments = await findAllReplies(target)
      setState(s => ({
        ...s,
        comments,
        focus: window.location.hash.replace('#c', '')
      }))
    }
  }, [element])

  // On charge les commentaire dès l'affichage du composant
  useAsyncEffect(async () => {
    if (isVisible) {
      const comments = await findAllReplies(target)
      setState(s => ({ ...s, comments }))
    }
  }, [target, isVisible])

  // On se focalise sur un commentaire
  useEffect(() => {
    if (state.focus && comments) {
      scrollTo(document.getElementById(`c${state.focus}`))
      setState(s => ({ ...s, focus: null }))
    }
  }, [state.focus, comments])

  return (
    <div className="mt-6" ref={element}>
      <div>
        {isAuthenticated() ? (
          <CommentForm onSubmit={handleCreate} isRoot />
        ) : (
          <div className="relative">
            <div className="min-w-0 flex-1 filter blur-sm">
              <div>
                <label htmlFor="body" className="sr-only">
                  Commentaire
                </label>
                <Field
                  type='textarea'
                  name='body'
                  className="bg-skin-input shadow-sm focus:border-flag-green focus:ring-flag-green mt-1 block w-full text-skin-base focus:outline-none sm:text-sm font-normal border-skin-input rounded-md"
                  placeholder="Laisser un commentaire"
                  rows={4}
                  disabled
                />
                <div className="mt-6 flex items-center justify-end space-x-4">
                  <PrimaryButton type="button">
                    Commenter
                  </PrimaryButton>
                </div>
              </div>
            </div>
            <div className="absolute inset-0 flex items-center justify-center bg-skin-card bg-opacity-10 py-8">
              <p className="text-center font-sans text-skin-base">Veuillez vous <a href="/login" className="text-skin-primary hover:text-skin-primary-hover hover:underline">connecter</a> ou {' '}
                <a href="/register" className="text-skin-primary hover:text-skin-primary-hover hover:underline">créer un compte</a> pour participer à cette conversation.</p>
            </div>
          </div>
        )}
      </div>
      <div className="mt-10">
        {comments ? (
            <ul role="list" className="space-y-8">
              {comments.map((comment) => (
                <Comment
                  key={comment.id}
                  comment={comment}
                  editing={state.editing === comment.id}
                  onEdit={handleEdit}
                  onUpdate={handleUpdate}
                  onDelete={handleDelete}
                  onReply={handleReply}
                  onLike={handleLike}
                >
                  <ul role="list" className="space-y-5">
                    {repliesFor(comment).map(reply => (
                      <Comment
                        key={reply.id}
                        comment={reply}
                        editing={state.editing === reply.id}
                        onEdit={handleEdit}
                        onUpdate={handleUpdate}
                        onDelete={handleDelete}
                        onReply={handleReply}
                        onLike={handleLike}
                        isReply
                      >
                        {state.reply === comment.id && (
                          <CommentForm onSubmit={handleCreate} parent={comment.id} onCancel={handleCancelReply} />
                        )}
                      </Comment>
                    ))}
                  </ul>
                </Comment>
                )
              )}
            </ul>
          ) : (
          <>
            <FakeComment />
            <FakeComment />
          </>
        )}
      </div>
    </div>
  );
}

const FakeComment = memo(() => {
  return (
    <ContentLoader
      speed={2}
      width={750}
      height={160}
      viewBox="0 0 750 160"
      backgroundColor="#9CA3AF"
      foregroundColor="#6B7280"
    >
      <rect x="48" y="8" rx="3" ry="3" width="88" height="6" />
      <rect x="48" y="26" rx="3" ry="3" width="52" height="6" />
      <rect x="0" y="56" rx="3" ry="3" width="410" height="6" />
      <rect x="0" y="72" rx="3" ry="3" width="380" height="6" />
      <rect x="0" y="88" rx="3" ry="3" width="178" height="6" />
      <circle cx="20" cy="20" r="20" />
    </ContentLoader>
  )
})

/**
 * Affiche un commentaire
 */
const Comment = memo(({ comment, editing, onEdit, onUpdate, onDelete, onReply, onLike, children, isReply }) => {
  const anchor = `#c${comment.id}`
  const canEdit = canManage(comment.author.id)
  const className = ['comment']
  const textarea = useRef(null)
  const [loading, setLoading] = useState(false)

  const handleEdit = canEdit
    ? e => {
      e.preventDefault()
      onEdit(comment)
    }
    : null

  async function handleUpdate (e) {
    e.preventDefault()
    setLoading(true)
    await onUpdate(comment, textarea.current.value)
    setLoading(false)
  }

  async function handleLike (e) {
    e.preventDefault()
    if (isAuthenticated()) {
      await onLike(comment)
    } else {
      window.$wireui.notify({
        title: 'Ops! Erreur',
        description: 'Vous devez être connecté pour liker ce contenu!',
        icon: 'error'
      })
    }
  }

  async function handleDelete (e) {
    e.preventDefault()
    if (confirm('Voulez vous vraiment supprimer ce commentaire ?')) {
      setLoading(true)
      await onDelete(comment)
    }
  }

  function handleReply (e) {
    e.preventDefault()
    onReply(comment)
  }

  // On focus automatiquement le champs quand il devient visible
  useEffect(() => {
    if (textarea.current) {
      textarea.current.focus()
    }
  }, [editing])

  let content = (
    <>
      <div className="mt-2 text-sm text-skin-base prose prose-green font-normal max-w-none">
        <Markdown children={comment.body} onDoubleClick={handleEdit} />
      </div>
      <div className="mt-2 text-sm space-x-4">
        <button
          type="button"
          onClick={handleLike}
          className={classNames('inline-flex items-center justify-center text-sm text-skin-base font-normal hover:text-rose-500', comment.likes_count > 0 && 'text-rose-500')}
        >
          <HeartIcon className="-ml-1 mr-2 h-5 w-5 fill-current" aria-hidden="true" />
          {comment.likes_count > 0 && <span className="mr-1.5">{comment.likes_count}</span>}
          Like{comment.likes_count > 1 ? 's' : ''}
        </button>
        {/*{!isReply && (
          <a href={anchor} onClick={handleReply} className="inline-flex items-center justify-center text-sm text-skin-base font-normal hover:text-skin-inverted-muted">
            <ChatIcon className="-ml-1 mr-2 h-5 w-5 fill-current" aria-hidden="true"/>
            Répondre
          </a>
        )}*/}
      </div>
    </>
  )

  if (editing) {
    content = (
      <form onSubmit={handleUpdate} className='min-w-0 flex-1'>
        <label htmlFor="body" className="sr-only">
          Commentaire
        </label>
        <textarea
          name='body'
          className="bg-skin-input shadow-sm focus:border-flag-green focus:ring-flag-green mt-1 block w-full text-skin-base focus:outline-none sm:text-sm font-normal border-skin-input rounded-md"
          ref={textarea}
          defaultValue={comment.body}
          rows={4}
          required
        />
        <div className="mt-3 flex items-center justify-end space-x-3">
          <DefaultButton type='reset' onClick={handleEdit}>
            Annuler
          </DefaultButton>
          <PrimaryButton type='submit' loading={loading}>
            Modifier
          </PrimaryButton>
        </div>
      </form>
    )
  }

  if (loading) {
    className.push('is-loading')
  }

  return (
    <li className={className.join(' ')} id={`c${comment.id}`}>
      <div className="relative pb-2">
        {comment.has_replies ? (
          <span
            className="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-card-gray"
            aria-hidden="true"
          />
        ) : null}
        <div className="relative flex space-x-3">
          <div className="flex-shrink-0">
            <img
              className="h-10 w-10 rounded-full"
              src={comment.author.profile_photo_url}
              alt=""
            />
          </div>
          <div className="flex-1">
            <div className="flex items-center text-sm space-x-2">
              <a href={`/user/${comment.author.username}`} className="font-medium text-skin-primary font-sans hover:text-skin-primary-hover">
                {comment.author.name}
              </a>
              <span className="text-skin-base font-normal"><time-ago time={comment.created_at} /></span>
              {canEdit && (
                <div className="flex">
                  <span className="text-skin-base font-medium">·</span>
                  <div className="pl-2 flex items-center divide-x divide-skin-base">
                    <button type="button" onClick={handleEdit} className="pr-2 text-sm leading-5 font-sans text-skin-base focus:outline-none hover:underline">Éditer</button>
                    <button type="button" onClick={handleDelete} className="pl-2 text-sm leading-5 font-sans text-red-500 focus:outline-none hover:underline">Supprimer</button>
                  </div>
                </div>
              )}
            </div>
            {content}
          </div>
        </div>
        {comment.has_replies && (
          <div className="mt-8 ml-12">
            {children}
          </div>
        )}
      </div>
    </li>
  )
})

function CommentForm ({ onSubmit, parent, isRoot = false, onCancel = null }) {
  const [loading, setLoading] = useState(false)
  const [errors, setErrors] = useState({})
  const ref = useRef(null)

  const handleSubmit = useCallback(
    async e => {
      const form = e.target
      e.preventDefault()
      setLoading(true)
      const errors = (await catchViolations(onSubmit(Object.fromEntries(new FormData(form)), parent)))[1]
      if (errors) {
        console.log(errors)
        setErrors(errors)
      } else {
        form.reset()
      }
      setLoading(false)
    },
    [onSubmit, parent]
  )

  const handleCancel = function (e) {
    e.preventDefault()
    onCancel()
  }

  useEffect(() => {
    if (parent && ref.current) {
      scrollTo(ref.current)
    }
  }, [parent])

  return (
    <div className="flex space-x-3">
      {isAuthenticated() && (
        <>
          <div className="flex-shrink-0">
            <div className="relative">
              <img
                className="h-10 w-10 rounded-full bg-skin-card-gray flex items-center justify-center ring-8 ring-body"
                src={`${currentUser().picture}`}
                alt=""
              />

              <span className="absolute -bottom-0.5 -right-1 bg-skin-body rounded-tl px-0.5 py-px">
                <ChatAltIcon className="h-5 w-5 text-skin-muted" aria-hidden="true" />
              </span>
            </div>
          </div>
        </>
      )}
      <div className="min-w-0 flex-1">
        <form onSubmit={handleSubmit} ref={ref}>
          <label htmlFor="body" className="sr-only">
            Commentaire
          </label>
          <Field
            type='textarea'
            name='body'
            className="bg-skin-input shadow-sm focus:border-flag-green focus:ring-flag-green mt-1 block w-full text-skin-base focus:outline-none sm:text-sm font-normal border-skin-input rounded-md"
            placeholder="Laisser un commentaire"
            error={errors.body}
            rows={4}
            required
          />
          <div className="mt-6 flex items-center justify-between space-x-4">
            {isRoot && (
              <p className="text-sm text-skin-base max-w-xl font-normal">
                Veuillez vous assurer d'avoir lu nos <a href="/rules" className="font-medium text-skin-primary hover:text-skin-primary-hover">règles de conduite</a> avant de répondre à ce fil de conversation.
              </p>
            )}
            <div className="flex items-center justify-end space-x-3">
              {onCancel && <DefaultButton type="reset" onClick={handleCancel}>Annuler</DefaultButton>}
              <PrimaryButton type="submit" loading={loading}>
                Commenter
              </PrimaryButton>
            </div>
          </div>
        </form>
      </div>
    </div>
  )
}

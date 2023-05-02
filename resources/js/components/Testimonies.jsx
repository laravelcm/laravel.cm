import { random } from 'lodash/number'
import { useMemo, useState } from 'preact/hooks'

import { useVisibility, useAsyncEffect } from '@helpers/hooks'
import { findPremiumUsers } from '@api/premium'

function BackgroundIllustration(props) {
  let id = random()

  return (
    <div {...props}>
      <svg
        viewBox="0 0 1026 1026"
        fill="none"
        aria-hidden="true"
        className="absolute inset-0 w-full h-full animate-spin-slow"
      >
        <path
          d="M1025 513c0 282.77-229.23 512-512 512S1 795.77 1 513 230.23 1 513 1s512 229.23 512 512Z"
          stroke="#D4D4D4"
          strokeOpacity="0.7"
        />
        <path
          d="M513 1025C230.23 1025 1 795.77 1 513"
          stroke={`url(#${id}-gradient-1)`}
          strokeLinecap="round"
        />
        <defs>
          <linearGradient
            id={`${id}-gradient-1`}
            x1="1"
            y1="513"
            x2="1"
            y2="1025"
            gradientUnits="userSpaceOnUse"
          >
            <stop stopColor="#099170" />
            <stop offset="1" stopColor="#099170" stopOpacity="0" />
          </linearGradient>
        </defs>
      </svg>
      <svg
        viewBox="0 0 1026 1026"
        fill="none"
        aria-hidden="true"
        className="absolute inset-0 w-full h-full animate-spin-reverse-slower"
      >
        <path
          d="M913 513c0 220.914-179.086 400-400 400S113 733.914 113 513s179.086-400 400-400 400 179.086 400 400Z"
          stroke="#D4D4D4"
          strokeOpacity="0.7"
        />
        <path
          d="M913 513c0 220.914-179.086 400-400 400"
          stroke={`url(#${id}-gradient-2)`}
          strokeLinecap="round"
        />
        <defs>
          <linearGradient
            id={`${id}-gradient-2`}
            x1="913"
            y1="513"
            x2="913"
            y2="913"
            gradientUnits="userSpaceOnUse"
          >
            <stop stopColor="#099170" />
            <stop offset="1" stopColor="#099170" stopOpacity="0" />
          </linearGradient>
        </defs>
      </svg>
    </div>
  )
}

export function Testimonies ({ target, parent }) {
  const [state, setState] = useState({
    users: [], // Liste des utilisateurs
  })

  const isVisible = useVisibility(parent)
  const users = useMemo(() => {
    if (state.users === null) {
      return null
    }
    return state.users
  }, [state.users])

  useAsyncEffect(async () => {
    if (isVisible) {
      const users = await findPremiumUsers()
      setState({ users })
    }
  }, [target, isVisible])

  return (
    <>
      <BackgroundIllustration className="absolute left-1/2 top-4 h-[1026px] w-[1026px] -translate-x-1/3 stroke-gray-300/70 [mask-image:linear-gradient(to_bottom,white_20%,transparent_75%)] sm:top-16 sm:-translate-x-1/2 lg:-top-16 lg:ml-12 xl:-top-14 xl:ml-0" />
      <div className="space-y-6 pointer-events-none select-none">
        {users ? users.map((userGroup, index) => (
          <div key={index} className="flex items-center space-x-20 animate-scroll-slow whitespace-nowrap">
            {userGroup.map((user, idx) => (
              <div key={idx} className="inline-flex items-center w-full px-3 py-1.5 rounded-md mx-4">
                <img className="inline-block object-cover w-8 h-8 rounded-full" src={user.image} alt={user.name} />
                <div className="ml-3">
                  <p className="text-sm font-medium text-skin-inverted-muted">{user.name}</p>
                  <p className="text-xs leading-4 text-skin-muted">{`@${user.username}`}</p>
                </div>
              </div>
            ))}
          </div>
        )) : null}
      </div>
    </>

  )
}

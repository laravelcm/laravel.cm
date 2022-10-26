export function Testimonies () {
  const testimonies = [
    {
      name: 'John Doe',
      username: 'johndoe',
      image: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Tom Hook',
      username: 'tomhook',
      image: 'https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Larissa Monney',
      username: 'larissamonney',
      image: 'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Steve Monney',
      username: 'monney',
      image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80',
    },
    {
      name: 'John Doe',
      username: 'johndoe',
      image: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Tom Hook',
      username: 'tomhook',
      image: 'https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Larissa Monney',
      username: 'larissamonney',
      image: 'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Steve Monney',
      username: 'monney',
      image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80',
    },
    {
      name: 'John Doe',
      username: 'johndoe',
      image: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Tom Hook',
      username: 'tomhook',
      image: 'https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Larissa Monney',
      username: 'larissamonney',
      image: 'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Steve Monney',
      username: 'monney',
      image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80',
    },
    {
      name: 'John Doe',
      username: 'johndoe',
      image: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Tom Hook',
      username: 'tomhook',
      image: 'https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Larissa Monney',
      username: 'larissamonney',
      image: 'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
      name: 'Steve Monney',
      username: 'monney',
      image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80',
    },
  ]

  return (
    <div className="space-y-5">
      <div className="animate-scroll-slow flex items-center whitespace-nowrap space-x-20">
        {testimonies.map((testimony, index) => (
          <div key={index} className="inline-flex items-center whitespace-nowrap w-auto px-3 py-1.5 rounded-md">
            <img className="inline-block h-8 w-8 rounded-full object-cover" src={testimony.image} alt={testimony.name} />
            <div className="ml-3">
              <p className="text-sm font-medium text-skin-inverted-muted">{testimony.name}</p>
              <p className="text-xs leading-4 text-skin-muted">{`@${testimony.username}`}</p>
            </div>
          </div>
        ))}
      </div>
      <div className="animate-scroll-slow flex items-center whitespace-nowrap space-x-20">
        {testimonies.map((testimony, index) => (
          <div key={index} className="inline-flex items-center whitespace-nowrap w-auto px-3 py-1.5 rounded-md">
            <img className="inline-block h-8 w-8 rounded-full object-cover" src={testimony.image} alt={testimony.name} />
            <div className="ml-3">
              <p className="text-sm font-medium text-skin-inverted-muted">{testimony.name}</p>
              <p className="text-xs leading-4 text-skin-muted">{`@${testimony.username}`}</p>
            </div>
          </div>
        ))}
      </div>
      <div className="animate-scroll-slow flex items-center whitespace-nowrap space-x-20">
        {testimonies.map((testimony, index) => (
          <div key={index} className="inline-flex items-center whitespace-nowrap w-auto px-3 py-1.5 rounded-md">
            <img className="inline-block h-8 w-8 rounded-full object-cover" src={testimony.image} alt={testimony.name} />
            <div className="ml-3">
              <p className="text-sm font-medium text-skin-inverted-muted">{testimony.name}</p>
              <p className="text-xs leading-4 text-skin-muted">{`@${testimony.username}`}</p>
            </div>
          </div>
        ))}
      </div>
    </div>
  )
}

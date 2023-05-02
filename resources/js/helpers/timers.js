export function throttle(callback, delay) {
  let last
  let timer
  return function () {
    let context = this
    let now = + new Date()
    let args = arguments
    if (last && now < last + delay) {
      clearTimeout(timer)
      timer = setTimeout(function () {
        last = now
        callback.apply(context, args)
      }, delay)
    } else {
      last = now
      callback.apply(context, args)
    }
  }
}

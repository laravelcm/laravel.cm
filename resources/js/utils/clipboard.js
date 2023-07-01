// Copy to Clipboard.
let codeBlocks = document.querySelectorAll('#content pre')

codeBlocks.forEach((element, key) => {
  let wrapper = document.createElement('div')
  wrapper.classList.add('relative', 'code-block')

  element.parentNode.insertBefore(wrapper, element)
  wrapper.appendChild(element)

  let codeElement = element.querySelector('code')
  codeElement.id = `clipText-${key}`

  // Copy to clipboard button.
  const copyToClipboardContainer = document.createElement('div')

  copyToClipboardContainer.innerHTML = `
        <div x-data="{
            copyNotification: false,
            copyToClipboard() {
                this.copyNotification = true
                let that = this
                const clipboardItem = new ClipboardItem({
                  'text/plain': new Blob([\`${codeElement.innerText.replaceAll('"', '\\`')}\`], { type: 'text/plain' })
                })
                navigator.clipboard.write([clipboardItem]).then(() => {
                  setTimeout(function() {
                      that.copyNotification = false
                  }, 3000)
                })
            }
        }" class="relative z-20 flex items-center">
        <div x-show="copyNotification" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-2" class="absolute left-0" x-cloak>
            <div class="px-3 h-7 -ml-1.5 items-center flex text-xs bg-primary-500 border-r border-primary-500 -translate-x-full text-white rounded">
                <span>Copié!</span>
                <div class="absolute right-0 inline-block h-full -mt-px overflow-hidden translate-x-3 -translate-y-2 top-1/2">
                    <div class="w-3 h-3 origin-top-left transform rotate-45 bg-primary-500 border border-transparent"></div>
                </div>
            </div>
        </div>
        <button @click="copyToClipboard();" class="flex items-center justify-center h-8 text-xs bg-gray-700 rounded-md cursor-pointer w-9 hover:bg-gray-900/50 active:bg-gray-600 focus:bg-gray-700 focus:outline-none text-slate-300 hover:text-white group">
            <svg x-show="copyNotification" class="w-4 h-4 text-primary-500 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            <svg x-show="!copyNotification" class="w-4 h-4 stroke-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="none">
                    <path d="M7.75 7.757V6.75a3 3 0 0 1 3-3h6.5a3 3 0 0 1 3 3v6.5a3 3 0 0 1-3 3h-.992" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.75 10.75a3 3 0 0 1 3-3h6.5a3 3 0 0 1 3 3v6.5a3 3 0 0 1-3 3h-6.5a3 3 0 0 1-3-3v-6.5z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
            </svg>
        </button>
    </div>
  `

  copyToClipboardContainer.setAttribute('aria-label', 'Copy to Clipboard')
  copyToClipboardContainer.setAttribute('title', 'Copy to Clipboard')
  copyToClipboardContainer.classList.add('copyBtn');

  wrapper.append(copyToClipboardContainer)
})

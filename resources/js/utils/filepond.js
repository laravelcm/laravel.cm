import * as FilePond from 'filepond'
import 'filepond/dist/filepond.min.css'

const inputElement = document.querySelector('input[type="file"].filepond')
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

FilePond.create(inputElement).setOptions({
  server: {
    process: './uploads/process',
    headers: {
      'X-CSRF-TOKEN': csrfToken,
    }
  }
});

import * as FilePond from 'filepond'
import fr from 'filepond/locale/fr-fr'
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'

import 'filepond/dist/filepond.min.css'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'
import '../../css/file-upload.css'

const inputElement = document.querySelector('input[type="file"].filepond')
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

FilePond.registerPlugin(FilePondPluginFileValidateSize)
FilePond.registerPlugin(FilePondPluginFileValidateType)
FilePond.registerPlugin(FilePondPluginImagePreview)

if (inputElement) {
  FilePond.create(inputElement).setOptions({
    ...fr,
    acceptedFileTypes: ['image/*'],
    maxFileSize: inputElement.dataset.maxFileSize,
    server: {
      process: './uploads/process',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
      },
    }
  })
}

<div>
    @can('report-spam')
        @if ($alreadyReported)
            <!-- Badge si déjà signalé -->
            <span class="badge badge-success">Déjà signalé</span>
        @else
            <!-- Lien pour ouvrir le modal -->
            <button class="btn btn-link text-danger" wire:click="openModal">Signaler</button>
        @endif
    @endcan
    
    @if ($errors->has('alreadyReported'))
        <div class="text-danger">
            {{ $errors->first('alreadyReported') }}
        </div>
    @endif

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="modal d-block" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Signaler un contenu</h5>
                        <button type="button" class="close" wire:click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea 
                            wire:model="reason" 
                            class="form-control" 
                            placeholder="Raison du signalement">
                        </textarea>
                        @error('reason') 
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Fermer</button>
                        <button type="button" class="btn btn-primary" wire:click="report">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success mt-2">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger mt-2">
            {{ session('error') }}
        </div>
    @endif
</div>

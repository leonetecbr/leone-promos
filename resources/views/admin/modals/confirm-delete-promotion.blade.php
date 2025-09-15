<form class="modal fade" id="confirmDeletePromotion" tabindex="-1" aria-labelledby="deleteConfirmation"
      aria-hidden="true" method="POST" action="{{ route('promotions.destroy', $promotion->id) }}">
    @csrf
    @method('DELETE')
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="deleteConfirmation">Excluir Promoção</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir essa promoção?</p>
                <b>Essa ação não poderá ser desfeita!</b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-danger">Excluir</button>
            </div>
        </div>
    </div>
</form>

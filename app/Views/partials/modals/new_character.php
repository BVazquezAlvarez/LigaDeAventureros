<div class="modal" id="new-character-modal" tabindex="-1">
    <form class="modal-dialog" method="post" action="<?= base_url('new-character') ?>" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo personaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="class">Clase</label>
                        <input type="text" name="class" id="class" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="level">Nivel</label>
                        <input type="number" min="1" max="20" name="level" id="level" class="form-control" value="1" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="character_sheet">Hoja de personaje (Tamaño máximo: 5MB)</label>
                        <input type="file" name="character_sheet" id="character_sheet" class="form-control-file" accept=".pdf" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
</div>
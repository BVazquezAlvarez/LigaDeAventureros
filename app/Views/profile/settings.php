<form class="col-md-6 offset-md-3" method="post">
    <div class="col-12">
        <div class="form-group">
            <label for="display_name">Nombre</label>
            <input type="text" name="display_name" id="display_name" class="form-control" value="<?= $user->display_name ?>" required>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form> 
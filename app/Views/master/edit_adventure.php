<?php
// LigaDeAventureros
// Copyright (C) 2023 Santiago González Lago

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>

<form class="card" method="post" enctype="multipart/form-data">
    <div class="card-header text-center">
        <h2 class="d-inline-block mb-0">Editar <?= $adventure->name ?></h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group">
                    <label for="adventure_name">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="adventure_name" id="adventure_name" class="form-control" value="<?= $adventure->name ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="adventure_rank">Rango</label>
                            <select name="adventure_rank" id="adventure_rank" class="form-control">
                                <option value=""><?= rank_full_text(0) ?></option>
                                <option value="1" <?= $adventure->rank == '1' ? 'selected' : '' ?>><?= rank_full_text(1) ?></option>
                                <option value="2" <?= $adventure->rank == '2' ? 'selected' : '' ?>><?= rank_full_text(2) ?></option>
                                <option value="3" <?= $adventure->rank == '3' ? 'selected' : '' ?>><?= rank_full_text(3) ?></option>
                                <option value="4" <?= $adventure->rank == '4' ? 'selected' : '' ?>><?= rank_full_text(4) ?></option>
                            </select>
                            <? if (isset(session('validation_errors')['adventure_rank'])) : ?>
                                <small class="text-danger"><?= session('validation_errors')['adventure_rank'] ?></small>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Tipo <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control">
                            <? foreach ($adventure_type as $adv_type) : ?>
                                <option value="<?=$adv_type->id ?>" <?= $adventure->type == $adv_type->id ? 'selected' : '' ?>><?=$adv_type->name ?></option>
                            <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Número de jugadores recomendado</label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="adventure_players_min_recommended">Mínimo <span class="text-danger">*</span></label>
                            <input type="text" name="adventure_players_min_recommended" id="adventure_players_min_recommended" value="<?= $adventure->players_min_recommended ?>" class="form-control" required>
                        <? if (isset(session('validation_errors')['adventure_players_min_recommended'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['adventure_players_min_recommended'] ?></small>
                        <? endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="adventure_players_max_recommended">Máximo <span class="text-danger">*</span></label>
                            <input type="text" name="adventure_players_max_recommended" id="adventure_players_max_recommended" value="<?= $adventure->players_max_recommended ?>" class="form-control" required>
                        <? if (isset(session('validation_errors')['adventure_players_max_recommended'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['adventure_players_max_recommended'] ?></small>
                        <? endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="adventure_duration">Duración <span class="text-danger">*</span></label>
                            <input type="text" name="adventure_duration" id="adventure_duration" class="form-control" value="<?= $adventure->duration ?>" required>
                            <? if (isset(session('validation_errors')['adventure_duration'])) : ?>
                                <small class="text-danger"><?= session('validation_errors')['adventure_duration'] ?></small>
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                            
                            <label for="w_setting_id">Modalidad <span class="text-danger">*</span></label>
                            <select name="w_setting_id" id="w_setting_id" class="form-control">
                                <option value="0" <?= $adventure->w_setting_id == 0 ? 'selected' : '' ?>>Todas las modalidades</option>
                            <? foreach ($world_settings as $setting) : ?>
                                <option value="<?=$setting->id ?>" <?= $adventure->w_setting_id == $setting->id ? 'selected' : '' ?>><?=$setting->name ?></option>
                            <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>  
                <div class="form-group">
                    <label for="adventure_themes">Temas</label>
                    <input type="text" name="adventure_themes" id="adventure_themes" class="form-control" value="<?= $adventure->themes ?>">
                    <? if (isset(session('validation_errors')['adventure_themes'])) : ?>
                        <small class="text-danger"><?= session('validation_errors')['adventure_themes'] ?></small>
                    <? endif; ?>
                </div>
                <div class="form-group">
                    <label for="adventure_description">Descripción <span class="text-danger">*</span></label>
                    <textarea name="adventure_description" id="adventure_description" class="form-control" rows="10" required><?= $adventure->description ?></textarea>
                    <? if (isset(session('validation_errors')['adventure_description'])) : ?>
                        <small class="text-danger"><?= session('validation_errors')['adventure_description'] ?></small>
                    <? endif; ?>
                </div>
                <div class="form-group">
                    <label for="adventure_rewards">Recompensas</label>
                    <textarea name="adventure_rewards" id="adventure_rewards" class="form-control" rows="5"><?= $adventure->rewards ?></textarea>
                    <? if (isset(session('validation_errors')['adventure_rewards'])) : ?>
                        <small class="text-danger"><?= session('validation_errors')['adventure_rewards'] ?></small>
                    <? endif; ?>
                </div>
                <div class="form-group">
                    <label for="adventure_thumbnail">Imagen (Tamaño máximo: <strong>50MB</strong>)</label>
                    <input type="file" name="adventure_thumbnail" id="adventure_thumbnail" class="form-control-file" accept="image/*">
                    <? if (isset(session('validation_errors')['adventure_thumbnail'])) : ?>
                        <small class="text-danger"><?= session('validation_errors')['adventure_thumbnail'] ?></small>
                    <? endif; ?>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="delete_thumbnail" id="delete_thumbnail" class="form-check-input">
                        <label class="form-check-label" for="delete_thumbnail">Eliminar imagen</label>
                    </div>
                    <? if (isset(session('validation_errors')['delete_thumbnail'])) : ?>
                        <small class="text-danger"><?= session('validation_errors')['delete_thumbnail'] ?></small>
                    <? endif; ?>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
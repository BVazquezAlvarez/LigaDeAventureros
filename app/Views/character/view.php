<?php
// LigaDeAventureros
// Copyright (C) 2024 Santiago González Lago

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

<div class="alert alert-warning text-center" role="alert">
  <h4 class="alert-heading">WORK IN PROGRESS</h4>
  <p class="mb-0">Este es un sitio en desarrollo y el diseño no es final.</p>
</div>

<div class="card <?= $character->active ? "" : "text-secondary" ?>">
    <div class="text-center card-header">
        <h1 class="d-inline h3"><?= $character->name ?></h1> <?= $character->active ? "" : "(Inactivo)" ?>
        <div><a href="<?= base_url('profile') ?>/<?= $player->uid ?>"><?= $player->display_name ?></a></div>
    </div>
    <div class="card-body">
      <a href="#" data-toggle="modal" data-target="#image-modal" class="character-image">
        <div class="image-box">
          <img src="https://s1.elespanol.com/2017/08/16/actualidad/actualidad_239489274_129989410_1706x960.jpg">
        </div>
      </a>
      <p>
        <strong><?= $character->class ?></strong> de nivel <strong><?= $character->level ?></strong><br/>
        Rango <?= rank_name(rank_get($character->level)) ?>
      </p>
      <p>
        <a href="#">Ver página de Wiki</a>
      </p>
      <p>
        <a href="#" data-toggle="modal" data-target="#character-sheet-modal">Hoja de personaje</a>
        <? if ($character->uploaded_sheet != $character->validated_sheet && ($isOwner || ($userdata && $userdata['master']))) : ?>
            <? if ($character->validated_sheet) : ?>
                (<a href="#" data-toggle="modal" data-target="#character-sheet-validated-modal">última validada</a>)
            <? else : ?>
                (<span class="text-danger">Sin validar</span>)
            <? endif; ?>
        <? endif; ?>
      </p>
      <div class="character-description">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nunc tellus, porta vitae varius eget, bibendum ut mi. Aenean sed metus tristique, ornare purus eget, luctus diam. Maecenas ut augue nunc. Ut facilisis, ex id dignissim accumsan, sapien eros porttitor nisi, et dignissim mi magna non diam. Proin suscipit accumsan ornare. Curabitur posuere purus eros, quis elementum odio consequat at. Etiam lobortis nulla nec ex ultrices consequat. Nam interdum justo id nisi iaculis efficitur. Integer pharetra imperdiet ultrices. Mauris vitae finibus massa. Vestibulum maximus metus in tortor bibendum pretium. Nam quam ex, sagittis sed elit a, laoreet vestibulum diam.<br/>
        Fusce imperdiet justo ipsum, eget tincidunt est mattis ut. Fusce varius, augue non aliquet volutpat, metus nulla vehicula dui, in efficitur magna tellus quis nunc. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam at nisi a risus tincidunt auctor. In hac habitasse platea dictumst. Vestibulum fermentum ultricies vulputate. Integer a fermentum nisl.<br/>
        Curabitur sit amet imperdiet ante. Nam sit amet ante et sapien semper tristique. Etiam tincidunt enim leo, eu elementum nibh porta sit amet. Nullam non imperdiet ex. Aenean ornare lacus libero, vel interdum lacus scelerisque sed. Suspendisse tempor ultrices lacus nec aliquet. Cras vitae ante quis nulla volutpat malesuada.<br/>
        In faucibus rutrum facilisis. Quisque condimentum malesuada vestibulum. Quisque aliquam nulla lorem, eu convallis ipsum rutrum a. Donec ut tellus vel lacus pulvinar laoreet id at lectus. Ut at finibus nulla. Duis aliquam congue diam sed commodo. Phasellus pretium quam ac sapien molestie rutrum. Vivamus at mi ullamcorper, mollis nibh sed, accumsan felis.<br/>
        Maecenas at ligula enim. Vivamus quis dapibus arcu, molestie vehicula mi. Vivamus nec lectus elementum, consectetur nisi ac, ultricies orci. Duis et lorem vestibulum, semper metus quis, fringilla ex. Aliquam ut vehicula libero, at laoreet felis. Quisque a convallis enim. Maecenas ultrices velit nec neque fermentum, eu congue tortor pretium. Nam iaculis, lectus quis malesuada efficitur, nibh dolor consectetur erat, ac lobortis ante nunc eu nisl. Praesent nunc ipsum, hendrerit nec tellus et, pulvinar sollicitudin nibh. Sed eleifend urna est, nec blandit ligula elementum eget. 
      </div>
    </div>
    <? if ($isOwner && $userdata['confirmed']) : ?>
      <div class="card-footer">
        <button type="button" class="btn btn-primary js-update-character-btn" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>" data-class="<?= $character->class ?>" data-level="<?= $character->level ?>">Actualizar</button>
        <? if ($character->active) : ?>
          <a href="<?= base_url('character') ?>/<?= $character->uid ?>/disable" class="btn btn-outline-danger">Desactivar</a>
        <? else : ?>
          <a href="<?= base_url('character') ?>/<?= $character->uid ?>/enable" class="btn btn-outline-success">Reactivar</a>
        <? endif; ?>
        <button type="button" class="btn btn-danger js-delete-character-btn" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>" data-class="<?= $character->class ?>" data-level="<?= $character->level ?>">Eliminar</button>
      </div>
    <? endif; ?>
    <? if ($character->uploaded_sheet != $character->validated_sheet && ($userdata && $userdata['master'])) : ?>
      <div class="card-footer">
        <button class="btn btn-primary js-validate-btn" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>">Validar hoja de personaje</button>
        <button class="btn btn-danger js-reject-btn" data-uid="<?= $character->uid ?>" data-name="<?= $character->name ?>">Rechazar hoja de personaje</button>
      </div>
    <? endif; ?>
</div>

<?= view('partials/modals/character_sheet') ?>
<? if (($character->uploaded_sheet != $character->validated_sheet && ($isOwner || ($userdata && $userdata['master']))) && $character->validated_sheet) : ?>
  <?= view('partials/modals/character_sheet_validated') ?>
<? endif; ?>
<? if ($isOwner) : ?>
    <?= view('partials/modals/update_character') ?>
<? endif; ?>
<? if ($character->uploaded_sheet != $character->validated_sheet && ($userdata && $userdata['master'])) : ?>
  <?= view('partials/modals/validate_sheets') ?>
<? endif; ?>
<?= view('partials/modals/image', ['title' => $character->name, 'img' => 'https://s1.elespanol.com/2017/08/16/actualidad/actualidad_239489274_129989410_1706x960.jpg']) ?>
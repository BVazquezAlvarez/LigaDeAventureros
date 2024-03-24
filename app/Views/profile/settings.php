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

<nav class="mb-3">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link <?= $tab == 'settings' ? 'active' : '' ?>" id="nav-settings-tab" data-toggle="tab" href="#nav-settings" role="tab">Configuración general</a>
        <a class="nav-item nav-link <?= $tab == 'email' ? 'active' : '' ?>" id="nav-email-tab" data-toggle="tab" href="#nav-email" role="tab">Opciones de email</a>
    </div>
</nav>

<div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade <?= $tab == 'settings' ? 'show active' : '' ?>" id="nav-settings" role="tabpanel">
        <form class="col-md-6 offset-md-3" method="post">
            <div class="col-12">
                <div class="form-group">
                    <label for="display_name">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="display_name" id="display_name" class="form-control" value="<?= $user->display_name ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</span></label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="repeat_password">Repetir contraseña</span></label>
                    <input type="password" name="repeat_password" id="repeat_password" class="form-control">
                    <? if (isset(session('validation_errors')['repeat_password'])) : ?>
                        <small class="text-danger"><?= session('validation_errors')['repeat_password'] ?></div>
                    <? endif; ?>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
        <div class="col-md-6 offset-md-3">
            <div class="form-group text-center">
                <button type="button" data-toggle="modal" data-target="#delete-account-modal" class="btn btn-outline-danger">Eliminar mi cuenta</button>
            </div>
        </div>
    </div>

    <div class="tab-pane fade <?= $tab == 'email' ? 'show active' : '' ?>" id="nav-email" role="tabpanel">
        <form class="col-md-8 offset-md-2" method="post" action="<?= base_url('settings/email') ?>">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmation_session_join" value="confirmation_session_join" name="email_settings[]" <?= in_array('confirmation_session_join', $email_settings) ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="confirmation_session_join">Recibir confirmación al inscribirme a una partida</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmation_session_swap" value="confirmation_session_swap" name="email_settings[]" <?= in_array('confirmation_session_swap', $email_settings) ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="confirmation_session_swap">Recibir confirmación al cambiar mi personaje para una partida</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmation_session_cancel" value="confirmation_session_cancel" name="email_settings[]" <?= in_array('confirmation_session_cancel', $email_settings) ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="confirmation_session_cancel">Recibir confirmación al cancelar mi inscripción a una partida</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="notification_session_modified" value="notification_session_modified" name="email_settings[]" <?= in_array('notification_session_modified', $email_settings) ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="notification_session_modified">Notificarme cuando una partida a la que estoy inscrito es modificada</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="notification_session_canceled" value="notification_session_canceled" name="email_settings[]" <?= in_array('notification_session_canceled', $email_settings) ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="notification_session_canceled">Notificarme cuando una partida a la que estoy inscrito es cancelada</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="notification_session_waitlist" value="notification_session_waitlist" name="email_settings[]" <?= in_array('notification_session_waitlist', $email_settings) ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="notification_session_waitlist">Notificarme cuando se abre un hueco en una partida en la que estoy en lista de espera</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="notification_session_kicked" value="notification_session_kicked" name="email_settings[]" <?= in_array('notification_session_kicked', $email_settings) ? 'checked' : ''  ?>>
                    <label class="form-check-label" for="notification_session_kicked">Notificarme cuando soy expulsado de una partida a la que estoy inscrito</label>
                </div>
            </div>
            <? if ($userdata['master']) : ?>
                <div class="form-group">
                    <h3 class="text-secondary">Opciones para masters</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="master_player_join" value="master_player_join" name="email_settings[]" <?= in_array('master_player_join', $email_settings) ? 'checked' : ''  ?>>
                        <label class="form-check-label" for="master_player_join">Notificarme cuando un jugador se inscribe a una de mis partidas</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="master_player_swap" value="master_player_swap" name="email_settings[]" <?= in_array('master_player_swap', $email_settings) ? 'checked' : ''  ?>>
                        <label class="form-check-label" for="master_player_swap">Notificarme cuando un jugador cambia de personaje en una de mis partidas</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="master_player_cancel" value="master_player_cancel" name="email_settings[]" <?= in_array('master_player_cancel', $email_settings) ? 'checked' : ''  ?>>
                        <label class="form-check-label" for="master_player_cancel">Notificarme cuando un jugador cancela su inscripción a una de mis partidas</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="master_send_emails" value="master_send_emails" name="email_settings[]" <?= in_array('master_send_emails', $email_settings) ? 'checked' : ''  ?>>
                        <label class="form-check-label" for="master_send_emails">Permitir que los jugadores respondan a mi email al recibir notificaciones <strong class="text-danger">(Tu email será visible para otros usuarios)</strong></label>
                    </div>
                </div>
            <? endif; ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>

</div>



<div class="modal fade" id="delete-account-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= base_url('settings/delete-account') ?>">
            <div class="modal-body">
                <h5>¿Estás seguro de que quieres eliminar tu cuenta?</h5>
                <div class="alert alert-danger text-center mt-3 mb-0" role="alert">
                    Tu cuenta se eliminará en <strong>15 días</strong>.<br/>
                    Para cancelar, inicia sesión durante ese período.
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sí</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </form>
    </div>
</div>
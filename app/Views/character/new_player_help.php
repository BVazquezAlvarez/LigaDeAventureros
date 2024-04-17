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

<div class="card bg-light">
    <div class="card-header">
        <h1 class="h2 text-center">Nuevo personaje</h1>
    </div>
    <div class="card-body">
        <? if (session('validation_errors')) : ?>
            <div class="text-danger">
                Por favor, revisa los siguientes errores:
                <ul>
                    <? if (isset(session('validation_errors')['level'])) : ?>
                        <li><?= session('validation_errors')['level'] ?></li>
                    <? endif; ?>
                    <? if (isset(session('validation_errors')['class'])) : ?>
                        <li><?= session('validation_errors')['class'] ?></li>
                    <? endif; ?>
                    <? if (isset(session('validation_errors')['name'])) : ?>
                        <li><?= session('validation_errors')['name'] ?></li>
                    <? endif; ?>
                    <? if (isset(session('validation_errors')['character_sheet'])) : ?>
                        <li><?= session('validation_errors')['character_sheet'] ?></li>
                    <? endif; ?>
                </ul>
            </div>
        <? endif; ?>

        <form method="post" action="<?= base_url('new-character') ?>" enctype="multipart/form-data">
            <section id="section-level" class="new-character-guide-section">
                <h2>Nivel</h2>
                <p>
                    Puedes elegir crear tu personaje a <strong>nivel 1</strong> o a <strong>nivel 3</strong>.
                </p>
                <div class="row">
                    <div class="form-group col-md-6 col-lg-4">
                        <select name="level" id="level" class="form-control" required>
                            <option value="1">Nivel 1</option>
                            <option value="3">Nivel 3</option>
                        </select>
                        <? if (isset(session('validation_errors')['level'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['level'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <button type="button" class="btn btn-primary js-btn-continue" data-section="#section-class" data-input="#level">Continuar</button>
            </section>
            <section id="section-class" class="new-character-guide-section" style="display:none;">
                <h2>Clase</h2>
                <p>
                    Puedes elegir cualquier de las clases oficiales de Dungeons & Dragons:
                </p>
                <ul>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/barbarian" target="_blank">Bárbaro</a></strong>, maestro del combate cuerpo a cuerpo y resistencia sobrehumana. <a href="#" class="js-select-class" data-class="Bárbaro">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/bard" target="_blank">Bardo</a></strong>, artista versátil con habilidades mágicas y capacidad para inspirar a otros. <a href="#" class="js-select-class" data-class="Bardo">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/warlock" target="_blank">Brujo</a></strong>, obtiene poderes mediante pactos con seres sobrenaturales. <a href="#" class="js-select-class" data-class="Brujo">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/cleric" target="_blank">Clérigo</a></strong>, sirviente divino con habilidades de sanación y magia sagrada. <a href="#" class="js-select-class" data-class="Clérigo">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/druid" target="_blank">Druida</a></strong>, protector de la naturaleza con habilidades mágicas y capacidad para cambiar de forma. <a href="#" class="js-select-class" data-class="Druida">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/ranger" target="_blank">Explorador</a></strong>, experto en supervivencia, rastreo y combate a distancia. <a href="#" class="js-select-class" data-class="Explorador">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/fighter" target="_blank">Guerrero</a></strong>, luchador experto con habilidades variadas en armas y armaduras. <a href="#" class="js-select-class" data-class="Guerrero">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/sorcerer" target="_blank">Hechicero</a></strong>, mago con talento innato para lanzar hechizos poderosos. <a href="#" class="js-select-class" data-class="Hechicero">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/wizard" target="_blank">Mago</a></strong>, estudioso arcano con amplio conocimiento de hechizos y magia. <a href="#" class="js-select-class" data-class="Mago">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/monk" target="_blank">Monje</a></strong>, maestro del combate desarmado y disciplinas físicas y mentales. <a href="#" class="js-select-class" data-class="Monje">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/paladin" target="_blank">Paladín</a></strong>, caballero divino con habilidades de combate y magia sagrada. <a href="#" class="js-select-class" data-class="Paladín">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/rogue" target="_blank">Pícaro</a></strong>, experto en sigilo, trampas y ataques furtivos. <a href="#" class="js-select-class" data-class="Pícaro">Seleccionar</a></li>
                    <li class="mb-1"><strong><a href="https://www.dndbeyond.com/classes/artificer" target="_blank">Artífice</a></strong>, inventor hábil con habilidades en la creación de objetos mágicos y tecnológicos. <a href="#" class="js-select-class" data-class="Artífice">Seleccionar</a></li>
                </ul>
                <p>
                    Si has decidido comenzar a nivel 5, tienes la opción de crear un personaje multiclase. Sin embargo, para nuevos jugadores, no se recomienda esta opción, ya que sin un plan claro, puede resultar en personajes considerablemente más débiles.
                </p>
                <div class="row">
                    <div class="form-group col-md-6 col-lg-4">
                        <input type="text" name="class" id="class" class="form-control" placeholder="Elige tu clase" required>
                        <? if (isset(session('validation_errors')['class'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['class'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <button type="button" class="btn btn-primary js-btn-continue" data-section="#section-name" data-input="#class">Continuar</button>
            </section>
            <section id="section-name" class="new-character-guide-section" style="display:none;">
                <h2>Nombre</h2>
                <p>
                    Si no se te ocurre ningún nombre, siempre puedes usar <a href="https://www.fantasynamegenerators.com/" target="_blank">un generador de nombres aleatorios</a>, aunque te recomendamos que pienses un nombre que realmente te guste.
                </p>
                <div class="row">
                    <div class="form-group col-md-6 col-lg-4">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Elige un nombre" required>
                        <? if (isset(session('validation_errors')['name'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['name'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <button type="button" class="btn btn-primary js-btn-continue" data-section="#section-cs" data-input="#name">Continuar</button>
            </section>
            <section id="section-cs" class="new-character-guide-section" style="display:none;">
                <h2>Hoja de personaje</h2>
                <p>
                    Para crear tu hoja de personaje, te recomendamos usar D&D Beyond y asegurarte de incluir toda la información necesaria para tu personaje. Esto incluye detalles como la raza, clase, habilidades, equipo, etc.
                </p>
                <p>
                    Si tienes alguna pregunta o necesitas ayuda durante el proceso, no dudes en consultarnos a través del <a href="<?= base_url('contact') ?>">formulario de contacto</a> o por medio de <a href="<?= setting('whatsapp') ?>"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>.
                </p>
                <p>
                    Por favor, sube tu ficha de personaje como un archivo PDF de no más de 5MB. Un master deberá validarla antes de que puedas empezar a anotarte a partidas.
                </p>
                <p>
                    Si tienes problemas técnicos al subir tu hoja de personaje, no dudes en contactarnos para recibir asistencia adicional.
                </p>
                <div class="row">
                    <div class="form-group col-md-6 col-lg-4">
                        <input type="file" name="character_sheet" id="character_sheet" class="form-control form-control-file" accept=".pdf" required>
                        <? if (isset(session('validation_errors')['character_sheet'])) : ?>
                            <small class="text-danger"><?= session('validation_errors')['character_sheet'] ?></small>
                        <? endif; ?>
                    </div>
                </div>
                <button type="button" class="btn btn-primary js-btn-continue" data-section="#section-end" data-input="#character_sheet">Continuar</button>
            </section>
            <section id="section-end" class="new-character-guide-section" style="display:none;">
                <h2>¿Ya está todo?</h2>
                <p>
                    Si ya has finalizado todos los detalles, ya solo falta enviar tu personaje y esperar a que un master apruebe tu personaje.
                </p>
                <button type="submit" class="btn btn-lg btn-primary">¡Comienza tu aventura!</button>
            </section>
        </form>
    </div>
</div>
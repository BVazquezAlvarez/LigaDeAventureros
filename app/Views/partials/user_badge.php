<a href="<?= base_url('character') ?>/<?= $player->character_uid ?>" class="btn btn-<?= $player->badge_color ?> badge badge-player <?= ($userdata && $player->uid == $userdata['uid']) ? 'badge-me' : '' ?> <?= $player->priority ? "border-priority" : "" ?>" >
<?= $player->priority == 1 ? '<i class="fa-solid fa-circle-up" style="
    position: absolute;
    left: -1px;
    top: -4px;
" data-toggle="tooltip" title="Este usuario ha priorizado esta partida"></i>' : '' ?>
<?= $player->priority == 2 ? '<i class="<i class="fa-universal-access"></i>" style="
    position: absolute;
    left: -1px;
    top: -4px;
" data-toggle="tooltip" title="Los jugadores nuevos tienen prioridad></i>' : '' ?>
<?= $player->priority == 3 ? '
<i class="fas fa-universal-access" style="
    position: absolute;
    left: 13px;
    top: -4px;
" data-toggle="tooltip" title="Los jugadores nuevos tienen prioridad"></i>
<i class="fa-solid fa-circle-up" style="
    position: absolute;
    left: -1px;
    top: -4px;
" data-toggle="tooltip" title="Este usuario ha priorizado esta partida"></i>' : '' ?>
<div><?= $player->name ?></div>
    <div>(<?= $player->display_name ?>)</div>
</a>
<a href="<?= base_url('character') ?>/<?= $player->character_uid ?>" class="btn btn-<?= $player->badge_color ?> badge badge-player <?= $player->uid == $userdata['uid'] ? 'badge-me' : '' ?> <?= $player->priority ? "border-priority" : "" ?>" <?= $player->priority ? 'data-toggle="tooltip" title="Los jugadores nuevos tienen prioridad"' : '' ?>>
    <div><?= $player->name ?></div>
    <div>(<?= $player->display_name ?>)</div>
</a>
<div class="d-none d-md-block">
    <span class="badge badge-<?= $player->badge_color ?> badge-player">
        <div><a href="<?= base_url('character') ?>/<?= $player->character_uid ?>"><?= $player->name ?></a></div>
        <div>(<a href="<?= base_url('profile') ?>/<?= $player->uid ?>"><?= $player->display_name ?></a>)</div>
    </span>
</div>
<div class="d-md-none">
    <a href="<?= base_url('character') ?>/<?= $player->character_uid ?>" class="btn btn-<?= $player->badge_color ?> badge badge-player">
        <div><?= $player->name ?></div>
        <div>(<?= $player->display_name ?>)</div>
    </a>
</div>
            <div class="division-section__vote">
                    <?php if ($votes) { ?>
                    <h2 id="<?= $anchor ?>" title="<?= $summary ?>"><?= $vote_title ?>: <?= count($votes) ?> <?= count($votes) == 1 ? 'MP' : 'MPs' ?></h2>
                    <ul class="division-dots">
                        <?php foreach ($votes as $vote) { ?>
                          <li class="people-list__person__party <?= strtolower($vote['party']) ?>"></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
            </div>

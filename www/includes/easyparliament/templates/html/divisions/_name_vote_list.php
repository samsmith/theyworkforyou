            <div class="division-section__vote">
                <?php if ($votes) { ?>
                    <h3><?= $vote_title ?>s: A-Z by last name</h3>
                    <?php
                        $tellers = array();
                    ?>
                    <ul class="js-vote-accordion">
                        <?php foreach ($votes as $vote) {
                          $voter = sprintf('<a href="/mp/?p=%d">%s</a>', $vote['person_id'], $vote['name']);
                          if ($vote['teller']) {
                              $tellers[] = $voter;
                          } else { ?>
                            <li><?= $voter ?> (<?= $vote['party'] ?>)</li>
                        <?php
                            }
                        } ?>
                    </ul>
                    <?php if (count($tellers) > 0) { ?>
                        <p>
                          Tellers: <?= implode(', ', $tellers) ?>
                        </p>
                    <?php
                    }
                } ?>
            </div>

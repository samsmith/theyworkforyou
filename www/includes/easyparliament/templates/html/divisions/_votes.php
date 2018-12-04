<?php
    $vote_sets = array(
        array(
          'title' => 'Aye',
          'anchor' => 'for',
          'thekey' => 'yes_votes',
        ),
        array(
          'title' => 'No',
          'anchor' => 'against',
          'thekey' => 'no_votes',
        ),
        array(
          'title' => 'Absent',
          'anchor' => 'absent',
          'thekey' => 'absent_votes',
        ),
        array(
          'title' => 'Abstained',
          'anchor' => 'both',
          'thekey' => 'both_votes',
        ),
    );

    foreach ($vote_sets as $i => $vote) { ?>
        <div class="division-result">
        <?php
            $vote_title = $vote['title'];
            $anchor = $vote['anchor'];
            $votes = $division[$vote['thekey'] . '_by_party'];
            $summary = $division['party_breakdown'][$vote['thekey']];
            include '_dot_vote_list.php';
        ?>
        </div>
    <?php }
    //unset($i); unset($vote);
    foreach ($vote_sets as $i => $vote) { ?>
        <div class="division-result">
        <?php
            $vote_title =  $vote['title'];
            $anchor = $vote['anchor'];
            $votes = $division[$vote['thekey']];
            include '_name_vote_list.php';
        ?>
        </div>

<?php } ?>

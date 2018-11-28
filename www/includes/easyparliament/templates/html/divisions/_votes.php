<div class="debate-speech">
    <div class="full-page__row">
<?php
    $groups = array(
        array(
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
        ),
        array(
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
        )
    );

    foreach ($groups as $group) {
?>

        <div class="full-page__unit">
            <div class="division-result">
            <?php
                $vote_title = $group[0]['title'];
                $anchor = $group[0]['anchor'];
                $votes = $division[$group[0]['thekey'] . '_by_party'];
                include '_dot_vote_list.php';

                $vote_title = $group[1]['title'];
                $anchor = $group[1]['anchor'];
                $votes = $division[$group[1]['thekey'] . '_by_party'];
                include '_dot_vote_list.php';
            ?>
            </div>
        </div>
    </div>
    <div class="full-page__row">
        <div class="full-page__unit">
            <div class="division-result">
            <?php
                $vote_title = $group[0]['title'];
                $anchor = $group[0]['anchor'];
                $votes = $division[$group[0]['thekey']];
                include '_name_vote_list.php';

                $vote_title = $group[1]['title'];
                $anchor = $group[1]['anchor'];
                $votes = $division[$group[1]['thekey']];
                include '_name_vote_list.php';
            ?>
            </div>
        </div>

<?php } ?>
    </div>
</div>
